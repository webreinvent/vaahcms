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
import {useRootStore} from "../../stores/root";
const root = useRootStore();
const route = useRoute();

const menu_pt = ref({
    menuitem: ({ props }) => ({
        class: route.path === props.item.route ? 'p-focus' : ''
    })
});



const sidebar_menu_items = ref([]);

const updateSidebarMenuItems = (advanced_layout) => {
    sidebar_menu_items.value = [
        {
            label: advanced_layout?.advanced ?? '',
            items: [
                {
                    label: advanced_layout?.logs ?? '',
                    icon: 'pi pi-book',
                    route: '/vaah/advanced/logs'
                },
                {
                    label: advanced_layout?.jobs ?? '',
                    icon: 'pi pi-align-justify',
                    route: '/vaah/advanced/jobs'
                },
                {
                    label: advanced_layout?.failed_jobs ?? '',
                    icon: 'pi pi-times-circle',
                    route: '/vaah/advanced/failedjobs'
                },
                {
                    label: advanced_layout?.batches ?? '',
                    icon: 'pi pi-server',
                    route: '/vaah/advanced/batches'
                }
            ]
        },
    ];
};

watch(() => root.assets?.language_strings?.advanced_layout, updateSidebarMenuItems);

/* UT-102 (M6-T4a Batch 23) — see SettingsLayout.vue: the section index
   rendered the side menu with no child page, so nothing claimed the document
   title and the tab kept the previous page's ("Dashboard"). The child pages
   set their own titles when they mount, so only the index path is claimed
   here. The label comes from the same language strings the menu uses, so
   the title is translated like the menu. */
const advancedLabel = computed(() => root.assets?.language_strings?.advanced_layout?.advanced || 'Advanced');

watch([() => route.path, advancedLabel], ([path, label]) => {
    if (path === '/vaah/advanced/' || path === '/vaah/advanced') {
        document.title = label;
    }
}, { immediate: true });

onMounted(async () => {
    updateSidebarMenuItems(root.assets?.language_strings?.advanced_layout ?? {});
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
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
