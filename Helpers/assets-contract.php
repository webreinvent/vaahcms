<?php

/**
 * F06 / R5.10 — the third-party module/theme asset contract.
 *
 * The upgraded admin ships OpenVue v4 CSS only. A module or theme bundle
 * must be rebuilt against OpenVue, must declare a `Config/assets.php`
 * manifest (openvue_version, primevue_version, css_prefix, css/js lists),
 * and must emit its rules only under the core-provided scope
 * (`p-vc-module-<slug>` / `p-vc-theme-<slug>`). The activation gate in
 * `ModuleBase::activateItem()` / `ThemeBase::activateItem()` runs these
 * checks BEFORE migrations/seeds/asset-copy, so a detected PrimeVue 3
 * bundle is refused with no side effects.
 */

/**
 * Build markers: classes that exist in PrimeVue 3 and were removed or
 * repurposed in v4, together with the PrimeVue 3 runtime marker.
 */
function vh_primevue3_build_markers()
{
    return [
        'p-inputtext-sm',
        'p-datatable-hoverable-rows',
        'p-fluid',
        'p-datatable-responsive-scroll',
        'p-float-label',
    ];
}

/**
 * Scan one compiled CSS/JS file for PrimeVue 3 markers.
 *
 * CSS files are scanned for the build-marker classes; JS bundle chunks are
 * additionally scanned for the runtime marker `primevue`. Returns the list
 * of markers found (empty when the file is clean).
 *
 * @return array<int, string>
 */
function vh_detect_primevue3_markers_in_file(string $file): array
{
    $content = @file_get_contents($file);

    if($content === false)
    {
        return [];
    }

    $found = [];
    foreach (vh_primevue3_build_markers() as $marker)
    {
        if(str_contains($content, $marker))
        {
            $found[] = $marker;
        }
    }

    if(strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'js'
        && str_contains($content, 'primevue'))
    {
        $found[] = 'primevue (runtime marker)';
    }

    return $found;
}

/**
 * Scan a published/source assets directory for PrimeVue 3 markers in its
 * compiled CSS/JS. Returns a list of `['file' => relative path, 'marker'
 * => marker]` hits (empty when the directory is missing or clean).
 *
 * @return array<int, array{file: string, marker: string}>
 */
function vh_detect_primevue3_assets(string $assets_dir): array
{
    $hits = [];

    if(!is_dir($assets_dir))
    {
        return $hits;
    }

    foreach (\File::allFiles($assets_dir) as $file)
    {
        if(!in_array(strtolower($file->getExtension()), ['css', 'js']))
        {
            continue;
        }

        foreach (vh_detect_primevue3_markers_in_file($file->getPathname()) as $marker)
        {
            $hits[] = [
                'file' => $file->getRelativePathname(),
                'marker' => $marker,
            ];
        }
    }

    return $hits;
}

/**
 * Validate the declared `Config/assets.php` manifest, when one is declared.
 *
 * 3.0 contract: `primevue_version` must be `null` (no PrimeVue 3 runtime)
 * and `css_prefix` must be the core-provided scope for this slug. A missing
 * manifest file is not an error by itself — the marker scan still applies
 * (existing extensions keep loading unchanged until their bundle is
 * rebuilt).
 *
 * @return array<int, string>
 */
function vh_validate_asset_manifest(string $manifest_path, string $slug, string $expected_prefix, string $kind): array
{
    $errors = [];

    if(!is_file($manifest_path))
    {
        return $errors;
    }

    try
    {
        $manifest = require $manifest_path;
    }
    catch (\Throwable $e)
    {
        // a broken manifest (e.g. a PHP syntax error) is a contract
        // violation — refuse with the same shape, never 500 mid-activation
        $errors[] = sprintf(
            '%s "%s" declares a broken Config/assets.php manifest (%s); the asset manifest must load and return an array.',
            ucfirst($kind),
            $slug,
            $e->getMessage()
        );
        return $errors;
    }

    if(!is_array($manifest))
    {
        $errors[] = sprintf(
            '%s "%s" declares a Config/assets.php manifest that does not return an array.',
            ucfirst($kind),
            $slug
        );
        return $errors;
    }

    if(array_key_exists('primevue_version', $manifest) && $manifest['primevue_version'] !== null)
    {
        $errors[] = sprintf(
            '%s "%s" declares primevue_version "%s" in its asset manifest; the 3.0 admin ships OpenVue v4 CSS only, so primevue_version must be null and the bundle must be rebuilt against OpenVue.',
            ucfirst($kind),
            $slug,
            (string)$manifest['primevue_version']
        );
    }

    if(array_key_exists('css_prefix', $manifest) && $manifest['css_prefix'] !== $expected_prefix)
    {
        $errors[] = sprintf(
            '%s "%s" declares css_prefix "%s" in its asset manifest; its CSS rules must be scoped under the core-provided prefix "%s".',
            ucfirst($kind),
            $slug,
            (string)$manifest['css_prefix'],
            $expected_prefix
        );
    }

    return $errors;
}

/**
 * The activation gate: all contract errors for one module/theme base path.
 *
 * Runs the manifest validation (when a manifest is declared) and the
 * PrimeVue 3 marker scan of the source assets directory. Each returned
 * string is a complete, admin-ready refusal message naming the slug and
 * the required OpenVue rebuild.
 *
 * @return array<int, string>
 */
function vh_asset_contract_errors(string $base_path, string $slug, string $css_prefix, string $kind): array
{
    $errors = vh_validate_asset_manifest(
        $base_path.'/Config/assets.php',
        $slug,
        $css_prefix,
        $kind
    );

    foreach (vh_detect_primevue3_assets($base_path.'/Resources/assets') as $hit)
    {
        $errors[] = sprintf(
            '%s "%s" targets PrimeVue 3 (marker "%s" in %s) and must be rebuilt against OpenVue — the 3.0 admin ships OpenVue v4 CSS only.',
            ucfirst($kind),
            $slug,
            $hit['marker'],
            $hit['file']
        );
    }

    return $errors;
}
