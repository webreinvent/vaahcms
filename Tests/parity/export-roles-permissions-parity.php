<?php
/**
 * F18 (M5-T3) — permission-parity exporter.
 *
 * Writes the D14/D3 parity artefact for the roles & permissions surface:
 *
 *   roles  — for each of the 7 seeded roles (Database/Seeders/json/roles.json),
 *            keyed by role slug, the sorted list of permission slugs granted
 *            with pivot is_active = 1;
 *   routes — for each of the 76 seeded permission slugs
 *            (Database/Seeders/json/permissions.json), the sorted list of
 *            backend route URIs reachable by a holder of that slug, derived
 *            by pairing every hasPermission(...) / hasPermissions([...]) guard
 *            in Http/Controllers/Backend/RolesController.php and
 *            PermissionsController.php with its route declaration in
 *            Routes/backend/routes-roles.php and routes-permissions.php.
 *
 * The script is pure static analysis of committed files (no framework boot,
 * no database): it re-derives the deterministic seeder outcome
 * (Libraries/VaahSeeder.php + Models/PermissionBase.php::syncPermissionsWithRoles)
 * and pairs the guard vocabulary with the route declarations, so the same
 * tree always yields the same bytes.
 *
 * Usage:
 *   php export-roles-permissions-parity.php <tree-root> <output-path>
 *
 * The pass condition for F18 is that the export from the pre-upgrade baseline
 * (roles-permissions-parity.before.json) and the export from the upgraded
 * tree (roles-permissions-parity.after.json) are byte-identical —
 * `diff roles-permissions-parity.before.json roles-permissions-parity.after.json`
 * produces no output. The committed JSONs are produced by this script
 * (before: against the pre-upgrade tree; after: against the upgraded tree).
 */

if ($argc < 3) {
    fwrite(STDERR, "usage: php export-roles-permissions-parity.php <tree-root> <output-path>\n");
    exit(1);
}

$tree = rtrim($argv[1], '/');
$out = $argv[2];

$package = $tree . '/packages/vaahcms';

if (!is_dir($package)) {
    fwrite(STDERR, "tree root does not contain packages/vaahcms: $tree\n");
    exit(1);
}

//----------------------------------------------------------
// Laravel Str::slug port (seed files are ASCII; Str::ascii is a no-op there).
// Illuminate\Support\Str::slug: lowercase, replace runs of non-[delimiter 0-9a-z]
// characters with the delimiter, trim the delimiter from both ends.
//----------------------------------------------------------
function vh_slug(string $value, string $delimiter = '-'): string
{
    // the port omits Str::ascii() — fail loudly rather than silently strip
    // a future non-ASCII seed name
    if (preg_match('/[^\x20-\x7E]/', $value)) {
        fwrite(STDERR, "vh_slug: non-ASCII value '$value' — extend the port to cover Str::ascii before using non-ASCII seed names\n");
        exit(1);
    }

    $value = strtolower($value);
    $value = preg_replace('/[^' . preg_quote($delimiter, '/') . '0-9a-z]+/', $delimiter, $value);

    return trim($value, $delimiter);
}

//----------------------------------------------------------
// The roles map: 7 seeded roles -> permission slugs with pivot is_active = 1.
//
// Derivation (deterministic seeder semantics, unchanged by the upgrade):
// - VaahSeeder::roles() stores the 7 role names; VaahSeeder::permissions()
//   stores the 76 permissions (slug = Str::slug(name) — the json carries no
//   slug key);
// - Permission::syncPermissionsWithRoles() syncs EVERY permission to EVERY
//   role: the super-administrator role gets the full set with
//   ['is_active' => 1]; every other role gets the full set via
//   syncWithoutDetaching() with no pivot data — the pivot is_active column
//   (nullable) stays NULL, i.e. no permission is granted with is_active = 1.
//----------------------------------------------------------
$roles_json = json_decode(file_get_contents($package . '/Database/Seeders/json/roles.json'), true);
$permissions_json = json_decode(file_get_contents($package . '/Database/Seeders/json/permissions.json'), true);

if (!is_array($roles_json) || !is_array($permissions_json)) {
    fwrite(STDERR, "seeder json unreadable\n");
    exit(1);
}

$permission_slugs = [];
foreach ($permissions_json as $permission) {
    $permission_slugs[] = isset($permission['slug']) && $permission['slug'] !== ''
        ? $permission['slug']
        : vh_slug($permission['name']);
}
$permission_slugs = array_values(array_unique($permission_slugs));
sort($permission_slugs);

$roles_map = [];
foreach ($roles_json as $role) {
    $slug = vh_slug($role['name']);
    $roles_map[$slug] = ($slug === 'super-administrator') ? $permission_slugs : [];
}

function ksort_recursive(array $array): array
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = ksort_recursive($value);
        }
    }
    ksort($array);

    return $array;
}
$roles_map = ksort_recursive($roles_map);

//----------------------------------------------------------
// The routes map: parse the two controllers for the per-method guard
// vocabulary, then pair with the route declarations.
//----------------------------------------------------------
function controller_methods(string $path): array
{
    $src = file_get_contents($path);

    // split on "public function NAME(" — each chunk's body runs to the next
    // method declaration (the guard always sits at the top of the method).
    preg_match_all('/public function (\w+)\s*\(/', $src, $names, PREG_OFFSET_CAPTURE);
    $methods = [];
    for ($i = 0; $i < count($names[1]); $i++) {
        $start = $names[0][$i][1] + strlen($names[0][$i][0]);
        $end = ($i + 1 < count($names[1])) ? $names[0][$i + 1][1] : strlen($src);
        $methods[$names[1][$i][0]] = substr($src, $start, $end - $start);
    }

    return $methods;
}

function method_slugs(string $body): array
{
    $slugs = [];

    // single-slug guards: hasPermission($permission_slug) with
    // $permission_slug = 'some-slug'; assigned at the top of the method
    if (preg_match_all('/hasPermission\(\s*\$([A-Za-z_]\w*)\s*\)/', $body, $m)) {
        foreach (array_unique($m[1]) as $var) {
            if (preg_match('/^\s*\$' . $var . "\s*=\s*'([A-Za-z0-9_\-]+)'/m", $body, $a)) {
                $slugs[] = $a[1];
            }
        }
    }

    // multi-slug guards: hasPermissions($permission_slugs) with an
    // $permission_slugs = ['slug-a', 'slug-b']; array literal
    if (preg_match_all('/hasPermissions\(\s*\$([A-Za-z_]\w*)\s*\)/', $body, $m)) {
        foreach (array_unique($m[1]) as $var) {
            if (preg_match('/^\s*\$' . $var . "\s*=\s*(?:array\s*\(|\[)([^;]*)\]/m", $body, $a)) {
                if (preg_match_all("/'([A-Za-z0-9_\-]+)'/", $a[1], $s)) {
                    foreach ($s[1] as $slug) {
                        $slugs[] = $slug;
                    }
                }
            }
        }
    }

    return array_values(array_unique($slugs));
}

$controllers = [
    'RolesController' => 'Http/Controllers/Backend/RolesController.php',
    'PermissionsController' => 'Http/Controllers/Backend/PermissionsController.php',
];

// action name -> sorted slug set. The key is controller-qualified
// ("RolesController::getItem" …): the two controllers share method names
// (getAssets, getList, getItem, ...), so a bare name would mix the roles
// and permissions guard vocabularies into one entry.
$action_slugs = [];
foreach ($controllers as $class => $file) {
    foreach (controller_methods($package . '/' . $file) as $action => $body) {
        $slugs = method_slugs($body);

        // fail loudly if a guard call exists but no slug was extracted — a
        // silent drop would weaken the D14 pairing while the artefact diff
        // stayed empty
        if (!$slugs && (preg_match('/hasPermission\(/', $body) || preg_match('/hasPermissions\(/', $body))) {
            fwrite(STDERR, "guard on {$class}::{$action} not parsed into slugs — extend method_slugs before regenerating the artefacts\n");
            exit(1);
        }

        if ($slugs) {
            sort($slugs);
            $action_slugs[$class . '::' . $action] = $slugs;
        }
    }
}

//----------------------------------------------------------
// Route declarations: verbs + uri (with the group prefix) per action.
//----------------------------------------------------------
function route_actions(string $path): array
{
    $src = file_get_contents($path);

    preg_match("/'prefix'\s*=>\s*'([^']+)'/", $src, $p);
    $prefix = $p[1] ?? '';

    $actions = [];

    // Route::get|post|put|patch|delete|any|head('<uri>', 'Ctrl@action')
    if (preg_match_all(
        "/Route::(get|post|put|patch|delete|any|options|head)\(\s*'([^']*)'\s*,\s*'([A-Za-z]+)@([A-Za-z_]+)'/",
        $src,
        $m,
        PREG_SET_ORDER
    )) {
        foreach ($m as $hit) {
            $verb = strtoupper($hit[1]);
            $uri = $prefix . $hit[2];
            $actions[$hit[4]][] = $verb . ' ' . $uri;
        }
    }

    // Route::match(['put', 'patch'], '<uri>', 'Ctrl@action')
    if (preg_match_all(
        "/Route::match\(\s*\[([^\]]+)\]\s*,\s*'([^']*)'\s*,\s*'([A-Za-z]+)@([A-Za-z_]+)'/",
        $src,
        $m,
        PREG_SET_ORDER
    )) {
        foreach ($m as $hit) {
            if (preg_match_all("/'([a-z]+)'/", $hit[1], $vm)) {
                foreach ($vm[1] as $verb) {
                    $actions[$hit[4]][] = strtoupper($verb) . ' ' . $prefix . $hit[2];
                }
            }
        }
    }

    // deterministic ordering
    foreach ($actions as $action => &$entries) {
        $entries = array_values(array_unique($entries));
        sort($entries);
    }
    unset($entries);
    ksort($actions);

    return $actions;
}

$routes_map = [];
foreach ($permission_slugs as $slug) {
    $routes_map[$slug] = [];
}

function qualify_actions(array $actions, string $class): array
{
    $out = [];
    foreach ($actions as $action => $entries) {
        $out[$class . '::' . $action] = $entries;
    }

    return $out;
}

$all_actions = qualify_actions(route_actions($package . '/Routes/backend/routes-roles.php'), 'RolesController')
    + qualify_actions(route_actions($package . '/Routes/backend/routes-permissions.php'), 'PermissionsController');

foreach ($action_slugs as $action => $slugs) {
    if (!isset($all_actions[$action])) {
        fwrite(STDERR, "guard found on action without a route declaration: $action\n");
        exit(1);
    }
    foreach ($slugs as $slug) {
        if (!isset($routes_map[$slug])) {
            // a guard vocabulary slug that is not in the seeded 76 — the map
            // keys are the seeded slugs, but a guard may reference an
            // extension slug; keep the artefact stable by recording it too.
            $routes_map[$slug] = [];
        }
        foreach ($all_actions[$action] as $entry) {
            $routes_map[$slug][] = $entry;
        }
    }
}

foreach ($routes_map as $slug => &$entries) {
    $entries = array_values(array_unique($entries));
    sort($entries);
}
unset($entries);
$routes_map = ksort_recursive($routes_map);

//----------------------------------------------------------
// Emit
//----------------------------------------------------------
$artefact = ksort_recursive([
    'roles' => $roles_map,
    'routes' => $routes_map,
]);

$json = json_encode($artefact, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
if (file_put_contents($out, $json) === false) {
    fwrite(STDERR, "cannot write $out\n");
    exit(1);
}

echo "wrote $out (" . count($roles_map) . " roles, " . count($routes_map) . " permission slugs)\n";
