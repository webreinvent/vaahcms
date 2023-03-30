<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import {useRootStore} from "../../stores/root";
const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();

const root = useRootStore();
const sidebar_menu_items_supperadmin = ref([
    {
        label: 'Settings',
        items: [
            {
                label: 'General',
                icon: 'pi pi-cog',
                to:{ path: '/vaah/settings/general' }
            },
            {
                label: 'User Settings',
                icon: 'pi pi-user',
                to:{ path: '/vaah/settings/user-settings' }
            },
            {
                label: 'ENV Variables',
                icon: 'pi pi-cog',
                to:{ path: '/vaah/settings/env-variables' }
            },
            {
                label: 'Localization',
                icon: 'pi pi-code',
                to:{ path: '/vaah/settings/localization' }
            },
            {
                label: 'Notification',
                icon: 'pi pi-bell',
                to:{ path: '/vaah/settings/notifications' }
            },
            {
                label: 'Update',
                icon: 'pi pi-download',
                to:{ path: '/vaah/settings/update' }
            },
            {
                label: 'Reset',
                icon: 'pi pi-refresh',
                to:{ path: '/setup' }
            },
        ]},
]);

const sidebar_menu_items = ref([
    {
        label: 'Settings',
        items: [
            {
                label: 'General',
                icon: 'pi pi-cog',
                to:{ path: '/vaah/settings/general' }
            },
            {
                label: 'User Settings',
                icon: 'pi pi-user',
                to:{ path: '/vaah/settings/user-settings' }
            },
            {
                label: 'Localization',
                icon: 'pi pi-code',
                to:{ path: '/vaah/settings/localization' }
            },
            {
                label: 'Notification',
                icon: 'pi pi-bell',
                to:{ path: '/vaah/settings/notifications' }
            },
        ]},
]);

onMounted(async () => {

    store.getAssets();

});

</script>

<template>
    <div class="grid justify-content-center">
        <div class="col-fixed" v-if="root && root.assets && root.assets.auth_user">
            <Menu v-if="root.assets.auth_user.role" :model="sidebar_menu_items_supperadmin" />
            <Menu v-else :model="sidebar_menu_items" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
