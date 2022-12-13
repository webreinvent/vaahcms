<template>
    <div class="grid justify-content-center">
        <div class="col-fixed">
            <Menu :model="items" />
        </div>
        <div class="col">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "Settings",
    data(){
        return{
            items: [
                {
                    label: 'Settings',
                    items: [
                        {
                            label: 'General',
                            icon: 'pi pi-cog',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/general' });
                            }
                        },
                        {
                            label: 'User Settings',
                            icon: 'pi pi-user',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/user-settings' });
                            }
                        },
                        {
                            label: 'ENV Variables',
                            icon: 'pi pi-cog',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/env-variables' });
                            }
                        },
                        {
                            label: 'Localization',
                            icon: 'pi pi-code',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/localization' });
                            }
                        },
                        {
                            label: 'Notification',
                            icon: 'pi pi-bell',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/notifications' });
                            }
                        },
                        {
                            label: 'Update',
                            icon: 'pi pi-download',
                            command: () => {
                                this.$router.push({ path: '/vaah/settings/update' });
                            }
                        },
                        {
                            label: 'Reset',
                            icon: 'pi pi-refresh',
                            command: () => {
                                this.$router.push({ path: '/setup' });
                            }
                        },
                    ]},
            ]
        }
    }
}
</script>

<style scoped>

</style>
