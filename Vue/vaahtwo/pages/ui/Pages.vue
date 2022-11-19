<template>
    <div class="grid">
        <div class="col-6 col-offset-3 mt-6">
            <DataTable :value="pages" stripedRows responsiveLayout="scroll" class="p-datatable-sm" showGridlines>
                <Column header="Pages">
                    <template #body="slotProps">
                        <p>{{slotProps.data.label}}</p>
                    </template>
                </Column>
                <Column header="Link">
                    <template #body="slotProps">
                        <router-link :to="slotProps.data.to" class="mr-2" target="_blank">
                            <Button icon="pi pi-link" class="p-button-rounded p-button-sm"></Button>
                        </router-link>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pages",
    data(){
        return{
            pages :[
                {
                    label:'UI elements',
                    to:'/ui/public/ui-elements'
                },
                {
                    label:'Signin',
                    to:'/ui/public/signin'
                },
                {
                    label:'Signup',
                    to:'/ui/public/signup'
                },
                {
                    label:'Multi factor authentication',
                    to:'/ui/public/multi-factor-auth'
                },
                {
                    label:'Forgot Password',
                    to:'/ui/public/forgot-password'
                },
                {
                    label:'Dashboard',
                    to:'/ui/private/dashboard'
                },
                {
                    label:'Install VaahCMS',
                    to:'/ui/public/install/configuration'
                },
                {
                    label:'Setup',
                    to:'/ui/public/setup'
                },
                {
                    label:'Settings',
                    to:'/ui/private/settings/general-settings'
                },
                {
                    label:'Users',
                    to:'/ui/private/users'
                },
                {
                    label:'Extend',
                    to:'/ui/private/extend'
                },
                {
                    label:'Taxonomies',
                    to:'/ui/private/taxonomies'
                },
                {
                    label: 'Media',
                    to: '/ui/private/media'
                },
                {
                    label: 'Content Types',
                    to: '/ui/private/content'
                },
                {
                    label: 'Menu Types',
                    to: '/ui/private/menu'
                }

            ]
        }
    },
}
</script>

<style lang="scss">

</style>
