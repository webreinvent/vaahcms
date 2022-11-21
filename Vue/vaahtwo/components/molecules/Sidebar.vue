<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRootStore } from "../../stores/root";

const root = useRootStore();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();
});

const expandNode = (item) => {
    root.assets.extended_views.sidebar_menu.success.vaahcms.filter((i) => {
        if(i.index === item.index && i.key === false){
            i.key = true;
            document.getElementById('p-panelmenu-content' + item.index).style.display = 'none';
            document.getElementById('arrow-icon' + item.index).classList.remove('pi-chevron-down');
            document.getElementById('arrow-icon' + item.index).classList.add('pi-chevron-right');
        }
        else if(i.id === item.index && i.key === true){
            i.key = false;
            document.getElementById('p-panelmenu-content' + item.index).style.display = 'initial';
            document.getElementById('arrow-icon' + item.index).classList.remove('pi-chevron-right')
            document.getElementById('arrow-icon' + item.index).classList.add('pi-chevron-down')
        }
    });
}

</script>

<template>
    <div class="sidebar"
         v-if="root && root.assets && root.assets.extended_views && root.assets.extended_views.sidebar_menu"
    >
        <div v-for="items in root.assets.extended_views.sidebar_menu.success">
            <PanelMenu :model="items"></PanelMenu>
        </div>
    </div>
</template>
