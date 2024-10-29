<script setup>
import {onMounted, ref, watch} from "vue";
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

onMounted(async () => {
    updateSidebarMenuItems(root.assets?.language_strings?.advanced_layout ?? {});
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
