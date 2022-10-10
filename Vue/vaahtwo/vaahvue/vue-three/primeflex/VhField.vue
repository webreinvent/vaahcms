<script setup>
const props = defineProps(['label'])

</script>
<template>
    <div class="field grid">
        <label class="col-12 mb-2 md:col-2 md:mb-0">
            {{props.label}} <slot name="label"></slot>
        </label>
        <div class="col-12 md:col-10">
            <slot></slot>
        </div>
    </div>
</template>
