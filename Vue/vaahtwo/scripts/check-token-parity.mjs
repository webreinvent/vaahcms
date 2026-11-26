// M3-T1 (F09) — token parity check (R4.4, scenario 3).
//
// Fails (exit 1) when the shipped preset definition contains:
//   1. a `colorScheme` override in OUR override object declared on one side
//      only — a token present under `colorScheme.light` but absent from
//      `colorScheme.dark` (or vice versa). (Scoped to VAAH_OVERRIDES on
//      purpose: Nide itself ships intentional dark-only accents, e.g.
//      components.tabs.colorScheme.dark.tab.activeBorderColor and
//      components.togglebutton.colorScheme.dark.content.checkedShadow —
//      upstream one-sided tokens are not our rule's concern.)
//   2. a token Nide defines under `colorScheme` that our override declares
//      as a plain direct value — the upstream pitfall: the `colorScheme`
//      property takes precedence over direct values, so such an override is
//      silently ignored;
//   3. a reserved preset key (`primitive`, `semantic`, `components`,
//      `directives`, `colorscheme`, `light`, `dark`, `common`, `root`,
//      `states`, `extend`) used as a token name or as an `extend`
//      namespace segment.
// Wired as `prebuild` so `npm run build` cannot ship an asymmetric preset.

import Nide from '@openvue/themes/nide'
import { VaahPreset, VAAH_OVERRIDES } from '../vaahvue/theme/openvue.js'

const RESERVED = new Set([
    'primitive', 'semantic', 'components', 'directives', 'colorscheme',
    'light', 'dark', 'common', 'root', 'states', 'extend',
])

const failures = []

// ---------------------------------------------------------------------------
// helpers
// ---------------------------------------------------------------------------

function isObject(value) {
    return value !== null && typeof value === 'object' && !Array.isArray(value)
}

/** Flatten an object to { 'a.b.c': leaf } for non-function leaves. */
function flatten(value, prefix = [], out = {}) {
    for (const [key, child] of Object.entries(value)) {
        const path = [...prefix, key]
        const name = path.join('.')
        if (key === 'css' && typeof child === 'function') continue
        if (isObject(child)) {
            flatten(child, path, out)
        } else {
            out[name] = child
        }
    }
    return out
}

/**
 * Collect every `colorScheme` occurrence: [{ base, light, dark }] where
 * light/dark are the flattened token maps under each side.
 */
function collectColorSchemes(value, base, out = []) {
    for (const [key, child] of Object.entries(value)) {
        const path = base ? `${base}.${key}` : key
        if (key === 'colorScheme' && isObject(child)) {
            out.push({
                base: path,
                light: flatten(child.light || {}, [path, 'light']),
                dark: flatten(child.dark || {}, [path, 'dark']),
            })
        } else if (isObject(child)) {
            collectColorSchemes(child, path, out)
        }
    }
    return out
}

/** Does `preset` define `tokenPath` scheme-dependently (under colorScheme)? */
function definesUnderColorScheme(preset, tokenPath) {
    const segments = tokenPath.split('.')
    const cs = collectColorSchemes(preset, '')
    return cs.some((c) => {
        const prefix = c.base.split('.')
        // the colorScheme's surrounding base must match the token's ancestors
        // up to some depth, and the remaining token segments must exist on a
        // side.
        if (segments.slice(0, prefix.length).join('.') !== prefix.join('.')) {
            return false
        }
        const rest = segments.slice(prefix.length) // after 'colorScheme'
        // rest = [ 'light' | 'dark', ...tokenSegments ]
        const side = rest[0]
        const tokenRest = rest.slice(1).join('.')
        const sideMap = c[side]
        if (!sideMap) return false
        // the token's own segments may themselves nest a colorScheme —
        // accept a prefix match on the side map's keys
        return Object.keys(sideMap).some((k) => k === tokenRest || k.startsWith(`${tokenRest}.`))
    })
}

// ---------------------------------------------------------------------------
// 1. light/dark symmetry
//
// Hard-fail: any colorScheme WE define (VAAH_OVERRIDES) that is one-sided.
// Informational: asymmetries inherited from the vendored Nide base preset —
// upstream ships `components.tabs.colorScheme.tab.activeBorderColor` and
// `components.togglebutton.colorScheme.content.checkedShadow` dark-only by
// design; we cannot and must not patch the vendored preset here (F10 owns
// preset-level divergence, if ever).
// ---------------------------------------------------------------------------

const ourTokenPaths = new Set(
    Object.entries(flatten(VAAH_OVERRIDES)).map(([p]) =>
        p
            .split('.')
            .filter((s) => !['colorScheme', 'light', 'dark'].includes(s))
            .join('.')
    )
)

function auditSchemes(schemes, schemeSource) {
    for (const { base, light, dark } of schemes) {
        // the flattened keys embed the side segment ('…light.x' vs '…dark.x')
        // — compare the token paths relative to the side
        const relative = (map) => new Set(
            Object.keys(map).map((k) =>
                k.slice(base.length + 1).replace(/^(light|dark)\./, '')
            )
        )
        const lightKeys = relative(light)
        const darkKeys = relative(dark)
        const onlyLight = [...lightKeys].filter((k) => !darkKeys.has(k))
        const onlyDark = [...darkKeys].filter((k) => !lightKeys.has(k))
        if (!onlyLight.length && !onlyDark.length) continue

        const detail = [
            onlyLight.map((k) => `light-only '${k}'`).join(', '),
            onlyDark.map((k) => `dark-only '${k}'`).join(', '),
        ]
            .filter(Boolean)
            .join(' | ')

        const owned = [...onlyLight, ...onlyDark].some((k) => ourTokenPaths.has(k))
        if (schemeSource === 'overrides' || owned) {
            failures.push(`asymmetric colorScheme at '${base}': ${detail}`)
        } else {
            console.warn(`  note (inherited from base preset, informational): ` +
                `asymmetric colorScheme at '${base}': ${detail}`)
        }
    }
}

auditSchemes(collectColorSchemes(VAAH_OVERRIDES, ''), 'overrides')
auditSchemes(collectColorSchemes(VaahPreset, ''), 'merged')

// ---------------------------------------------------------------------------
// 2. structure parity with Nide — a Nide colorScheme token must not be
//    overridden as a direct value (it would be silently ignored)
// ---------------------------------------------------------------------------

const ourLeaves = flatten(VAAH_OVERRIDES)
for (const [path] of Object.entries(ourLeaves)) {
    // strip our own colorScheme segments to get the token path
    const tokenPath = path
        .split('.')
        .filter((seg) => seg !== 'colorScheme')
        .join('.')
        // 'extend' namespaces are ours, not Nide's — only compare tokens
        // that live in Nide's schema (semantic.* / components.* / primitive.*)
    const top = tokenPath.split('.')[0]
    if (!['semantic', 'components', 'primitive'].includes(top)) continue
    if (definesUnderColorScheme(Nide, tokenPath)) {
        const underScheme = /(^|\.)colorScheme\.(light|dark)(\.|$)/.test(path)
        if (!underScheme) {
            failures.push(
                `structure mismatch at '${path}': Nide defines '${tokenPath}' ` +
                'under colorScheme — override it under colorScheme.light AND ' +
                'colorScheme.dark, not as a direct value (direct values lose ' +
                'to the scheme-specific ones)'
            )
        }
    }
}

// ---------------------------------------------------------------------------
// 3. reserved-key collisions in the override object
// ---------------------------------------------------------------------------

function walkReserved(value, path, depth, out) {
    for (const [key, child] of Object.entries(value)) {
        const name = key.toLowerCase()
        const parent = path[path.length - 1]
        const isTopLevel = depth === 0
        const isSideOfColorScheme = parent === 'colorscheme' && ['light', 'dark'].includes(name)
        const isTopLevelSchemaKey = isTopLevel && [
            'primitive', 'semantic', 'components', 'directives', 'extend', 'css',
        ].includes(name)
        const isColorSchemeKey = name === 'colorscheme' && !isTopLevel
        if (RESERVED.has(name) && !isSideOfColorScheme && !isTopLevelSchemaKey && !isColorSchemeKey) {
            out.push([...path, key].join('.'))
        }
        if (isObject(child)) {
            walkReserved(child, [...path, key], depth + 1, out)
        }
    }
    return out
}

for (const collision of walkReserved(VAAH_OVERRIDES, [], 0, [])) {
    failures.push(`reserved key '${collision}' used as a token name or namespace segment`)
}

// ---------------------------------------------------------------------------

if (failures.length) {
    console.error('Token parity check FAILED:')
    for (const f of failures) console.error(`  - ${f}`)
    process.exit(1)
}
console.log('Token parity check passed (light/dark symmetry, Nide structure, reserved keys).')
