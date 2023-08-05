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
         v-if="root && root.assets && root.assets.extended_views
          && root.assets.extended_views.sidebar_menu"
    >
        <div v-for="menus in root.assets.extended_views.sidebar_menu.success">
            <PanelMenu :model="menus" v-model:expandedKeys="root.sidebar_expanded_keys">
                <template #item="{item}">

                    <div class="p-panelmenu-header-content">
                        <a v-if="!item.items" :href="item.link ?? ''"
                           class="p-panelmenu-header-action p-menuitem-link"
                           :data-testid="'sidebar-'+item.label ?? ''"
                           tabindex="-1">

                            <span v-if="item.icon" class="p-menuitem-icon" :class="'pi pi-'+item.icon">

                            </span>
                            <span v-if="item.label" class="p-menuitem-text">{{item.label}}</span>
                        </a>
                        <a v-else
                           class="p-panelmenu-header-action p-menuitem-link"
                           :data-testid="'sidebar-'+item.label ?? ''"
                           tabindex="-1">

                            <span v-if="item.icon" class="p-menuitem-icon" :class="'pi pi-'+item.icon">

                            </span>
                            <span v-if="item.label" class="p-menuitem-text">{{item.label}}</span>
                            <span v-if="item.items" class="p-submenu-icon pi pi-chevron-right">

                            </span>
                        </a>
                    </div>

                </template>
            </PanelMenu>
        </div>
    </div>
</template>
