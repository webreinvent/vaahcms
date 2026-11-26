// UT-64 (M6-T4a Batch 12) — accessible names for the rich-text toolbar.
//
// The OpenVue `Editor` is a wrapper around **Quill 1.3.7** (the version
// shipped with the engine). Quill's own toolbar module renders its
// controls as bare icon buttons:
//
//     <button class="ql-bold" type="button" data-pc-section="bold">
//         <svg …></svg>
//     </button>
//
// Quill 1.3.7 sets **no** `aria-label` and **no** `title` on those
// buttons, so a screen reader announces eleven unnamed "button"s in a
// row — a WCAG 2.2 SC 4.1.2 (Name, Role, Value) failure.
//
// The Editor is an engine component and the app cannot hand Quill a
// toolbar configuration (the documented escape hatch is a full custom
// `toolbar` slot, which would mean re-declaring every format the app
// ships and losing the engine's own markup), so the names are applied to
// the rendered toolbar instead.
//
// `title` is set alongside `aria-label` so the name is also visible on
// hover — the engine's toolbar buttons carry no tooltip of their own.

const LABELS = {
    'ql-bold': 'Bold',
    'ql-italic': 'Italic',
    'ql-underline': 'Underline',
    'ql-strike': 'Strikethrough',
    'ql-blockquote': 'Blockquote',
    'ql-code-block': 'Code block',
    'ql-link': 'Insert link',
    'ql-image': 'Insert image',
    'ql-video': 'Insert video',
    'ql-formula': 'Insert formula',
    'ql-clean': 'Clear formatting',
    'ql-header': 'Heading',
    'ql-align': 'Text alignment',
    'ql-size': 'Font size',
    'ql-color': 'Text colour',
    'ql-background': 'Background colour',
    'ql-font': 'Font',
    'ql-script': 'Superscript / subscript',
    'ql-indent': 'Increase indent',
    'ql-direction': 'Text direction',
    'ql-list': 'List'
};

// `ql-list` is used for both list kinds; the button carries the kind in
// its `value` attribute (`ordered` / `bullet`).
const LIST_LABELS = {
    'ordered': 'Numbered list',
    'bullet': 'Bulleted list'
};

// ── UT-94 (M6-T4a Batch 19) — the toolbar's *dropdown* controls were
// still unnamed ───────────────────────────────────────────────────────────
//
// Quill does not render its select-style controls (Heading, Font, Text
// colour, Background colour, Text alignment) as buttons. It builds a
// picker:
//
//     <span class="ql-header ql-picker">
//         <span class="ql-picker-label" role="button" tabindex="0"
//               aria-expanded="false" aria-controls="ql-picker-options-0">
//             <svg …></svg>
//         </span>
//         <span class="ql-picker-options" aria-hidden="true">
//             <span role="button" class="ql-picker-item" data-label="Heading"></span>
//             …
//         </span>
//     </span>
//
// The label carries `role="button"` and a chevron but **no accessible
// name**, and the options carry their text in a `data-label` attribute
// only — so a screen reader announced "button" five times and then, once
// the dropdown opened, a row of unnamed buttons.
//
// UT-64 only labelled `.ql-toolbar button`, so these were missed. The
// picker's own format class (`ql-header`, `ql-color`, …) names the
// control; the option's `data-label` names the option.
const PICKER_LABELS = {
    'ql-header': 'Heading',
    'ql-size': 'Font size',
    'ql-font': 'Font',
    'ql-color': 'Text colour',
    'ql-background': 'Background colour',
    'ql-align': 'Text alignment',
    'ql-script': 'Superscript / subscript',
    'ql-direction': 'Text direction',
    'ql-indent': 'Increase indent',
    'ql-list': 'List'
};

// The *options* of a picker are colour swatches, font names and alignment
// icons — none of them carries text, so Quill leaves them without a
// `data-label` as well. Their `data-value` says what they are:
//
//     ql-color        #e60000      ql-font   serif
//     ql-background  #ffffff      ql-align  center
//
// The eight colours Quill puts at the head of its palette have plain
// names; the rest of the palette is named by its hex value.
const COLOUR_NAMES = {
    '#000000': 'Black',
    '#e60000': 'Red',
    '#ff9900': 'Orange',
    '#ffff00': 'Yellow',
    '#008a00': 'Green',
    '#0066cc': 'Blue',
    '#9933ff': 'Purple',
    '#ffffff': 'White'
};

const ALIGN_LABELS = {
    'center': 'Align centre',
    'right': 'Align right',
    'justify': 'Justify'
};

const FONT_LABELS = {
    'serif': 'Serif',
    'monospace': 'Monospace'
};

// The name of one option, given the picker's format class.
const option_label = (option, format) => {
    let value = option.getAttribute('data-value');
    if (value === null) {
        // The palette's first entry is the "inherit / default" swatch.
        if (format === 'ql-align') {
            return 'Align left';
        }
        if (format === 'ql-font') {
            return 'Default font';
        }
        if (format === 'ql-color') {
            return 'Default text colour';
        }
        if (format === 'ql-background') {
            return 'Default background colour';
        }
        return '';
    }
    value = value.trim();
    if (format === 'ql-align') {
        return ALIGN_LABELS[value] || 'Align left';
    }
    if (format === 'ql-font') {
        return FONT_LABELS[value] || value;
    }
    if (format === 'ql-color') {
        return 'Text colour: ' + (COLOUR_NAMES[value] || value);
    }
    if (format === 'ql-background') {
        return 'Background colour: ' + (COLOUR_NAMES[value] || value);
    }
    return '';
};

// The format class of the picker an element belongs to ('' when it is
// not inside one).
const format_of = (element) => {
    let container = element.closest ? element.closest('.ql-picker') : null;
    if (!container) {
        return '';
    }
    let cls = container.className || '';
    let found = '';
    Object.keys(PICKER_LABELS).forEach((key) => {
        if (cls.indexOf(key) > -1) {
            found = key;
        }
    });
    return found;
};

const label_for = (button) => {
    let cls = button.className || '';
    if (cls.indexOf('ql-list') > -1) {
        return LIST_LABELS[button.getAttribute('value')] || LABELS['ql-list'];
    }
    let found = '';
    Object.keys(LABELS).forEach((key) => {
        if (cls.indexOf(key) > -1) {
            found = LABELS[key];
        }
    });
    return found;
};

// The toolbars inside `root` (default: the whole document).
//
// UT-135 — the scope is the *toolbar* itself as often as it is the
// document: the observer hands the observer the node that was added to
// the DOM, and that node is frequently the `.ql-toolbar` element. A
// plain `scope.querySelectorAll('.ql-toolbar button')` finds nothing in
// that case — the toolbar is not a descendant of itself — so the
// toolbar's own controls were left unnamed. The scope is therefore
// matched against the toolbar selector first, and the toolbars it
// contains are collected after it.
const toolbars_in = (scope) => {
    let found = [];
    if (scope.matches && scope.matches('.ql-toolbar')) {
        found.push(scope);
    }
    scope.querySelectorAll('.ql-toolbar').forEach((toolbar) => {
        found.push(toolbar);
    });
    return found;
};

// Labels every toolbar button inside `root` (default: the whole
// document). Safe to call repeatedly — already-labelled buttons are
// skipped.
export const labelEditorToolbar = (root) => {
    let scope = root || document;
    let labelled = 0;

    toolbars_in(scope).forEach((toolbar) => {
        toolbar.querySelectorAll('button').forEach((button) => {
            if (button.getAttribute('aria-label')) {
                return;
            }
            let label = label_for(button);
            if (!label) {
                return;
            }
            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);
            labelled++;
        });

        // UT-94 — the dropdown pickers and their options.
        toolbar.querySelectorAll('.ql-picker-label').forEach((picker) => {
            if (picker.getAttribute('aria-label')) {
                return;
            }
            let format = format_of(picker);
            let label = format ? PICKER_LABELS[format] : '';
            if (!label) {
                return;
            }
            picker.setAttribute('aria-label', label);
            picker.setAttribute('title', label);
            labelled++;
        });

        toolbar.querySelectorAll('.ql-picker-item').forEach((item) => {
            if (item.getAttribute('aria-label')) {
                return;
            }
            let format = format_of(item);
            let label = (item.getAttribute('data-label') || '').trim();
            if (!label) {
                label = option_label(item, format);
            }
            if (!label) {
                return;
            }
            item.setAttribute('aria-label', label);
            item.setAttribute('title', label);
            labelled++;
        });
    });

    return labelled;
};

// The editor renders its toolbar asynchronously (Quill builds the
// toolbar in its own mount pass), so a single tick is not enough: the
// helper is retried over a few frames until the toolbar is present.
//
// UT-135 (UAT sweep) — the retry was not enough. The editor sits inside a
// panel that only renders once the screen's assets have loaded, so on a
// slow round-trip the toolbar appeared *after* the twelve frames the retry
// spans, and the buttons were never named: the profile screen announced
// eleven unnamed buttons. A `MutationObserver` on the document names a
// toolbar whenever it appears, whatever the timing.
let observer = null;

// The node that was added to the DOM may be the toolbar itself, a
// container that holds it, or - when Quill appends its controls one by
// one - a single button or picker item. The three cases are covered by
// naming the toolbar the node belongs to.
const labelToolbarOf = (node) => {
    if (!node || node.nodeType !== 1) {
        return;
    }
    if (node.classList && node.classList.contains('ql-toolbar')) {
        labelEditorToolbar(node);
        return;
    }
    if (node.querySelector && node.querySelector('.ql-toolbar')) {
        labelEditorToolbar(node);
        return;
    }
    let toolbar = node.closest ? node.closest('.ql-toolbar') : null;
    if (toolbar) {
        labelEditorToolbar(toolbar);
    }
};

const observeToolbars = () => {
    if (observer || typeof MutationObserver === 'undefined') {
        return;
    }
    observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                labelToolbarOf(node);
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
};

export const labelEditorToolbarWhenReady = (root, attempt = 0) => {
    let scope = root || document;
    labelEditorToolbar(scope);
    observeToolbars();
    if (scope.querySelector('.ql-toolbar button')) {
        return;
    }
    if (attempt < 12) {
        requestAnimationFrame(() => labelEditorToolbarWhenReady(root, attempt + 1));
    }
};

export default labelEditorToolbar;
