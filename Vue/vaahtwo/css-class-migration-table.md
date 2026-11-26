# CSS Class Migration Table — v3 DOM → OpenVue v4 (R4.8)

**M3-T2 (F10) deliverable.** Produced as the Phase 0 gate for the frontend
slice: every v3 DOM class measured in this package (`packages/vaahcms/Vue/vaahtwo`)
gets a row with an occurrence count, the v4 replacement, and the file list.
The frontend rewrites (F11) are executed **against** this table.

Re-verify with (from the repo root):

```
grep -rc <class> packages/vaahcms/Vue/vaahtwo --include="*.vue"
grep -rE "p-button-sm|p-inputtext-sm|p-datatable-sm|p-inputswitch-sm|p-fluid|p-highlight|p-float-label|p-link" \
     packages/vaahcms/Vue/vaahtwo --include="*.vue"     # scenario 2 — zero
grep -rn "is-small" packages/vaahcms/Vue/vaahtwo --include="*.vue"     # scenario 3 — zero
```

## Status legend

- **MIGRATED (M3-T3)** — the class was already rewritten by the M3-T3
  (F11) global component-registry migration (size props, component renames,
  `rowHover` prop, `acceptProps`/`rejectProps`). The count at the time this
  table was authored (0) re-verifies that rewrite.
- **MIGRATED (F10)** — this task retired it: the 12 v3 density blocks in
  `scss/style/style.scss` and all 139 `.vue` usages of the VaahCMS-owned
  `is-small` class are replaced by the `vc-dense` semantic class, and the
  `p-float-label` selector is re-expressed as `p-floatlabel` in
  `style/style.scss` and `components/organisms/UsersForm.vue`.
- **REMAINING (F11)** — the v3 class still occurs in the template (counts
  below re-verified 2026-11-06); the row's replacement is the F11 rewrite.
  These are structural DOM classes (slots / containers), not size modifiers,
  so scenario 2's zero-hit grep does not gate them.

## Migration table

| v3 class | Baseline count (feature doc §6d) | Current count / files | v4 replacement | Status |
|---|---|---|---|---|
| `p-button-sm` | 495 / 105 | 0 / 0 | `size="small"` prop on `<Button>` (v4 emits `p-button-sm` from the prop — the class survives in the engine CSS as the size marker, never hand-written) | MIGRATED (M3-T3) |
| `p-inputtext-sm` | 144 / 41 | 0 / 0 | `size="small"` prop (v4 emits `p-inputfield-sm`) | MIGRATED (M3-T3) |
| `p-datatable-sm` | 31 / 29 | 0 / 0 | `size="small"` prop | MIGRATED (M3-T3) |
| `p-inputswitch-sm` | 5 / 5 | 0 / 0 | `size="small"` prop (`ToggleSwitch`) | MIGRATED (M3-T3) |
| `p-inputgroup` | 255 / 95 | 0 / 0 | `<InputGroup>` + `<InputGroupAddon>` components (the v4 DOM keeps the `p-inputgroup` container class — it now comes from the component, not the template) | MIGRATED (M3-T3) |
| `p-float-label` | 104 / 12 | 0 / 0 | `<FloatLabel>` component (renamed in M3-T3); the v4 DOM class is `p-floatlabel` — the two hand-written SCSS selectors re-expressed in F10 | MIGRATED (M3-T3 + F10 selectors) |
| `p-fluid` | 74 / 29 | 0 / 0 | `fluid` prop / `<Fluid>` wrapper | MIGRATED (M3-T3) |
| `p-datatable-hoverable-rows` | 13 / 12 | 0 / 0 (→ `rowHover` prop: 12 / 12) | **`rowHover` prop** — v4 emits the `p-datatable-hoverable` root class, styled by the OpenVue engine's `datatable.row.hover.*` tokens; **plus** the explicit local style below (the R4.8 "no documented equivalent" row, kept for the legacy class and as unlayered app CSS) | MIGRATED (M3-T3 prop; F10 local style) |
| `p-datatable-striped` | 10 / 10 | 10 / 10 | `stripedRows` prop (the `p-datatable-striped` class is retained in the v4 class map — the engine's striped rule keys on it, so direct usage renders correctly; F11 converts to the prop) | REMAINING (F11) |
| `p-datatable-responsive-scroll` | 10 / 10 | 0 / 0 | `scrollable` + `scrollHeight` props (v4 emits `p-datatable-scrollable`) | MIGRATED (M3-T3) |
| `p-datatable-tbody` | 9 / 9 | 9 / 9 | **retained in v4** — the v4 DOM still uses `p-datatable-tbody` (engine CSS keys on it); template slots that target it keep working. No rewrite required. | RETAINED (no-op) |
| `p-datatable-table` | 9 / 9 | 9 / 9 | **retained in v4** — same as above. No rewrite required. | RETAINED (no-op) |
| `p-input-icon-left` | 12 / 11 | 12 / 11 | v4 input icon **slots** (`<template #icon>` / `#icon-left` per component); the hand-rolled `<span class="p-input-icon-left">` markup in these files is F11's to move into slots | REMAINING (F11) |
| `p-input-icon-right` | 2 / 1 | 2 / 1 | v4 input icon **slots** | REMAINING (F11) |
| `p-container-message` | 12 / 12 | 12 / 12 | per-component message classes — v4's `Message` component renders its own `p-message` container; the hand-rolled `p-container-message` wrapper divs are F11's to drop or re-target | REMAINING (F11) |
| `p-container-toasts` | 2 / 2 | 2 / 2 | `p-toast-message` container classes — the v4 `<Toast>` component manages its own container; the two layout wrappers (`layouts/App.vue`, `layouts/AppExtended.vue`) are F11/F12's to reconcile | REMAINING (F11) |
| `p-link` | 1 / 1 | 0 / 0 | a `<Button>` in link mode (`link` prop) | MIGRATED (M3-T3) |
| `p-highlight` | 0 `.vue` / 5 `style.scss` | 0 / 0 | per-component selected classes (e.g. `.p-panelmenu-header-active`, `.p-steps-item-active`, `.p-togglebutton-checked`, `.p-datatable-row-selected`) — all 5 `style.scss` selector uses re-expressed in F10 | MIGRATED (F10) |
| `is-small` (VaahCMS density class, 12 blocks + 139 usages / 64 files) | 139 / 64 | 0 / 0 (→ `vc-dense`: 139 / 64) | **`vc-dense`** — the semantic density class, defined once in the token layer (`vaahvue/theme/openvue.js` preset `css` escape, values bound through `dt('vaah.density.*')`); the 12 v3 hand-port blocks in `scss/style/style.scss` are retired, not selector-rewritten | MIGRATED (F10) |

## `is-small` → `vc-dense` file list (64 files, 139 usages)

Converted 1:1 (class token replaced, no attribute/prop semantics touched):
`components/organisms/` — `NotificationSettings.vue` (6), `UpdateSettings.vue`
(1), `Account.vue` (2), `Migrate.vue` (2), `Configuration.vue` (2),
`UserSettings.vue` (2), `GeneralSettings.vue` (4), `Dependencies.vue` (9),
`UI-elements/Radio.vue` (1), `UI-elements/InputComponent.vue` (1),
`UI-elements/CheckboxComponent.vue` (1), `UI-elements/SwitchComponent.vue` (1);
`pages/ui/` — `Install.vue` (1), `Signin.vue` (2);
`pages/advanced/` — `logs/List.vue` (1), `logs/Item.vue` (2),
`failedjobs/List.vue` (1), `jobs/List.vue` (1), `batches/List.vue` (1);
`pages/settings/` — `user-settings/Index.vue` (7),
`general/components/SiteSettings.vue` (1), `general/Index.vue` (1),
`general/components/Securities.vue` (2), `general/components/MetaTags.vue` (2),
`env/Index.vue` (2), `update/Index.vue` (3), `general/components/DateTime.vue`
(3), `notifications/components/Index.vue` (10), `notifications/List.vue` (1);
`pages/roles/` — `List.vue` (1), `Item.vue` (1), `ViewUser.vue` (1), `Form.vue`
(1), `ViewPermission.vue` (6), `components/PermissionDetailsView.vue` (3),
`components/RoleUserDetailsView.vue` (3);
`pages/permissions/` — `ViewRole.vue` (1), `Item.vue` (1), `List.vue` (1),
`Form.vue` (1), `components/RoleDetasilsView.vue` (3);
`pages/public/setup/intall/` — `Migrate.vue` (6), `Index.vue` (1),
`Account.vue` (3), `Dependencies.vue` (5), `Configuration.vue` (8);
`pages/users/` — `Item.vue` (1), `List.vue` (1), `Form.vue` (1),
`ViewRole.vue` (1); `pages/modules/` — `List.vue` (1),
`components/Table.vue` (2); `pages/taxonomies/` — `List.vue` (1), `Item.vue`
(1), `Form.vue` (1); `pages/themes/` — `List.vue` (1), `components/Table.vue`
(1); `pages/registrations/` — `Item.vue` (1), `List.vue` (1), `Form.vue` (1);
`pages/media/` — `List.vue` (1), `Form.vue` (1), `Item.vue` (1).

Pre-existing defects carried over verbatim (flagged, not fixed — D3):
`pages/modules/components/Table.vue:111` carries the stray token on the
`size` attribute (`size="vc-dense mr-2"`); it was equally stray on `size`
before the rename (`size="is-small mr-2"`) and carries no styling in either
form. F11's `size` prop pass should normalize it to `size="small"` +
`class="mr-2 vc-dense"`.

## `p-datatable-hoverable-rows` — explicit local style + contrast audit

The one row that had no vendored replacement after the designer tree
(`primevue-tailwind-light/designer/components/data/_datatable.scss`) was
deleted. The affordance is **preserved** by an explicit local style in the
Vite graph — `scss/datatable-hover.scss` (imported by `scss/build.scss`,
present in the emitted `build/index.css`):

```css
.p-datatable.p-datatable-hoverable-rows .p-datatable-tbody > tr:not(.p-datatable-row-selected):hover,
.p-datatable.p-datatable-hoverable .p-datatable-tbody > tr:not(.p-datatable-row-selected):hover {
    background: var(--p-content-hover-background);
    color: var(--p-content-hover-color);
}
```

Values are the F09 `Nide` content-scheme tokens (scheme-aware via the
`.app-dark` dark-mode selector, so one rule serves both schemes):
hover background `surface-100` (light) / `surface-800` (dark), hover color
`surface-950` (light) / `surface-50` (dark). These are exactly the tokens the
OpenVue engine uses for the `rowHover`-driven `p-datatable-hoverable` rule
(`datatable.row.hover.background` / `datatable.row.hover.color`), so the
local style and the engine style agree.

**WCAG 1.4.11 (non-text contrast, 3:1) audit, both schemes** — the
state-identifying pair is the row text on its hover background:

| Scheme | Text | Background | Ratio | 3:1 |
|---|---|---|---|---|
| Light | `#0a0a0a` (surface-950) | `#f5f5f5` (surface-100) | **18.16:1** | pass |
| Dark | `#fafafa` (surface-50) | `#262626` (surface-800) | **14.50:1** | pass |

Note: the hover background against the static row background
(`#ffffff` / `#171717`) distinguishes the transient state at 1.09:1 (light)
/ 1.18:1 (dark) — below 3:1. That pair is a state *enhancement* (the
row's identifying elements — its text and cell borders — keep passing), so
the row is logged for F28 / R5.7's emitted-CSS contrast adjudication rather
than silently re-colored here.

## REMAINING (F11) file lists

- `p-datatable-striped` (10): `pages/settings/user-settings/Index.vue`,
  `pages/roles/Item.vue`, `pages/permissions/Item.vue`, `pages/users/ViewRole.vue`,
  `pages/users/Item.vue`, `pages/modules/Item.vue`, `pages/themes/Item.vue`,
  `pages/taxonomies/Item.vue`, `pages/registrations/Item.vue`,
  `pages/media/Item.vue`
- `p-datatable-tbody` (9) and `p-datatable-table` (9) — retained in v4, no
  rewrite (same 10-screen set minus `ViewRole.vue` for `tbody`/`table`):
  `pages/settings/user-settings/Index.vue`, `pages/roles/Item.vue`,
  `pages/permissions/Item.vue`, `pages/users/Item.vue`,
  `pages/modules/Item.vue`, `pages/taxonomies/Item.vue`,
  `pages/themes/Item.vue`, `pages/registrations/Item.vue`, `pages/media/Item.vue`
- `p-input-icon-left` (12 / 11): `components/organisms/GeneralSettings.vue`,
  `components/organisms/UI-elements/InputComponent.vue`,
  `components/organisms/UI-elements/MenubarComponent.vue`, `pages/ui/Extend.vue`,
  `pages/roles/ViewUser.vue`, `pages/roles/ViewPermission.vue`,
  `pages/permissions/ViewRole.vue`,
  `pages/settings/general/components/SocialMediaLink.vue`,
  `pages/users/ViewRole.vue`, `pages/modules/Install.vue`,
  `pages/themes/Install.vue`
- `p-input-icon-right` (2 / 1): `components/organisms/UI-elements/InputComponent.vue`
- `p-container-message` (12 / 12): `pages/settings/general/components/Securities.vue`,
  `pages/roles/Item.vue`, `pages/permissions/Item.vue`, `pages/users/Item.vue`,
  `pages/users/Form.vue`, `pages/modules/Item.vue`, `pages/themes/Item.vue`,
  `pages/taxonomies/Item.vue`, `pages/registrations/Item.vue`,
  `pages/registrations/Form.vue`, `pages/media/Form.vue`, `pages/media/Item.vue`
- `p-container-toasts` (2 / 2): `layouts/App.vue`, `layouts/AppExtended.vue`

## F14 (M4-T2) — auth-screen v3 variant classes

F14's feature doc (Risks) records five auth-screen sites that are not in
the v4 removed-classes list but whose v3 classes do not resolve in the
v4 pipeline (no engine, theme or app-CSS rule — the vendored v3 CSS was
retired in F10/M3-T2):

| Site | v3 class | v4 resolution | F14 decision (M4-T2) |
|---|---|---|---|
| `pages/public/Signin.vue` (forgot-password button) | `p-button-text` | dead class → default filled rendering (a v3→v4 rendering shift) | **converted to the `text` prop** (the v4 text variant — restores the v3 rendering; no written audit is affected) |
| `pages/public/Signup.vue` (sign-in button) | `p-button-text` | same | **converted to the `text` prop** |
| `pages/public/ForgotPassword.vue` (sign-in button) | `p-button-text` | same | **converted to the `text` prop** |
| `pages/public/ResetPassword.vue` (sign-in button) | `p-button-text` | same | **converted to the `text` prop** |
| `pages/public/Signin.vue` (max-attempts disabled Sign In button) | `p-button-danger` | dead class → default severity (a v3→v4 rendering shift) | **retained as the class (inert)**. F14 Scenario 6's audit requires zero `severity="danger"` attributes under `pages/public` + `pages/profile` and the 11-site repo-wide total to hold, so the prop conversion (`severity="danger"`) is deferred to F28's visual adjudication (the F14 risk mitigation path: render light + dark, convert only if the F28 baseline demands it). The 11 audited `severity="danger"` sites are untouched and still read `severity="danger"`. |

The in-scope `pages/public/setup/**` sites (`Index.vue` `p-button-danger` ×3 /
`p-button-text` ×1, `Migrate.vue` `acceptProps` `p-button-danger`) belong to
F15 (M4-T3) and are byte-identical to the pre-upgrade tree.

## M6-T3 (F22) — themes-surface v3 residue sites

Three themes-surface sites carried v3 residue the F11/F12/F14 passes left
for M6-T3 (F22 Verification items 2/3/4):

| Site | v3 residue | v4 resolution | M6-T3 decision |
|---|---|---|---|
| `pages/themes/Install.vue` (install-search field) | hand-rolled `<span class="p-input-icon-left">` icon (PrimeFlex v4 removed the utility — zero rules in the emitted CSS) | v4 icon-addon pattern: `<InputGroup>` > `<InputGroupAddon>` > `<i class="pi pi-search"/>` beside the input (documented PrimeVue v4 pattern; the engine `InputText` is a bare input with no icon prop/slot) | **converted to the addon pattern**; the inert `icon="search"` attribute stays exactly as under v3 (minimal diff) — this clears the F11 list's `p-input-icon-left` entry for `pages/themes/Install.vue` |
| `pages/themes/Item.vue` (deleted-theme banner) | `p-container-message` class on `<Message>` (zero rules in the emitted CSS) | v4 `Message` emits its own `p-message p-message-{severity}` root — no app-side container class exists in the v4 pipeline | **attribute dropped**; `severity="error"`, `:closable="false"`, `icon` and the absence of `life` (the area's no-op invariant) all retained — this clears the F11 list's `p-container-message` entry for `pages/themes/Item.vue` |
| `pages/themes/components/Table.vue` (refresh-migrations confirm, `confirmRefresh`) | the removed v3 accept-button class-string prop | `acceptProps: { severity: 'danger' }` — the v4 `severity` prop drives the `p-button-danger` class **and** the Nide danger tokens in both light and dark schemes | **converted** (F22 Scenario 4 target; the removed prop is never reintroduced; the object keeps the F12-approved `acceptProps` shape) |

Out of scope for M6-T3 (still open in the F11 ledger): the
`p-datatable-striped` wrapper on `pages/themes/Item.vue` and the
`p-datatable-tbody` / `p-datatable-table` classes (retained in v4 — see the
REMAINING (F11) lists above).

## Boundary notes

- **F10 owns**: the pipeline (this table + single canonical `build/index.css`
  via Vite), `is-small` → `vc-dense` (R4.3), the icon swap (R4.7), the
  `cssLayer` / `@layer reset, openvue` ordering (R3.10), and the re-expression
  of the five `p-highlight` selector uses inside `scss/style/style.scss`.
- **F11 owns**: the REMAINING (F11) rows above — slot/container rewrites and
  the `size` prop pass over the pre-existing defects flagged in the
  `vc-dense` file list.
- The baseline counts (feature doc §6d) predate M3-T3's component-registry
  migration; the "Current count" column is the re-verified state this table
  gates against.

## M5-T3 (F18) — roles & permissions screens

F18's Part-2 table is corrected and completed for the 18
`pages/roles/**` + `pages/permissions/**` SFCs. Every class→prop conversion
is **render-neutral**: the installed OpenVue 1.1.1 `BaseButton` `cx` mapping
emits the identical DOM class set the hand-written v3 classes produced, so
no F28 visual baseline is affected.

| Site | v3 class | v4 resolution | M5-T3 decision |
|---|---|---|---|
| 2× `Item.vue` detail-table wrapper | `p-datatable-striped` | **dead** — zero rules in the emitted `build/index.css` (correcting the F10 table note "retained in v4 class map" — verified false) | dropped; wrapper keeps `p-datatable p-component` (both live: `p-component` carries `width:max-content!important`) |
| 2× `Item.vue` inline trash banner | `p-container-message` on `<Message>` | dead (zero rules) | dropped; banner keeps `severity="error" :closable="false"`, no `life` (F18 Part 3: in-flow banners are the documented exception to the toast-`life` rule) |
| 3× search field (`ViewPermission`, `ViewUser`, `ViewRole`) | `<span class="p-input-icon-left"><i/><InputText/></span>` | `p-input-icon-left` is live only as a margin helper; v4 pattern is an addon inside the group | `<InputGroupAddon><i class="pi pi-search" /></InputGroupAddon>` + the `InputText`, both inside the pre-existing `<InputGroup>` (InputText exposes no icon slot; the engine styles `.p-inputgroup-addon`) |
| 12× `Button` | `p-button-text` | dead outside the datatable-scoped hover rule | `text` prop |
| 23× `Button` | `p-button-rounded` | dead (zero rules) | `rounded` prop |
| 2× `Button` | `p-button-outlined` | styled only via the severity-var system | `outlined` prop |
| 10× `Button` | `p-button-success` | styled (severity vars, light + dark) | `severity="success"` prop (same emitted classes) |
| 10× `Button` | `p-button-danger` | styled (severity vars, light + dark) | `severity="danger"` prop — **the prop is the v4-valid `danger` severity, so the "never rename `severity=danger`" invariant holds**: both `Badge severity="danger"` sites (`roles/components/Table.vue`, `permissions/components/Table.vue`) are untouched |
| 12× `Button` | `p-button-tiny` | **live** — engine class map keeps `.p-button-tiny` for the datatable font-size rule `.p-datatable .p-button:not(.p-button-tiny){font-size:.6rem}` | **retained as the class** — there is no v4 `size` value `tiny` (prop is `small`/`large` only); converting would change the rendered size |
| `ViewPermission.vue` confirm dialog | `acceptProps: { class: 'p-button p-button-danger vc-dense' }` | n/a — already the M3-T4 (F12) `acceptProps`/`rejectProps` conversion shape | untouched (the centralized conversion owns these sites) |

R5.11 density (14px / 36px / 32px / 8px): no new tokens — the F09 preset layer
(`vaahvue/theme/openvue.js` `vaah.density.*` + the `openvue-density.scss`
escape) already covers the matrix; the `.vc-dense` panel rule (no `sm`
exclusion) keeps the `size="small"` matrix toggle buttons at 36px, and
`.p-datatable .p-datatable-tbody tr { height:32px }` covers row height.
Slug columns keep their `p-button-tiny` copy buttons and show no truncation
(`white-space-nowrap` retained).

F18 Part 1 (parity artefact): `packages/vaahcms/Tests/parity/` —
`export-roles-permissions-parity.php` (pure static analysis of the seeder
JSONs, the controller guard vocabulary, and the two route files),
`roles-permissions-parity.before.json` (pre-upgrade baseline `7fe711a`) and
`roles-permissions-parity.after.json` (this tree) are byte-identical;
`tests/Feature/RolesPermissionsParityTest.php` pins the diff, the 7-role /
76-permission structure, the 8 guard slugs' exact route lists, and the
exporter's determinism. Part 5 (R2.7): the `concat()` hunks at
`RoleBase.php:463-464` / `:811-812` are untouched (verified against baseline).
Part 4: the `ViewPermission` matrix is already the v4 `DataTable`
(`scrollable`, no `scrollHeight` needed — 76 rows, no `filter`, no
`editMode`/`virtualScrollerOptions`/`stateStorage`/`rowGroupMode` anywhere in
the 18 SFCs); the `Item.vue` detail tables remain hand-written markup (the
component's slot API cannot render key/value `VhViewRow` rows) — the
"kept hand-written, choice recorded" branch of F18 Part 4.

## M5-T4 (F19) — taxonomies screens

F19's Part-3 inventory for the nine taxonomy screens is **fully paid**: the
v3 class names and the v3 component tags are gone, and every conversion is
**render-neutral or render-corrective** — no taxonomy behaviour, route,
controller or data-model semantics changed (D3), and the **nesting
semantics are untouched**: the taxonomy-type manager is still the draggable,
droppable, deletable tree over the eager-loaded type list.

| Site | v3 class / tag | v4 resolution | M5-T4 decision |
|---|---|---|---|
| 10× `p-inputgroup` (`Form.vue` ×2, `Actions.vue`, `List.vue`, `Item.vue`, `Table.vue`, `TaxonomyTypeModal.vue`, `TaxonomiesModal.vue`, `pages/ui/Taxonomies.vue`) | hand-written `<div class="p-inputgroup">` wrappers | dead as a wrapper — the v4 `InputGroup` component renders the group itself | rewritten as the component-driven `<InputGroup>` structure (10 sites across 8 files); **the markup carries no `p-inputgroup` class** — the only remaining occurrences are the scoped selectors that target the *engine's* own `.p-inputgroup` (`List.vue`, the 375px header-cluster rule) |
| 23× `p-button-sm` | dead (v4 sizes by the `size` prop) | `size="small"` | migrated before this task; **0 remaining** |
| 6× `p-inputtext-sm` | dead | `size="small"` | migrated before this task; **0 remaining** |
| 7× `p-float-label` | dead (v4 `FloatLabel` is a component) | `<FloatLabel>` | migrated before this task; **0 remaining** |
| 1× `p-fluid` | dead (v4 `Fluid` is a component) | `<Fluid>` | migrated before this task; **0 remaining** |
| 2× `p-datatable-sm` | dead | `size="small"` | migrated before this task; **0 remaining** |
| 1× `p-datatable-striped` (`Item.vue` view-table wrapper) | **dead** — zero rules in the emitted `build/index.css`; the v4 engine keys the stripe on the row class *it* emits (`tr.p-row-odd`), so a class on the wrapper matched nothing and the hand-rolled view table rendered flat | the stripe's value lives in the token `--p-datatable-row-striped-background` | **explicit local replacement** (the F21 / M6-T2 pattern, `pages/modules/Item.vue`): the wrapper keeps `p-datatable p-component` and gains `taxonomies-item-stripes`, and a scoped rule binds `tr:nth-child(odd)` to `var(--p-datatable-row-striped-background)` — measured `rgb(250,250,250)` light / a 30 %-alpha surface dark, the same value the engine's own `stripedRows` rows use |
| 1× `p-datatable-responsive-scroll` (`Item.vue`) | dead | `scrollable` on the `DataTable` | migrated before this task; **0 remaining** |
| 1× `p-datatable-hoverable-rows` (`Table.vue`) | dead | `rowHover` prop | migrated before this task; **0 remaining** |
| 1× `severity="danger"` (`Table.vue`, the "Trashed" marker) | **live** — the v4 Badge severity set is *secondary · info · success · warn · danger · contrast* | `severity="danger"` | **kept** — the badge is a Badge, and `danger` is a valid v4 Badge severity; renaming it to `error` would render an unstyled badge (the invariant "never rename `severity="danger"`") |
| 3× `<Dropdown>`, 1× `<InputSwitch>`, 1× `<Sidebar>`, 1× `<Chips>` | v3 component names | `Select`, `ToggleSwitch`, `Drawer`, `AutoComplete` | migrated before this task; **0 remaining** |
| 1× `p-container-message` (`Item.vue`, the deleted-record banner) | **dead** — zero rules in the emitted CSS | the class carries no styling | dropped — the same decision M5-T3 (F18) took for the roles screens; the banner keeps `severity="error" :closable="false"` and no `life` (an in-flow banner is the documented exception to the toast-`life` rule) |
| the v3 toggle-switch override block (`Table.vue`) | **dead** — v4 emits `p-toggleswitch*`, so the v3 selectors styled nothing — and **unscoped**, so it leaked four raw hex literals into the global stylesheet | the checked slider is the semantic success token (light `rgb(21,128,61)` / dark `rgb(74,222,128)`, scheme-aware) | **removed, not re-tokenized** — the checked green comes from the theme + `scss/style/style.scss` (UT-9, M6-T4a), exactly as on the peer surfaces; this paid the task's 4 `raw-hex` violations |
| `p-button-primary` (2×), `p-button-rounded` (1×), `p-button-secondary` / `p-button-outlined` (1×) | `p-button-primary` and `p-button-rounded` have **zero rules** in the built CSS; `p-button-outlined` (7) and `p-button-secondary` (3) are live | the v4 `rounded` prop is **inert too** (no `.p-button-rounded` rule, no rounded token) | **kept as-is** — the classes are inert in both spellings, so converting them would change no pixel; the default button is already the primary one. Documented here so the next reader does not re-open the question |

## M7-T2 (F25) — profile surface

F25 is a **parity-verification** task: the profile surface (`pages/profile/index.vue`
+ `components/FileUploader.vue`) was already at its F11/OpenVue target state from
M3-T3. This section records what the verification found and what it changed —
four off-scale type sites, two wrong testids, and three engine behaviours
confirmed against the installed `openvue@1.1.1` source.

| Site | v3 / dead | v4 resolution | M7-T2 decision |
|---|---|---|---|
| 4× `<p class="text-sm">` (avatar / profile-details / MFA / password notes) | off-scale — PrimeFlex `text-sm` = 12.25px at the 14px root, not on the 12·13·14·16·20·24 scale | `vaah-type-secondary` — 13px `var(--p-text-muted-color)`, the type-layer role for muted body copy | **replaced** — the four sites are secondary (muted) copy, matching the settings-screen precedent (M6-T4). Measured live: **13px / rgb(107,107,107)** light, **13px / rgb(161,161,161)** dark — the muted token flips correctly |
| `size="small"` on 4 Buttons + the country AutoComplete + the timezone Select | R3.5 target spelling (already v4) | the v4 `size` prop | **kept, verified parity-safe** — the `p-*-sm` classes render at the **same 12.25px / 36px** as the un-sized inputs in this 14px-root theme, so the attribute introduces no visual delta and no off-scale value. The feature doc's AutoComplete `size` risk was resolved live (the country input carries `p-inputtext-sm p-inputfield-sm`) |
| `data-testid="profile-save"` on **two** elements (the Save Profile button *and* the avatar Remove button) | the duplicate M4-T1's 105-SFC audit flagged in this area | one id per action | the Remove button is now **`profile-remove_avatar`** (Save Profile keeps `profile-save`) — screen-prefixed, lowercase-hyphenated, matching the app convention |
| `data-testid="register-country"` on the country-code AutoComplete | a copy of the *registration* screen's id | field-name symmetry | **`profile-country_calling_code`** — the field name, symmetric with `register-country_calling_code` |
| the three Password fields' `data-testid` | a raw `data-testid` attr on `<Password>` is **silently dropped** — the attr must ride the child InputText's `pt` `root` section | `:pt="{ pcInputText: { root: { 'data-testid': … } } }"` | **nested under `root`** — verified live: all three testids now land on the inner `<input>` (`profile-current_password` / `profile-new_password` / `profile-confirm_password`) |
| the FileUpload's `data-testid` | same `pt` contract, but the `input` section is a **raw element** (not a child component) | `:pt="{ input: { 'data-testid': … } }"` | binds directly — verified live on the hidden `<input type="file">` (`profile-avatar-upload`) |
| the feature doc's FileUpload risk note (`:customUpload` / `:showUploadButton` / `:showCancelButton` "not v4 props") | stale | the installed engine | **the props are valid in `openvue@1.1.1`** (`fileupload/BaseFileUpload.vue`) and the `@uploader` custom-upload flow works — **kept unchanged** (D3); do not "fix" them |
| `severity="danger"` / `acceptClass` / a `primevue` import | the three invariants | — | **0 in the profile area** (the surface is clean; nothing renamed, nothing reintroduced) |
