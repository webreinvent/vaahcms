<script setup>
import {onMounted, ref} from "vue";
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
                command: () => {
                    this.$router.push({ path: '/vaah/settings/general' });
                }
            },
            {
                label: 'User Settings',
                icon: 'pi pi-user',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/user-settings' });
                }
            },
            {
                label: 'ENV Variables',
                icon: 'pi pi-cog',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/env-variables' });
                }
            },
            {
                label: 'Localization',
                icon: 'pi pi-code',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/localization' });
                }
            },
            {
                label: 'Notification',
                icon: 'pi pi-bell',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/notifications' });
                }
            },
            {
                label: 'Update',
                icon: 'pi pi-download',
                command: () => {
                    this.$router.push({ path: '/vaah/settings/update' });
                }
            },
            {
                label: 'Reset',
                icon: 'pi pi-refresh',
                command: () => {
                    this.$router.push({ path: '/setup' });
                }
            },
        ]},
]);

onMounted(async () => {
    await store.reload();
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
