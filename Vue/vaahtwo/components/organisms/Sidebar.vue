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
<!--<style>
.p-panelmenu .p-panelmenu-header {
    outline: 0 none;
}
.p-panelmenu .p-panelmenu-header .p-panelmenu-header-content {
    border: 1px solid #e5e7eb;
    color: #3f3f46;
    background: #fafafa;
    border-radius: 0.375rem;
    transition: none;
}
.p-panelmenu .p-panelmenu-header .p-panelmenu-header-content .p-panelmenu-header-action {
    padding: 1.25rem;
    font-weight: 700;
}
.p-panelmenu .p-panelmenu-header .p-panelmenu-header-content .p-panelmenu-header-action .p-submenu-icon {
    margin-right: 0.5rem;
}
.p-panelmenu .p-panelmenu-header .p-panelmenu-header-content .p-panelmenu-header-action .p-menuitem-icon {
    margin-right: 0.5rem;
}
.p-panelmenu .p-panelmenu-header:not(.p-disabled):focus .p-panelmenu-header-content {
    outline: 0 none;
    outline-offset: 0;
    box-shadow: inset 0 0 0 1px #6366F1;
}
.p-panelmenu .p-panelmenu-header:not(.p-highlight):not(.p-disabled):hover .p-panelmenu-header-content {
    background: #f4f4f5;
    border-color: #e5e7eb;
    color: #3f3f46;
}
.p-panelmenu .p-panelmenu-header:not(.p-disabled).p-highlight .p-panelmenu-header-content {
    background: #fafafa;
    border-color: #e5e7eb;
    color: #3f3f46;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    margin-bottom: 0;
}
.p-panelmenu .p-panelmenu-header:not(.p-disabled).p-highlight:hover .p-panelmenu-header-content {
    border-color: #e5e7eb;
    background: #f4f4f5;
    color: #3f3f46;
}
.p-panelmenu .p-panelmenu-content {
    padding: 0.25rem 0;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #3f3f46;
    border-top: 0;
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.p-panelmenu .p-panelmenu-content .p-panelmenu-root-list {
    outline: 0 none;
}
.p-panelmenu .p-panelmenu-content .p-menuitem > .p-menuitem-content {
    color: #3f3f46;
    transition: none;
    border-radius: 0;
}
.p-panelmenu .p-panelmenu-content .p-menuitem > .p-menuitem-content .p-menuitem-link {
    padding: 0.75rem 1rem;
    user-select: none;
}
.p-panelmenu .p-panelmenu-content .p-menuitem > .p-menuitem-content .p-menuitem-link .p-menuitem-text {
    color: #3f3f46;
}
.p-panelmenu .p-panelmenu-content .p-menuitem > .p-menuitem-content .p-menuitem-link .p-menuitem-icon {
    color: #71717A;
    margin-right: 0.5rem;
}
.p-panelmenu .p-panelmenu-content .p-menuitem > .p-menuitem-content .p-menuitem-link .p-submenu-icon {
    color: #71717A;
}
.p-panelmenu .p-panelmenu-content .p-menuitem.p-highlight > .p-menuitem-content {
    color: #3f3f46;
    background: #f4f4f5;
}
.p-panelmenu .p-panelmenu-content .p-menuitem.p-highlight > .p-menuitem-content .p-menuitem-link .p-menuitem-text {
    color: #3f3f46;
}
.p-panelmenu .p-panelmenu-content .p-menuitem.p-highlight > .p-menuitem-content .p-menuitem-link .p-menuitem-icon, .p-panelmenu .p-panelmenu-content .p-menuitem.p-highlight > .p-menuitem-content .p-menuitem-link .p-submenu-icon {
    color: #71717A;
}
.p-panelmenu .p-panelmenu-content .p-menuitem.p-highlight.p-focus > .p-menuitem-content {
    background: #f4f4f5;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled).p-focus > .p-menuitem-content {
    color: #18181B;
    background: #e5e7eb;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled).p-focus > .p-menuitem-content .p-menuitem-link .p-menuitem-text {
    color: #18181B;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled).p-focus > .p-menuitem-content .p-menuitem-link .p-menuitem-icon, .p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled).p-focus > .p-menuitem-content .p-menuitem-link .p-submenu-icon {
    color: #18181B;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled) > .p-menuitem-content:hover {
    color: #18181B;
    background: #f4f4f5;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled) > .p-menuitem-content:hover .p-menuitem-link .p-menuitem-text {
    color: #18181B;
}
.p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled) > .p-menuitem-content:hover .p-menuitem-link .p-menuitem-icon, .p-panelmenu .p-panelmenu-content .p-menuitem:not(.p-highlight):not(.p-disabled) > .p-menuitem-content:hover .p-menuitem-link .p-submenu-icon {
    color: #71717A;
}
.p-panelmenu .p-panelmenu-content .p-menuitem .p-menuitem-content .p-menuitem-link .p-submenu-icon {
    margin-right: 0.5rem;
}
.p-panelmenu .p-panelmenu-content .p-menuitem-separator {
    border-top: 1px solid #f3f4f6;
    margin: 0.25rem 0;
}
.p-panelmenu .p-panelmenu-content .p-submenu-list:not(.p-panelmenu-root-list) {
    padding: 0 0 0 1rem;
}
.p-panelmenu .p-panelmenu-panel {
    margin-bottom: 0;
}
.p-panelmenu .p-panelmenu-panel .p-panelmenu-header .p-panelmenu-header-content {
    border-radius: 0;
}
.p-panelmenu .p-panelmenu-panel .p-panelmenu-content {
    border-radius: 0;
}
.p-panelmenu .p-panelmenu-panel:not(:first-child) .p-panelmenu-header .p-panelmenu-header-content {
    border-top: 0 none;
}
.p-panelmenu .p-panelmenu-panel:not(:first-child) .p-panelmenu-header:not(.p-highlight):not(.p-disabled):hover .p-panelmenu-header-content, .p-panelmenu .p-panelmenu-panel:not(:first-child) .p-panelmenu-header:not(.p-disabled).p-highlight:hover .p-panelmenu-header-content {
    border-top: 0 none;
}
.p-panelmenu .p-panelmenu-panel:first-child .p-panelmenu-header .p-panelmenu-header-content {
    border-top-right-radius: 0.375rem;
    border-top-left-radius: 0.375rem;
}
.p-panelmenu .p-panelmenu-panel:last-child .p-panelmenu-header:not(.p-highlight) .p-panelmenu-header-content {
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.p-panelmenu .p-panelmenu-panel:last-child .p-panelmenu-content {
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
</style>-->
