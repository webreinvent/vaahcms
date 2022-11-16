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

const items = ref([
    {
        label: 'VueThree',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-regular fa-chart-bar',
                to: "/"
            },

        ]
    },
]);

</script>
<template>

    <div v-if="height">
        <Menu :model="items" />

        {{ root.assets.extended_views.sidebar_menu.success }}
    </div>

</template>


