<script setup>
import {onMounted, onUpdated, ref} from 'vue';

const props = defineProps(['label'])

// UT-65 (M6-T4a Batch 12) — the visible label was not associated with the
// control it belongs to: the `<label>` carried no `for` attribute and the
// control inside the slot carried no `aria-labelledby`, so **every** field
// of every form announced itself as an unnamed "edit text" (WCAG 2.2
// SC 1.3.1 Info and Relationships / SC 4.1.2 Name, Role, Value).
//
// The label must stay exactly where it is — a two-column grid row, with
// the label in the narrow left column — so the PrimeVue `label` prop
// (which renders its own label and needs `inputId`) cannot be used
// without changing the layout. The association is therefore made with
// `aria-labelledby`: the label gets an id and the control in the slot is
// pointed at it.
//
// The control is found at mount **and** on update, because the slot
// content is often filled asynchronously (a stored record arriving from
// the API re-renders the control).
const label_id = 'vh-field-' + Math.random().toString(36).slice(2, 9);
const field = ref(null);

const CONTROL_SELECTOR = [
    'input:not([type="hidden"])',
    'textarea',
    'select',
    '[role="combobox"]',
    '[role="group"]',
    '.p-select-label',
    '.p-datepicker-input'
].join(', ');

const associate = () => {
    if (!field.value) {
        return;
    }
    let controls = field.value.querySelectorAll(CONTROL_SELECTOR);
    controls.forEach((control) => {
        // a control that already carries a name of its own keeps it
        if (control.getAttribute('aria-label')) {
            return;
        }
        if (control.getAttribute('aria-labelledby')) {
            return;
        }
        control.setAttribute('aria-labelledby', label_id);
    });
};

onMounted(associate);
onUpdated(associate);
</script>
<template>
    <div class="field grid" ref="field">
        <label :id="label_id" class="col-12 mb-2 md:col-2 md:mb-0">
            {{props.label}} <slot name="label"></slot>
        </label>
        <div class="col-12 md:col-10">
            <slot></slot>
        </div>
    </div>
</template>
