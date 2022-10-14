<script setup>
import {ref} from "vue";

const items = ref([
    {
        label:'Public',
        icon:'pi pi-fw pi-file',
        items:[
            {
                label:'New',
                icon:'pi pi-fw pi-plus',
                items:[
                    {
                        label:'Bookmark',
                        icon:'pi pi-fw pi-bookmark'
                    },
                    {
                        label:'Video',
                        icon:'pi pi-fw pi-video'
                    }
                ]
            },
            {
                label:'Delete',
                icon:'pi pi-fw pi-trash'
            },
            {
                separator:true
            },
            {
                label:'Export',
                icon:'pi pi-fw pi-external-link'
            }
        ]
    },
    {
        label:'Settings',
        icon:'pi pi-fw pi-pencil',
        items: [
            {
                label: 'General',
                icon: 'pi pi-cog',
                command: () => {
                    this.$router.push('settings/general-settings');
                }
            },
            {
                label: 'User Settings',
                icon: 'pi pi-user',
                command: () => {
                    this.$router.push('settings/user-settings');
                }
            },
            {
                label: 'ENV Variables',
                icon: 'pi pi-cog',
                command: () => {
                    this.$router.push('settings/env-variables-settings');
                }
            },
            {
                label: 'Localization',
                icon: 'pi pi-code',
                command: () => {
                    this.$router.push('settings/localization-settings');
                }
            },
            {
                label: 'Notification',
                icon: 'pi pi-bell',
                command: () => {
                    this.$router.push('settings/notification-settings');
                }
            },
            {
                label: 'Update',
                icon: 'pi pi-download',
                command: () => {
                    this.$router.push('settings/update-settings');
                }
            },
            {
                label: 'Reset',
                icon: 'pi pi-refresh',
                command: () => {
                    this.$router.push('settings/account');
                }
            },
        ]
    },
    {
        label:'Advance',
        icon:'pi pi-fw pi-user',
        items:[
            {
                label:'New',
                icon:'pi pi-fw pi-user-plus',
            },
            {
                label:'Delete',
                icon:'pi pi-fw pi-user-minus',
            },
            {
                label:'Search',
                icon:'pi pi-fw pi-users',
                items:[
                    {
                        label:'Filter',
                        icon:'pi pi-fw pi-filter',
                        items:[
                            {
                                label:'Print',
                                icon:'pi pi-fw pi-print'
                            }
                        ]
                    },
                    {
                        icon:'pi pi-fw pi-bars',
                        label:'List'
                    }
                ]
            }
        ]
    },
    {
        label:'Events',
        icon:'pi pi-fw pi-calendar',
        items:[
            {
                label:'Edit',
                icon:'pi pi-fw pi-pencil',
                items:[
                    {
                        label:'Save',
                        icon:'pi pi-fw pi-calendar-plus'
                    },
                    {
                        label:'Delete',
                        icon:'pi pi-fw pi-calendar-minus'
                    }
                ]
            },
            {
                label:'Archieve',
                icon:'pi pi-fw pi-calendar-times',
                items:[
                    {
                        label:'Remove',
                        icon:'pi pi-fw pi-calendar-minus'
                    }
                ]
            }
        ]
    },
    {
        label:'Quit',
        icon:'pi pi-fw pi-power-off'
    }
]);



</script>
<template>
    <div>
        <div style="position: fixed; top:0; left: 33%;">
            <Menubar :model="items">
            </Menubar>
        </div>

        <RouterView />

    </div>
</template>
