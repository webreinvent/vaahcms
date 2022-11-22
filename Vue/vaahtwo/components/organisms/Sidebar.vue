<template>
    <div class="sidebar">
        <!--<PanelMenu :model="items">
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
                    <div :id="'p-panelmenu-content' + item.id" class="p-toggleable-content" role="region" aria-labelledby="pv_id_4_0_header" style="display: none;">
                        <div class="p-panelmenu-content">
                            <ul class="p-submenu-list" id="pv_id_4_0_list" role="tree" tabindex="-1" v-for="sub_item in item.items">
                                <li class="p-menuitem" role="treeitem" aria-label="New" aria-expanded="false" aria-level="1" aria-setsize="3" aria-posinset="1">
                                    <div class="p-menuitem-content">
                                       <router-link :to="sub_item.to">
                                           <a class="p-menuitem-link router-link-active" tabindex="-1">
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
        </PanelMenu>-->
        <PanelMenu :model="items" />
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            expandedKeys: {},
            items: [{
                key: '0',
                label: 'Dashboard',
                icon: 'pi pi-fw pi-compass',
                to:'/ui/private/dashboard'
            },
                {
                    key: '1',
                    label: 'Settings',
                    icon: 'pi pi-fw pi-cog',
                    items: [{
                        key: '1_0',
                        label: 'General Settings',
                        icon: 'pi pi-fw pi-cog',
                        to:'/ui/private/settings/general-settings'
                    },
                        {
                            key: '1_1',
                            label: 'User Settings',
                            icon: 'pi pi-fw pi-user',
                            to:'/ui/private/settings/user-settings'
                        },
                        {
                            key: '1_2',
                            label: 'ENV variables',
                            icon: 'pi pi-fw pi-cog',
                            to:'/ui/private/settings/env-variables-settings'
                        },
                        {
                            key: '1_3',
                            label: 'Localization',
                            icon: 'pi pi-fw pi-code',
                            to:'/ui/private/settings/localization-settings'
                        },
                        {
                            key: '1_4',
                            label: 'Notification',
                            icon: 'pi pi-fw pi-bell',
                            to:'/ui/private/settings/notification-settings'
                        },
                        {
                            key: '1_5',
                            label: 'Update',
                            icon: 'pi pi-fw pi-download',
                            to:'/ui/private/settings/update-settings'
                        },
                        {
                            key: '1_6',
                            label: 'Reset',
                            icon: 'pi pi-fw pi-refresh',
                            to:'/ui/public/setup'
                        }
                    ]
                },
                {
                    key: '2',
                    label: 'Users',
                    icon: 'pi pi-fw pi-user',
                    items: [{
                        key: '2_0',
                        label: 'New',
                        icon: 'pi pi-fw pi-user-plus',

                    },
                        {
                            key: '2_1',
                            label: 'Delete',
                            icon: 'pi pi-fw pi-user-minus',
                        },
                        {
                            key: '2_2',
                            label: 'Search',
                            icon: 'pi pi-fw pi-users',
                            items: [{
                                key: '2_2_0',
                                label: 'Filter',
                                icon: 'pi pi-fw pi-filter',
                                items: [{
                                    key: '2_2_0_0',
                                    label: 'Print',
                                    icon: 'pi pi-fw pi-print'
                                }]
                            },
                                {
                                    key: '2_2_1',
                                    icon: 'pi pi-fw pi-bars',
                                    label: 'List'
                                }
                            ]
                        }
                    ]
                },
                {
                    key: '3',
                    label: 'Events',
                    icon: 'pi pi-fw pi-calendar',
                    items: [{
                        key: '3_0',
                        label: 'Edit',
                        icon: 'pi pi-fw pi-pencil',
                        items: [{
                            key: '3_0_0',
                            label: 'Save',
                            icon: 'pi pi-fw pi-calendar-plus'
                        },
                            {
                                key: '3_0_0',
                                label: 'Delete',
                                icon: 'pi pi-fw pi-calendar-minus'
                            }
                        ]
                    },
                        {
                            key: '3_1',
                            label: 'Archieve',
                            icon: 'pi pi-fw pi-calendar-times',
                            items: [{
                                key: '3_1_0',
                                label: 'Remove',
                                icon: 'pi pi-fw pi-calendar-minus'
                            }]
                        }
                    ]
                }
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
        expandNode(node) {
            if (node.items && node.items.length) {
                this.expandedKeys[node.key] = true;

                for (let child of node.items) {
                    this.expandNode(child);
                }
            }
        }
    }
}
</script>
<style lang="scss">
.p-panelmenu {
    .p-panelmenu-header {
        .p-panelmenu-header-action{
            border-radius: 0;
        }
        }
    }
</style>
