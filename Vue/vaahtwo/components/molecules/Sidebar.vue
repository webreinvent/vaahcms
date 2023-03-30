<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRootStore } from "../../stores/root";

const root = useRootStore();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();
});
const nonMenuItems = ['Env Variables','Update','Reset'];
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

        <div v-for="items in root.assets.extended_views.sidebar_menu.success">
            <PanelMenu :model="items">
                <template #item="{item}">
                    <div class="p-panelmenu-header-content" v-if="root.assets.auth_user.role">
                        <a :href="item.url"
                           class="p-panelmenu-header-action p-menuitem-link"
                           :data-testid="'sidebar-'+item.label"
                           tabindex="-1">
                            <span v-if="item.items" class="p-submenu-icon pi pi-chevron-right">

                            </span>
                            <span class="p-menuitem-icon" :class="item.icon">

                            </span>
                            <span class="p-menuitem-text">{{item.label}}</span>
                        </a>
                    </div>
                    <div class="p-panelmenu-header-content" v-else>
                        <a :href="item.url"
                           class="p-panelmenu-header-action p-menuitem-link"
                           :data-testid="'sidebar-'+item.label"
                           v-if="!nonMenuItems.includes(item.label)"
                           tabindex="-1">
                            <span v-if="item.items" class="p-submenu-icon pi pi-chevron-right">

                            </span>
                            <span class="p-menuitem-icon" :class="item.icon">

                            </span>
                            <span class="p-menuitem-text">{{item.label}}</span>
                        </a>
                    </div>

                </template>
            </PanelMenu>
        </div>
    </div>
</template>
