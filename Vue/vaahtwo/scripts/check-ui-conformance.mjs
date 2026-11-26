// M6-T4a (F23) — UI conformance check (the anti-skip gate).
//
// WHY THIS EXISTS
// ---------------
// The UI/UX defects that reached the user (the dashboard's off-scale type,
// the queue note styled as a hard error, the log file names painted red, the
// orphan divider) were all *invisible* to the pipeline's gates: the build
// passed, the Playwright UAT passed, the route sweep passed with 0 console
// errors, and the task was still merged. A defect class that no gate can see
// is a defect class that gets skipped. This script is that gate.
//
// It is a RATCHET, not a linter-to-zero. The current debt is recorded in
// `ui-conformance-baseline.json`; the check FAILS on any violation that is
// NOT in the baseline, and on any file whose violation count exceeds its
// baseline count. Fixing a violation is always allowed (the count only goes
// down). Run `npm run ui-conformance -- --update-baseline` after an
// intentional, reviewed change to re-baseline.
//
// Wired as `prebuild` so `npm run build` cannot ship a NEW UI defect — the
// same mechanism as `check-token-parity.mjs` (which guards the token layer;
// this one guards the screen layer).
//
// WHAT IT CHECKS (all rules are derived from a defect that actually shipped)
// ------------------------------------------------------------------------
//   typography-off-scale  PrimeFlex `text-xs|sm|lg|xl|2xl` → 10.5 / 12.25 /
//                         15.75 / 17.5 / 21px at the 14px root. The design
//                         scale (DESIGN-SYSTEM.md §6) is 12 · 13 · 14 · 16 ·
//                         20 · 24. None of these is on it. (The dashboard
//                         shipped with `text-xl` titles and `text-sm` body.)
//   palette-color         A Tailwind *palette* utility (`text-red-500`,
//                         `bg-gray-100`, …) resolves to a **primitive**
//                         palette token (`--p-red-500`), which is
//                         scheme-INVARIANT: measured in the live app, it is
//                         `#ef4444` in `:root` and `#ef4444` under `.app-dark`,
//                         while the semantic tokens flip (`--p-text-color`
//                         `#0a0a0a` → `#fafafa`, `--p-content-background`
//                         `#ffffff` → `#171717`). A primitive reads right in
//                         light and stays wrong in dark. Use a semantic
//                         token — or the component's own `severity`.
//   raw-hex              A literal hex color in a screen instead of a token.
//   v3-class             A v3 BEM/v3 class (`is-light`, `is-primary`, …) on a
//                         v4 component.
//   vc-dense-size        `size="vc-dense"` is not a v4 button size.
//   null-prop            `icon="null"` / `icon="undefined"` — the STRING
//                         "null" is truthy, so it is rendered as a junk class
//                         (`<span class="p-message-icon null">`).
//   severity-mismatch    `severity="danger"` is valid on Badge/Tag only;
//                         Message uses `error`. And `severity="error"` is
//                         valid on Message only; Badge/Tag use `danger`.
//
// WHAT IT DOES NOT CHECK (needs eyes — see the step-11 visual sweep)
//   Whether a screen has a *body* size at all, whether the semantic severity
//   matches the meaning ("queues are off" is not an error), whether a
//   divider lands on a column boundary, whether a surface is aligned with
//   its neighbour, whether a counter at zero is painted as a failure.
//   Those are the visual-sweep items in `reference-ui-conformance.md`.

import { readFileSync, readdirSync, statSync, writeFileSync, existsSync } from 'node:fs'
import { join, relative, sep } from 'node:path'
import { fileURLToPath } from 'node:url'

const HERE = fileURLToPath(new URL('.', import.meta.url))
const ROOT = join(HERE, '..')
const BASELINE_PATH = join(HERE, 'ui-conformance-baseline.json')

// The scanned trees. `pages/ui/` is the legacy gallery (M7-T4, not started)
// — it is scanned too, so its debt is on the ledger rather than invisible.
const SCAN_DIRS = ['pages', 'components', 'layouts']

const VUE_FILES = /\.vue$/

// ---------------------------------------------------------------------------
// helpers
// ---------------------------------------------------------------------------

function walk(dir, out = []) {
    for (const entry of readdirSync(dir)) {
        if (entry === 'node_modules' || entry.startsWith('.')) continue
        const full = join(dir, entry)
        const st = statSync(full)
        if (st.isDirectory()) walk(full, out)
        else if (VUE_FILES.test(entry)) out.push(full)
    }
    return out
}

/**
 * Strip comments so a defect *described in prose* is not counted as a defect.
 * (The dashboard's own explanatory comment mentions `text-red-500` — that
 * must not be reported.)
 *
 * Quote-aware: a block-comment delimiter INSIDE a quoted attribute value is
 * not a comment delimiter. A naive block-comment regex pairs the `/*` in
 * `accept="image/*"` with the next real block-comment closer in the file
 * and deletes everything between — which hid the `text-sm` in
 * UsersForm.vue from this very gate. We therefore mask the delimiters in
 * quoted attribute values first, strip real comments, then unmask.
 */
function stripComments(src) {
    const O = '\u0001' // masked block-comment opener
    const C = '\u0002' // masked block-comment closer
    return src
        .replace(/<!--[\s\S]*?-->/g, ' ')
        .replace(/="[^"\n]*"|='[^'\n]*'/g, (s) => s.replace(/\/\*/g, O).replace(/\*\//g, C))
        .replace(/\/\*[\s\S]*?\*\//g, ' ')
        .replace(/(^|[^:])\/\/[^\n]*/g, '$1 ')
        .replace(/[\u0001\u0002]/g, (m) => (m === O ? '/*' : '*/'))
}

/** All `class` / `:class` attribute values in the file. */
function classAttributeValues(src) {
    const values = []
    const re = /(?:^|\s):?class\s*=\s*"([^"]*)"/g
    let m
    while ((m = re.exec(src)) !== null) values.push(m[1])
    return values
}

// ---------------------------------------------------------------------------
// rules
// ---------------------------------------------------------------------------

const RULES = [
    {
        id: 'typography-off-scale',
        // PrimeFlex text-* utilities. 14px root → rem→px: xs .75=10.5,
        // sm .875=12.25, lg 1.125=15.75, xl 1.25=17.5, 2xl 1.5=21.
        find: (src) => {
            const hits = []
            for (const value of classAttributeValues(src)) {
                const re = /\btext-(xs|sm|lg|xl|2xl)\b/g
                let m
                while ((m = re.exec(value)) !== null) hits.push(m[0])
            }
            return hits
        },
        why: 'is off the DESIGN-SYSTEM.md §6 scale (12 · 13 · 14 · 16 · 20 · 24) at the 14px root',
    },
    {
        id: 'palette-color',
        find: (src) => {
            const hits = []
            for (const value of classAttributeValues(src)) {
                const re = /\b(?:text|bg|border|from|to|via|ring|fill|stroke)-(red|blue|green|yellow|gray|grey|slate|zinc|neutral|stone|amber|orange|purple|indigo|emerald|cyan|sky|rose|pink|lime|fuchsia)-[0-9]{2,3}\b/g
                let m
                while ((m = re.exec(value)) !== null) hits.push(m[0])
            }
            return hits
        },
        why: 'resolves to a PRIMITIVE palette token (--p-red-500 etc.) which is scheme-invariant — it does NOT flip in dark mode. Use a semantic token (--p-text-color, --p-content-background, --p-button-danger-background, …) or the component\'s own severity',
    },
    {
        id: 'raw-hex',
        find: (src) => {
            const hits = []
            const re = /#[0-9a-fA-F]{6}\b/g
            let m
            while ((m = re.exec(src)) !== null) hits.push(m[0])
            return hits
        },
        why: 'is a literal color — use a design token instead',
    },
    {
        id: 'v3-class',
        find: (src) => {
            const hits = []
            for (const value of classAttributeValues(src)) {
                const re = /\b(is-(primary|info|danger|warning|success|light|dark|link|white)|has-text-centered|is-flex)\b/g
                let m
                while ((m = re.exec(value)) !== null) hits.push(m[0])
            }
            return hits
        },
        why: 'is a v3 class — use the v4 prop / utility',
    },
    {
        id: 'vc-dense-size',
        find: (src) => {
            const hits = []
            const re = /\bsize\s*=\s*"(vc-dense|vc-dense-sm|vc-dense-lg)"/g
            let m
            while ((m = re.exec(src)) !== null) hits.push(m[0])
            return hits
        },
        why: 'is not a v4 size — v4 uses the `size` prop values small/normal/large',
    },
    {
        id: 'null-prop',
        find: (src) => {
            const hits = []
            const re = /\b(icon|severity|label|placeholder)\s*=\s*"(null|undefined)"/g
            let m
            while ((m = re.exec(src)) !== null) hits.push(m[0])
            return hits
        },
        why: 'passes the STRING "null" — truthy, so it renders as a junk class',
    },
    {
        id: 'severity-mismatch',
        // The v4 severity sets are NOT uniform (verified fact, M5-T2):
        //   Badge / Tag → secondary | info | success | warn | danger | contrast
        //   Message     → error | secondary | info | success | warn | contrast
        //   Button      → secondary | success | info | warn | danger | contrast
        // A `severity` outside a component's own set renders unstyled — the
        // class `p-message-danger` does not exist in the built CSS. The two
        // swaps that actually happen are Message↔Badge/Tag.
        find: (src) => {
            const hits = []
            const tagRe = /<(Badge|Tag|Message)\b([^>]*)>/g
            const BADGE_TAG_SET = ['secondary', 'info', 'success', 'warn', 'danger', 'contrast']
            const MESSAGE_SET = ['error', 'secondary', 'info', 'success', 'warn', 'contrast']
            let tm
            while ((tm = tagRe.exec(src)) !== null) {
                const tag = tm[1]
                // A *dynamic* binding (`:severity="x"` / `v-bind:severity="x"`)
                // carries an expression, not a literal — the expression is not
                // in the set by definition, so it must not be flagged. Only a
                // static literal attribute is checked.
                if (/(?:^|\s)(?::|v-bind:)severity\s*=/.test(tm[2])) continue
                const sev = /(?<![\w:-])severity\s*=\s*"([^"]*)"/.exec(tm[2])
                if (!sev) continue
                const value = sev[1]
                const set = tag === 'Message' ? MESSAGE_SET : BADGE_TAG_SET
                if (!set.includes(value)) hits.push(`<${tag} severity="${value}">`)
            }
            return hits
        },
        why: 'uses a severity outside the component\'s v4 severity set (Badge/Tag: danger · Message: error)',
    },
]

// ---------------------------------------------------------------------------
// scan
// ---------------------------------------------------------------------------

function scan() {
    const found = new Map() // file → rule → count
    for (const dir of SCAN_DIRS) {
        const abs = join(ROOT, dir)
        if (!existsSync(abs)) continue
        for (const file of walk(abs)) {
            const rel = relative(ROOT, file).split(sep).join('/')
            const src = stripComments(readFileSync(file, 'utf8'))
            const byRule = new Map()
            for (const rule of RULES) {
                const hits = rule.find(src)
                if (hits.length) byRule.set(rule.id, hits.length)
            }
            if (byRule.size) found.set(rel, Object.fromEntries(byRule))
        }
    }
    return found
}

// ---------------------------------------------------------------------------
// baseline
// ---------------------------------------------------------------------------

function loadBaseline() {
    if (!existsSync(BASELINE_PATH)) return { files: {}, generatedAt: null, note: 'no baseline yet' }
    return JSON.parse(readFileSync(BASELINE_PATH, 'utf8'))
}

function writeBaseline(found) {
    const files = {}
    for (const [file, byRule] of [...found.entries()].sort()) {
        files[file] = byRule
    }
    const payload = {
        note: 'Known UI-conformance debt. The check fails on any violation NOT listed here, or any file whose count exceeds its baseline. Re-baseline deliberately with `npm run ui-conformance -- --update-baseline`.',
        generatedAt: new Date().toISOString().slice(0, 10),
        files,
    }
    writeFileSync(BASELINE_PATH, JSON.stringify(payload, null, 2) + '\n')
    return payload
}

// ---------------------------------------------------------------------------
// compare
// ---------------------------------------------------------------------------

function compare(found, baseline) {
    const baseFiles = baseline.files || {}
    const regressions = []

    for (const [file, byRule] of found) {
        const base = baseFiles[file] || {}
        for (const [rule, count] of Object.entries(byRule)) {
            const allowed = base[rule] || 0
            if (count > allowed) {
                regressions.push({ file, rule, count, allowed, extra: count - allowed })
            }
        }
    }

    // Files that disappeared from the scan but are in the baseline are fine
    // (the debt was retired) — report them as improvements, not failures.
    const retired = []
    for (const file of Object.keys(baseFiles)) {
        if (!found.has(file)) retired.push(file)
    }

    return { regressions, retired }
}

// ---------------------------------------------------------------------------
// main
// ---------------------------------------------------------------------------

const updateBaseline = process.argv.includes('--update-baseline')
// `--strict` = zero tolerance: fail on ANY violation, ignoring the baseline.
// A task that owns an area uses `npm run ui-conformance -- --strict --paths <dir>`
// to *prove* its area is clean — the ratchet alone cannot, because the
// baseline still allows the debt it has not paid off yet.
const strict = process.argv.includes('--strict')
// `--paths <substring>` (repeatable) limits the scan to matching file paths.
const pathFilters = process.argv
    .filter((a, i, arr) => arr[i - 1] === '--paths')
    .filter(Boolean)

let found = scan()

if (pathFilters.length) {
    const kept = new Map()
    for (const [file, byRule] of found) {
        if (pathFilters.some((f) => file.includes(f))) kept.set(file, byRule)
    }
    found = kept
}

if (updateBaseline) {
    const payload = writeBaseline(found)
    const total = Object.values(payload.files).reduce(
        (sum, byRule) => sum + Object.values(byRule).reduce((a, b) => a + b, 0),
        0
    )
    console.log(`UI conformance baseline written: ${Object.keys(payload.files).length} files, ${total} known violations.`)
    process.exit(0)
}

const baseline = loadBaseline()
const { regressions, retired } = compare(found, baseline)

const known = [...found.values()].reduce(
    (sum, byRule) => sum + Object.values(byRule).reduce((a, b) => a + b, 0),
    0
)

const failing = strict
    ? [...found.entries()].flatMap(([file, byRule]) =>
        Object.entries(byRule).map(([rule, count]) => ({
            file,
            rule,
            count,
            allowed: 0,
            extra: count,
        }))
    )
    : regressions

if (failing.length) {
    console.error(
        strict
            ? `UI conformance check FAILED (--strict: zero tolerance) — ${pathFilters.length ? `in ${pathFilters.join(', ')}` : 'repository-wide'}:\n`
            : 'UI conformance check FAILED — new UI defects:\n'
    )
    for (const r of failing) {
        const rule = RULES.find((x) => x.id === r.rule)
        console.error(`  ${r.file}  ${r.rule}`)
        console.error(
            strict
                ? `    ${r.count} occurrence(s)`
                : `    ${r.count} occurrence(s), ${r.allowed} allowed by the baseline (+${r.extra})`
        )
        console.error(`    "${r.rule}" ${rule ? rule.why : ''}`)
    }
    if (strict) {
        console.error(`\n${known} violation(s) in scope. Fix them — a task's own area must be clean.`)
    } else {
        console.error(`\n${known} violation(s) known; ${failing.length} file/rule pair(s) regressed.`)
        console.error('Fix the violation, or — if it is an intentional change — re-baseline with')
        console.error('  npm run ui-conformance -- --update-baseline')
    }
    process.exit(1)
}

console.log(
    strict
        ? `UI conformance check passed (--strict: 0 violations in ${pathFilters.length ? pathFilters.join(', ') : 'the whole tree'}).`
        : `UI conformance check passed (${known} known violation(s) at or below baseline, ${retired.length} file(s) retired).`
)
