<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRootStore } from  '../../stores/root';

import Menu from 'primevue/menu';

const inputs = {
}
const data = reactive(inputs);
const height = ref(window.innerHeight)

const menu = ref();
const root = useRootStore();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();

});

</script>

<template>

    <div v-if="height && root && root.assets && root.assets.extended_views && root.assets.extended_views.sidebar_menu">
        <Menu :model="root.assets.extended_views.sidebar_menu.success.vaahcms" />
    </div>

</template>


