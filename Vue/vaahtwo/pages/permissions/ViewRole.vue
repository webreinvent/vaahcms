<script setup>

import {onMounted} from "vue";

onMounted( async () => {
    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();
});

</script>

<template>
    <div>
        <Panel v-if="store && store.item"></Panel>
    </div>
</template>
