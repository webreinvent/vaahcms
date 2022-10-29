<template>
    <div class="sidebar">
        <PanelMenu :model="items">
            <!--<template #item="{item}">
                <div class="p-panelmenu-panel">
                    <div class="p-component p-panelmenu-header p-highlight">
                       <div class="p-panelmenu-header-content">
                           <a id="pv_id_4_header_1" class="p-panelmenu-header-link" tabindex="0" aria-expanded="true" aria-controls="pv_id_4_content_1"  @click="expandNode(item)">
                               <span class="p-panelmenu-icon pi pi-chevron-down" :id="'arrow-icon' + item.id" v-if="item.items"></span>
                               <span class="p-menuitem-icon" :class="item.icon"></span>
                               <span class="p-menuitem-text">{{item.label}}</span>
                           </a>
                       </div>
                    </div>
                    <div :id="'p-panelmenu-content' + item.id" class="p-toggleable-content" role="region" aria-labelledby="pv_id_4_header_1" v-if="item.items">
                        <div class="p-panelmenu-content">
                            <ul class="p-submenu-list p-panelmenu-root-submenu" role="tree">
                                <li role="none" class="p-menuitem" v-for="sub_item in item.items">
                                  <div class="p-menuitem-content">
                                      <router-link :to='sub_item.to'>
                                          <a class="p-menuitem-link router-link-active" role="treeitem" aria-expanded="false">
                                              <span class="p-menuitem-icon" :class="sub_item.icon"></span>
                                              <span class="p-menuitem-text">{{sub_item.label}}</span>
                                          </a>
                                      </router-link>
                                  </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </template>-->
            <template #item="{item}">
                <div class="p-panelmenu-panel">
                    <div id="pv_id_4_0_header" class="p-panelmenu-header" tabindex="0" role="button" aria-label="File" aria-controls="pv_id_4_0_content">
                        <div class="p-panelmenu-header-content">
                            <a class="p-panelmenu-header-action" tabindex="-1" @click="expandNode(item)">
                                <span class="p-submenu-icon pi pi pi-chevron-down" :id="'arrow-icon' + item.id" v-if="item.items"></span>
                                <span class="p-menuitem-icon pi pi-fw" :class="item.icon"></span>
                                <span class="p-menuitem-text">{{item.label}}</span>
                            </a>
                        </div>
                    </div>
                    <div id="p-panelmenu-content" class="p-toggleable-content" role="region" aria-labelledby="pv_id_4_0_header" style="display: none;">
                        <div class="p-panelmenu-content">
                            <ul class="p-submenu-list p-panelmenu-root-list" id="pv_id_4_0_list" role="tree" tabindex="-1" v-for="sub_item in item.items">
                                <li id="pv_id_4_0_0" class="p-menuitem" role="treeitem" aria-label="New" aria-expanded="false" aria-level="1" aria-setsize="3" aria-posinset="1">
                                    <div class="p-menuitem-content">
                                       <router-link :to="sub_item.to">
                                           <a class="p-menuitem-link" tabindex="-1" aria-hidden="true">
                                               <span class="p-submenu-icon pi pi-fw pi-chevron-right"></span>
                                               <span class="p-menuitem-icon pi pi-fw" :class="sub_item.icon"></span>
                                               <span class="p-menuitem-text">{{sub_item.label}}</span>
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
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            expandedKeys: {},
            items: [
                {
                id:1,
                key: false,
                label: 'Dashboard',
                icon: 'pi pi-compass'
                 },
                {
                    id:2,
                    key: false,
                    label: 'Users & Access',
                    icon: 'pi pi-fw pi-user',
                    items: [{
                        id:2.1,
                        key: false,
                        label: 'Modules',
                        to: '/',
                        icon: 'pi pi-fw pi-align-left'
                    },
                        {
                            key: false,
                            label: 'Right',
                            icon: 'pi pi-fw pi-align-right',
                            to: '/'
                        },
                        {
                            key: false,
                            label: 'Center',
                            icon: 'pi pi-fw pi-align-center',
                            to: '/'
                        },
                        {
                            key: false,
                            label: 'Justify',
                            icon: 'pi pi-fw pi-align-justify',
                            to: '/'
                        }
                    ]
                },
                {
                    id:3,
                    key: false,
                    label: 'Extend',
                    icon: 'pi pi-fw pi-user',
                    items: [{
                        key: false,
                        label: 'Modules',
                        icon: 'pi pi-fw pi-user-plus',
                        to: '/',
                    },
                        {
                            key: false,
                            label: 'Themes',
                            icon: 'pi pi-fw pi-user-minus',
                            to: '/',
                        }
                    ]
                },
                {
                    id:4,
                    key: false,
                    label: 'Settings',
                    icon: 'pi pi-cog',
                    items: [{
                        key: false,
                        label: 'General',
                        icon: 'pi pi-fw pi-cog',
                        to:'/private/settings/general-settings'
                    },
                        {
                            key: false,
                            label: 'User',
                            icon: 'pi pi-fw pi-user',
                            to:'/private/settings/user-settings'
                        },
                        {
                            key: false,
                            label: 'Env Variables',
                            icon: 'pi pi-fw pi-cog',
                            to:'/private/settings/env-variables-settings'
                        },
                        {
                            key: false,
                            label: 'Localization',
                            icon: 'pi pi-fw pi-code',
                            to:'/private/settings/localization-settings'
                        },
                        {
                            key: false,
                            label: 'Notification',
                            icon: 'pi pi-fw pi-bell',
                            to:'/private/settings/notification-settings'
                        },
                        {
                            key: false,
                            label: 'Update',
                            icon: 'pi pi-fw pi-download',
                            to:'/private/settings/update-settings'
                        },
                        {
                            key: false,
                            label: 'Reset',
                            icon: 'pi pi-fw pi-refresh',
                            to:'/private/settings/'
                        }
                    ]
                },
                {
                    id:5,
                    key: false,
                    label: 'Advanced',
                    icon: 'pi pi-fw pi-user',
                    items: [{
                        key: false,
                        label: 'Modules',
                        icon: 'pi pi-fw pi-align-left',
                        to: '/',
                    },
                        {
                            key: false,
                            label: 'Right',
                            icon: 'pi pi-fw pi-align-right',
                            to: '/',
                        },
                        {
                            key: false,
                            label: 'Center',
                            icon: 'pi pi-fw pi-align-center',
                            to: '/',
                        },
                        {
                            key: false,
                            label: 'Justify',
                            icon: 'pi pi-fw pi-align-justify',
                            to: '/',
                        }
                    ]
                },
            ]
        }
    },
    methods: {
        expandAll() {
            for (let node of this.items) {
                this.expandNode(node);
            }
            this.expandedKeys = {
                ...this.expandedKeys
            };
        },
        collapseAll() {
            this.expandedKeys = {};
        },
        expandNode(item) {
            this.items.filter((i) => {
               if(i.id === item.id && i.key === false){
                   i.key = true;
                   document.getElementById('p-panelmenu-content' + item.id).style.display = 'none';
                   document.getElementById('arrow-icon' + item.id).classList.remove('pi-chevron-down');
                   document.getElementById('arrow-icon' + item.id).classList.add('pi-chevron-right');
               }
               else if(i.id === item.id && i.key === true){
                   i.key = false;
                   document.getElementById('p-panelmenu-content' + item.id).style.display = 'initial';
                   document.getElementById('arrow-icon' + item.id).classList.remove('pi-chevron-right')
                   document.getElementById('arrow-icon' + item.id).classList.add('pi-chevron-down')
               }
           });
        }
    }
}
</script>

<style scoped>

</style>
