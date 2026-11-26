// M3-T1 (F09) — token API contract (R4.4, scenario 8), per the llmkb
// `openvue-v1-docs` contract:
//   - $dt('primary.color') resolves against the installed preset and returns
//     { name, variable, value } — a scheme-dependent token carries
//     value = { light: {…}, dark: {…} };
//   - updateSurfacePalette({ light: … }) changes the light surfaces only and
//     leaves the dark surfaces at their previous values (and the mirror) —
//     documented contract; see KNOWN DIVERGENCE below for the installed
//     1.1.1 engine, whose Section-3 pin is what this script asserts.
// Run with `node scripts/verify-token-api.mjs` (or `npm run verify-token-api`).
//
// KNOWN DIVERGENCE (recorded in llmkb-reviews/M3-T1.md): the installed
// @openuxkit/styled 1.1.1 engine violates the documented one-sided
// contract — with `s = { light: map }` the engine computes the dark side as
// the RAW ARGUMENT (`n = hasOwn(s,'dark') ? s.dark : s`) and REPLACES
// semantic.colorScheme.dark.surface with it. The other scheme's surface
// tokens then resolve from junk `surface.light.*` paths. The flat map and
// the paired `{ light, dark }` forms behave correctly.
//
// Section 3 therefore PINS the as-installed behavior (upstream bug made
// explicit) rather than asserting the documented contract — the script must
// exit 0 against 1.1.1, and it fails loudly if the engine is ever fixed or
// regresses: re-verify against the documented contract at that point and
// flip the pin back. App code must not call updateSurfacePalette with a
// one-sided object until then — M6-T4/F23 (the toggle UI) uses the paired
// or flat form.

import { $dt, useTheme, updateSurfacePalette } from '@openvue/themes'
import { VaahPreset, THEME_OPTIONS } from '../vaahvue/theme/openvue.js'

const failures = []

function check(label, ok, detail) {
    if (ok) {
        console.log(`  ok — ${label}`)
    } else {
        failures.push(`${label}${detail ? ` (${detail})` : ''}`)
    }
}

function installFresh() {
    useTheme({ preset: VaahPreset, options: THEME_OPTIONS })
}

installFresh()

// ---------------------------------------------------------------------------
// 1. $dt resolution shape
// ---------------------------------------------------------------------------

const primary = $dt('primary.color')
console.log(`$dt('primary.color') → ${JSON.stringify(primary)}`)
check(
    'primary.color resolves with the full { name, variable, value } shape',
    Boolean(primary) &&
        typeof primary.name === 'string' &&
        typeof primary.variable === 'string' &&
        primary.value !== undefined,
    JSON.stringify(primary)
)
// the docs example prints an unprefixed name; with prefix 'p' (THEME_OPTIONS)
// the engine prefixes both, which is the consistent behaviour
check(
    'name + variable carry the configured "p" prefix',
    primary.name === '--p-primary-color' &&
        primary.variable === 'var(--p-primary-color)',
    `name=${primary.name} variable=${primary.variable}`
)
check(
    'scheme-dependent token carries light + dark values',
    primary.value &&
        primary.value.light &&
        primary.value.dark &&
        typeof primary.value.light.value === 'string' &&
        typeof primary.value.dark.value === 'string',
    JSON.stringify(primary.value)
)

// a scheme-independent token must NOT report light/dark buckets
const density = $dt('vaah.density.baseText')
console.log(`$dt('vaah.density.baseText') → ${JSON.stringify(density)}`)
check(
    'vaah.density.baseText resolves through the extend namespace',
    density &&
        density.name === '--p-vaah-density-base-text' &&
        density.variable === 'var(--p-vaah-density-base-text)',
    JSON.stringify(density)
)
check(
    'scheme-independent token resolves to a flat value (no light/dark split)',
    density &&
        !(density.value && typeof density.value === 'object' && 'light' in density.value)
)

// ---------------------------------------------------------------------------
// 2. paired { light, dark } update — the safe form the engine honours
// ---------------------------------------------------------------------------

installFresh()
updateSurfacePalette({ light: { 900: '#101418' }, dark: { 900: '#303030' } })
const paired = $dt('surface.900')
console.log(`paired → ${JSON.stringify(paired.value)}`)
check(
    'paired update re-paints light surface.900',
    paired.value && paired.value.light && paired.value.light.value === '#101418',
    JSON.stringify(paired.value && paired.value.light)
)
check(
    'paired update re-paints dark surface.900',
    paired.value && paired.value.dark && paired.value.dark.value === '#303030',
    JSON.stringify(paired.value && paired.value.dark)
)

// ---------------------------------------------------------------------------
// 3. one-sided { light } update — PINNED as-installed engine behavior
//    (@openuxkit/styled 1.1.1), with the upstream bug made explicit.
//
//    The documented contract: a one-sided update leaves the other scheme at
//    its previous values. The installed engine does NOT — it replaces
//    semantic.colorScheme.dark.surface with the raw light argument, so the
//    dark surface.900 resolves from the junk `surface.light.*` path (same
//    value, wrong path). The light surface is re-painted correctly.
//
//    If this script starts failing on the dark-side pin: the engine's
//    behavior changed. Re-verify against the documented contract in
//    openvue-v1-docs and flip the pin to it.
// ---------------------------------------------------------------------------

installFresh()
const before = $dt('surface.900')
updateSurfacePalette({ light: { 900: '#101418' } })
const after = $dt('surface.900')
console.log(`before → ${JSON.stringify(before.value)}`)
console.log(`after  → ${JSON.stringify(after.value)}`)

check(
    'one-sided light update re-paints the light surface',
    after.value && after.value.light && after.value.light.value === '#101418',
    JSON.stringify(after.value && after.value.light)
)
check(
    'PIN (upstream bug): one-sided light update clobbers the dark surface ' +
        'path to surface.light.* — flip this pin if the engine is fixed',
    after.value && after.value.dark &&
        before.value && before.value.dark &&
        after.value.dark.value === '#101418' &&
        after.value.dark.path === 'semantic.colorScheme.dark.surface.light.900' &&
        before.value.dark.path === 'semantic.colorScheme.dark.surface.900',
    `before.dark=${JSON.stringify(before.value && before.value.dark)} after.dark=${JSON.stringify(after.value && after.value.dark)}`
)

// ---------------------------------------------------------------------------

if (failures.length) {
    console.error(`Token API verification FAILED (${failures.length} contract violation(s) — see divergence note above):`)
    for (const f of failures) console.error(`  - ${f}`)
    process.exit(1)
}
console.log('Token API verified ($dt shape + paired updates vs the documented contract; one-sided update pinned to the installed 1.1.1 behavior).')
