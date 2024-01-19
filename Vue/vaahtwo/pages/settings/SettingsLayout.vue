<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';

const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();


const menu_pt = ref({
    menuitem: ({ props }) => ({
        class: route.path === props.item.route ? 'p-focus' : ''
    })
});

const sidebar_menu_items = ref([
    {
        label: 'Settings',
        items: [
            {
                label: 'General',
                icon: 'pi pi-cog',
                route: '/vaah/settings/general'
            },
            {
                label: 'User Settings',
                icon: 'pi pi-user',
                route: '/vaah/settings/user-settings'
            },
            {
                label: 'Env Variables',
                icon: 'pi pi-cog',
                route: '/vaah/settings/env-variables'
            },
            {
                label: 'Localizations',
                icon: 'pi pi-code',
                route: '/vaah/settings/localization'
            },
            {
                label: 'Notifications',
                icon: 'pi pi-bell',
                route: '/vaah/settings/notifications'
            },
            {
                label: 'Update',
                icon: 'pi pi-download',
                route: '/vaah/settings/update'
            },
            {
                label: 'Reset',
                icon: 'pi pi-refresh',
                route: '/setup'
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
            <Menu :model="sidebar_menu_items"  class="w-full"
                  :pt="menu_pt">
                <template #item="{ item, props }">
                    <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                        <a v-ripple :href="href" v-bind="props.action" @click="navigate">
                            <span :class="item.icon" />
                            <span class="ml-2">{{ item.label }}</span>
                        </a>
                    </router-link>
                    <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                </template>
            </Menu>
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
