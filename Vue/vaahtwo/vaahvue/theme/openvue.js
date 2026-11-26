// M3-T1 (F09) — OpenVue theme foundation.
//
// The Nide preset is the base (the compact built-in: neutral palette, near-
// black primary, hairline borders, soft 3px focus rings). It is extended with
// definePreset — the admin's density contract is delivered through design
// tokens and the global rem scale, never by rewriting component style classes
// (R4.1/R4.2; upstream: "overriding the OpenVue components using style classes
// is not a best practice and should be the last resort, design tokens are the
// suggested approach").
//
// COLOR-SCHEME PARITY RULE (R4.4) — every token this preset overrides must
// keep the same structure as the base preset:
//   - a token Nide defines as a direct value is overridden as a direct value;
//   - a token Nide defines under `colorScheme` is overridden with BOTH
//     `colorScheme.light` AND `colorScheme.dark` — a one-sided override is
//     silently ignored because the `colorScheme` property takes precedence
//     over direct values (upstream "Common Pitfall").
// scripts/check-token-parity.mjs (wired as `prebuild`) fails the build on any
// asymmetric override or reserved-key collision.
//
// DENSITY (R4.2) — the absolute targets are 14px base text, 36px control
// height, 32px table row, 8px grid. Nide's own values are rem numbers against
// the default 16px root (36px control = 2.25rem, 14px text = 0.875rem); at the
// 14px root they would render 31.5px / 12.25px — short of the targets. The
// contract therefore re-expresses them against the 14px root, which
// scss/openvue-density.scss enforces via `html { font-size: 14px; }`:
//   base text      14px = 1rem
//   control height 36px = 2.5714rem   (36 / 14)
//   table row      32px = 2.2857rem   (32 / 14)
//   grid step       8px = 0.5714rem    ( 8 / 14)
// The tokens are scheme-independent (Nide defines nothing named
// vaah.density.*), so the parity rule does not pair them.

import { definePreset } from '@openvue/themes'
import Nide from '@openvue/themes/nide'

const DENSITY = {
    baseText: '1rem',
    controlHeight: '2.5714rem',
    rowHeight: '2.2857rem',
    gridStep: '0.5714rem',
}

// The override object handed to definePreset — exported so
// scripts/check-token-parity.mjs can audit the raw structure (Nide-structure
// parity + reserved keys) without parsing the merged preset.
export const VAAH_OVERRIDES = {
    extend: {
        // Custom namespace — "vaah" is not a reserved key (primitive,
        // semantic, components, directives, colorscheme, light, dark,
        // common, root, states, extend).
        vaah: {
            density: { ...DENSITY },
        },
    },
    // Token-aware density CSS: the values come through dt() so they stay
    // bound to the token layer (the mechanism F10's custom CSS uses, N22).
    //
    // M3-T2 (F10) — three sections:
    //   1. the F09 global density rules (unchanged from M3-T1);
    //   2. the `.vc-dense` semantic density class (R4.3) — the single
    //      definition of the class the v3 `is-small` usages now carry. It
    //      scopes the F09 density targets to its own subtree; every value
    //      is token-bound through dt(), and nothing here is a 1:1 rewrite
    //      of the 12 retired v3 hand-port blocks;
    // The explicit local `.p-datatable-hoverable-rows` hover style (R4.8)
    // lives in the Vite graph (scss/datatable-hover.scss) so it is present
    // in the emitted build/index.css — see that file for the contrast
    // audit and css-class-migration-table.md for the table row.
    css: ({ dt }) => `
/* F09 — global density (unchanged from M3-T1). */
.p-button:not(.p-button-sm):not(.p-button-lg),
.p-inputtext {
    font-size: ${dt('vaah.density.baseText')};
    height: ${dt('vaah.density.controlHeight')};
}

.p-datatable {
    font-size: ${dt('vaah.density.baseText')};
}

.p-datatable .p-datatable-tbody tr {
    height: ${dt('vaah.density.rowHeight')};
}

/* R4.3 — the semantic density class, defined once here (token layer), not
   as a v3-DOM selector rewrite. The 64 .vue screens that carried the v3
   density class now carry the vc-dense class; its subtree computes the F09
   targets: base text 14px (1rem at the 14px root), control 36px
   (2.5714rem), table row 32px (2.2857rem). */
.vc-dense {
    font-size: ${dt('vaah.density.baseText')};
}

.vc-dense .p-button,
.vc-dense .p-inputtext {
    font-size: ${dt('vaah.density.baseText')};
    height: ${dt('vaah.density.controlHeight')};
}

.vc-dense .p-datatable {
    font-size: ${dt('vaah.density.baseText')};
}

.vc-dense .p-datatable .p-datatable-tbody tr {
    height: ${dt('vaah.density.rowHeight')};
}

`,
}

export const VaahPreset = definePreset(Nide, VAAH_OVERRIDES)

// The theme block handed to app.use(OpenVue, …) — theme.options has exactly
// three keys (R4.5): prefix, darkModeSelector, cssLayer.
//
// M3-T2 (F10) — cssLayer enabled (R3.10 / F10 Part 5): the engine now
//   - emits the layer-order statement `@layer reset, openvue;` so the
//     app's reset layer (style.scss) loses to the library layer, and
//     unlayered app CSS wins over both;
//   - wraps every emitted component/preset stylesheet in
//     `@layer openvue { … }`.
export const THEME_OPTIONS = {
    prefix: 'p',
    darkModeSelector: '.app-dark',
    cssLayer: {
        name: 'openvue',
        order: 'reset, openvue',
    },
}

export default VaahPreset
