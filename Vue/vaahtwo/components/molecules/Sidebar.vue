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
            <PanelMenu :model="items">
                <template #item="{item}">
                    <div class="p-panelmenu-panel">
                        <div id="pv_id_4_0_header"
                             class="p-panelmenu-header"
                             tabindex="0" role="button"
                             aria-label="File"
                             aria-controls="pv_id_4_0_content"
                        >

                            <div class="p-panelmenu-header-content">
                                <a class="p-panelmenu-header-action"
                                   tabindex="-1" @click="expandNode(item)"
                                >
                                    <span class="p-submenu-icon pi pi pi-chevron-down"
                                          :id="'arrow-icon' + item.index"
                                          v-if="item.items"
                                    >
                                    </span>
                                    <span class="p-menuitem-icon pi pi-fw " :class="item.icon"></span>
                                    <span class="p-menuitem-text">{{ item.label }}</span>
                                </a>
                            </div>
                        </div>

                        <div id="p-panelmenu-content"
                             class="p-toggleable-content"
                             role="region"
                             aria-labelledby="pv_id_4_0_header"
                             style="display: none;"
                        >
                            <div class="p-panelmenu-content">
                                <ul class="p-submenu-list p-panelmenu-root-list"
                                    id="pv_id_4_0_list"
                                    role="tree"
                                    tabindex="-1"
                                    v-for="sub_item in item.items"
                                >

                                    <li id="pv_id_4_0_0"
                                        class="p-menuitem"
                                        role="treeitem"
                                        aria-label="New"
                                        aria-expanded="false"
                                        aria-level="1"
                                        aria-setsize="3"
                                        aria-posinset="1"
                                    >

                                        <div class="p-menuitem-content">
                                            <router-link :to="sub_item.to">
                                                <a class="p-menuitem-link"
                                                   tabindex="-1"
                                                   aria-hidden="true"
                                                >
                                                    <span class="p-submenu-icon pi pi-fw pi-chevron-right">
                                                    </span>
                                                    <span class="p-menuitem-icon pi pi-fw "
                                                          :class="sub_item.icon">
                                                    </span>

                                                    <span class="p-menuitem-text">
                                                        {{ sub_item.label }}
                                                    </span>
                                                    <span class="p-ink" role="presentation"></span>
                                                </a>
                                            </router-link>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </template>
            </PanelMenu>
        </div>
    </div>
</template>
