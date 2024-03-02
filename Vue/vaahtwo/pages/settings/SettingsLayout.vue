<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';
import {useRootStore} from "../../stores/root";
const root = useRootStore();
const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();


const menu_pt = ref({
    menuitem: ({ props }) => ({
        class: route.path === props.item.route ? 'p-focus' : ''
    })
});
const sidebar_menu_items = ref([]);


const updateSidebarMenuItems = (settings_layout) => {
    sidebar_menu_items.value = [
        {
            label: settings_layout?.settings ?? '',
            items: [
                {
                    label: settings_layout?.general ?? '',
                    icon: 'pi pi-cog',
                    route: '/vaah/settings/general'
                },
                {
                    label: settings_layout?.user_settings ?? '',
                    icon: 'pi pi-user',
                    route: '/vaah/settings/user-settings'
                },
                {
                    label: settings_layout?.env_variables ?? '',
                    icon: 'pi pi-cog',
                    route: '/vaah/settings/env-variables'
                },
                {
                    label: settings_layout?.localizations ?? '',
                    icon: 'pi pi-code',
                    route: '/vaah/settings/localization'
                },
                {
                    label: settings_layout?.notifications ?? '',
                    icon: 'pi pi-bell',
                    route: '/vaah/settings/notifications'
                },
                {
                    label: settings_layout?.update ?? '',
                    icon: 'pi pi-download',
                    route: '/vaah/settings/update'
                },
                {
                    label: settings_layout?.reset ?? '',
                    icon: 'pi pi-refresh',
                    route: '/setup'
                },
            ]
        },
    ];
};





watch(() => root.assets?.language_strings?.settings_layout, updateSidebarMenuItems);

onMounted(async () => {

    store.getAssets();
    updateSidebarMenuItems(root.assets?.language_strings?.settings_layout ?? {});


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
