<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

const route = useRoute();

const sidebar_menu_items = ref([
    {
        label: 'ADVANCED',
        items: [
            {
                label: 'Logs',
                icon: 'pi pi-book',
                to:{ path: '/vaah/advanced/logs' }
            },
            {
                label: 'Jobs',
                icon: 'pi pi-align-justify',
                to:{ path: '/vaah/advanced/jobs' }
            },
            {
                label: 'Failed Jobs',
                icon: 'pi pi-times-circle',
                to:{ path: '/vaah/advanced/failedjobs' }
            },
            {
                label: 'Batches',
                icon: 'pi pi-server',
                to:{ path: '/vaah/advanced/batches' }
            }
        ]},
]);

onMounted(async () => {


});
const updateSelectedItem = () => {
    const route_path = route.path;
    sidebar_menu_items.value.forEach((item) => {
        item.items.forEach((sub_item) =>{
            const sub_item_path = sub_item.to.path ;
            sub_item.class = sub_item_path === route_path ? 'p-menuitem p-focus' : '';
        });
    });
};
watch(() => route.path, updateSelectedItem);
onMounted(updateSelectedItem);

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
