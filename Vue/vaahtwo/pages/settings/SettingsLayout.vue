<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A layout declares
// none of them, so Vue's attribute inheritance drops the param on the
// layout's root element - as id="1", id="5", ... - and the same param
// reaches the family layout and the page, so one screen carried the same
// id three or four times. A layout takes nothing from the router, so it
// opts out of the inheritance; the page keeps its own (unique) id.
defineOptions({ inheritAttrs: false });
import {computed, onMounted, ref, watch} from "vue";
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

/* UT-130 (M9-T2) — `/vaah/settings/` is the one admin screen with no heading
   at all: it has no child route, so the content column rendered empty and
   nothing claimed the <h1> slot. The heading is rendered on the index path
   ONLY — every child page brings its own <h1>, and a layout-level heading
   would duplicate it on all of them. */
const is_index = computed(() => route.path === '/vaah/settings/' || route.path === '/vaah/settings');


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

/* UT-102 (M6-T4a Batch 23) — the section index left the previous page's
   title behind. `/vaah/settings/` renders the side menu with no child page,
   so no store ever claimed the document title and the tab kept whatever the
   last visited page had set (observed: "Permissions"). The watcher claims
   the title on the index path only; the child pages keep setting their own
   (they mount after this watcher runs, so they still win). */
watch(() => route.path, (path) => {
    if (path === '/vaah/settings/' || path === '/vaah/settings') {
        store.setPageTitle();
    }
}, { immediate: true });

onMounted(async () => {

    store.getAssets();
    updateSidebarMenuItems(root.assets?.language_strings?.settings_layout ?? {});


});


</script>

<template>
    <div class="grid justify-content-center vc-split-layout">
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
            <h1 v-if="is_index" class="mr-1 vaah-type-title">{{ root.assets?.language_strings?.settings_layout?.settings }}</h1>
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>
/* M6-T4 (F23) — the Message body copy inside the settings suite is reading
   copy. The engine's `.p-message-text` has no font-size of its own, so it
   inherits the app's inherited body size (0.875rem = 12.25px at the 14px
   root) — off the 12 · 13 · 14 · 16 · 20 · 24 scale, and one step below
   the copy it holds. Message copy is supporting copy → 13px, which is what
   the dashboard already applies to the same class. */
::v-deep(.p-message .p-message-text) {
    font-size: 13px;
}
</style>
