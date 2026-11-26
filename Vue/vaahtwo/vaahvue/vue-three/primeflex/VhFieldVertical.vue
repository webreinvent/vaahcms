<script setup>
import {onMounted, onUpdated, ref} from 'vue';

const props = defineProps(['label'])

// UT-65 (M6-T4a Batch 12) — see VhField.vue: the visible label was not
// programmatically associated with the control, so the field announced
// itself as an unnamed input. The vertical variant keeps its stacked
// layout and associates the label with `aria-labelledby` the same way.
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
        <label :id="label_id" class="col-12">
            {{props.label}} <slot name="label"></slot>
        </label>
        <div class="col-12">
            <slot></slot>
        </div>
    </div>
</template>
