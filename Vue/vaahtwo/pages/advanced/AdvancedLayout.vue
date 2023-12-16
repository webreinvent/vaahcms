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
const menu_pt = ref({
    menuitem: ({ props }) => ({
        class: route.matched && route.matched[3] &&
        route.matched[3].path === props.item.to.path ? 'p-focus' : ''
    })
});
onMounted(async () => {

});


</script>

<template>
    <div class="grid justify-content-center">
        <div class="col-fixed">
            <Menu :model="sidebar_menu_items" :pt="menu_pt" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>

</style>
