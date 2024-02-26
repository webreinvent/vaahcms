<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import {useLogStore} from "../../stores/advanced/store-logs";
const store = useLogStore();
const route = useRoute();

const menu_pt = ref({
    menuitem: ({ props }) => ({
        class: route.path === props.item.route ? 'p-focus' : ''
    })
});



const advanceValue = ref('');
const sidebar_menu_items = ref([]);

const updateSidebarMenuItems = (languageStrings) => {
    sidebar_menu_items.value = [
        {
            label: languageStrings.advanced,
            items: [
                {
                    label: languageStrings.logs,
                    icon: 'pi pi-book',
                    route: '/vaah/advanced/logs'
                },
                {
                    label: languageStrings.jobs,
                    icon: 'pi pi-align-justify',
                    route: '/vaah/advanced/jobs'
                },
                {
                    label: languageStrings.failed_jobs,
                    icon: 'pi pi-times-circle',
                    route: '/vaah/advanced/failedjobs'
                },
                {
                    label: languageStrings.batches,
                    icon: 'pi pi-server',
                    route: '/vaah/advanced/batches'
                }
            ]
        },
    ];
};

watch(() => store.assets, (newAssets) => {
    advanceValue.value = newAssets.language_strings.advanced;
    updateSidebarMenuItems(newAssets.language_strings);
});
onMounted(async () => {
    updateSidebarMenuItems(store.assets.language_strings);

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
