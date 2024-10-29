<script setup>
const props = defineProps(['label'])

</script>
<template>

    <div class="field grid">
        <label class="col-12">
            {{props.label}} <slot name="label"></slot>
        </label>
        <div class="col-12">
            <slot></slot>
        </div>
    </div>
</template>
