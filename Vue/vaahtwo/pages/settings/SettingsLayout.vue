<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();

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
                label: 'Env Variables',
                icon: 'pi pi-cog',
                to:{ path: '/vaah/settings/env-variables' }
            },
            {
                label: 'Localizations',
                icon: 'pi pi-code',
                to:{ path: '/vaah/settings/localization' }
            },
            {
                label: 'Notifications',
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

onMounted(async () => {

    store.getAssets();

});

</script>

<template>
    <div class="grid justify-content-center">
        <div class="col-fixed">
            <Menu :model="sidebar_menu_items" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
