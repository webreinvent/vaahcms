<script setup>
import {onMounted, watch} from "vue";

import { useRootStore } from "../../stores/root"
import {useSettingStore} from '../../stores/store-settings';

const root = useRootStore();
const store = useSettingStore();

onMounted(async () => {
    store.getAssets();
    watch(
        () => root.assets,
        (newValue) => {
            store.sidebarMenuItems();
            store.is_root_loaded = true;
        }
    )
});

if(root.assets) {
    store.sidebarMenuItems();
    store.is_root_loaded = true;
}

</script>

<template>
    <div class="grid justify-content-center" v-if="store.is_root_loaded">
        <div class="col-fixed">
            <Menu :model="store.sidebar_menu_items" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
