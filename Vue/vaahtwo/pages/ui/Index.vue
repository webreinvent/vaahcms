
<template>
    <div>
        <!--<div style="position: fixed; top:0; left: 33%; z-index:100;">
            <Menubar :model="items">
            </Menubar>
        </div>-->
        <!--<Topnav></Topnav>
        <Sidebar></Sidebar>
        <div class="grid main-container">
            <div class="col-12 mt-6 mx-auto">
                <RouterView></RouterView>
            </div>
        </div>-->
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
                            <router-link :to="slotProps.data.to" class="mr-2" >
                             <Button icon="pi pi-link" class="p-button-rounded p-button-sm"></Button>
                            </router-link>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import Sidebar from "../../components/partials/Sidebar.vue";
import Topnav from "../../components/partials/Topnav.vue";

const pages = ref([
    {
        label:'Signin',
        to:'/public/signin'
    },
    {
        label:'Forgot Password',
        to:'/public/forgot-password'
    },
    {
        label:'Install VaahCMS',
        to:'/public/install/configuration'
    },
    {
        label:'Setup',
        to:'/public/setup'
    },
    {
        label:'Settings',
        to:'/private/settings/general-settings'
    },
    {
        label:'Users',
        to:'/private/users'
    }
])



</script>
<style lang="scss">
.p-component-overlay-enter{
    z-index: 1100 !important;
}
.p-card{
    border-radius: 0.25rem;
    box-shadow: 0 0.5em 1em -0.125em rgb(10 10 10 / 10%), 0 0 0 1px rgb(10 10 10 / 2%);
    .p-card-header{
        box-shadow: 0 0.125em 0.25em rgb(10 10 10 / 10%);
        padding: 10px 1.5rem;
    }
}
.p-menu{
    border-radius: 0.25rem;
    box-shadow: 0 0.5em 1em -0.125em rgb(10 10 10 / 10%), 0 0 0 1px rgb(10 10 10 / 2%);
    border-color: transparent;
}
.main-container{
    width: calc(100% - 210px);
    margin: 55px 5px 0 auto;
}
.top-nav-fixed{
    width: 100%;
    margin-left: auto;
    position: fixed;
    padding-bottom: 4px;
    right: 0;
    top: 0px;
    z-index: 100;
    .navbar-logo{
        width: 200px;
        img{
            max-height: 30px;
            width: 140px;
            margin: auto;
        }
    }
}
.sidebar{
    position: fixed;
    top: 51px;
    left: 0;
    width: 200px;
    z-index: 100;
    max-height: calc(100vh - 60px);
    overflow-y: auto;
    &::-webkit-scrollbar {
        display: none;
    }
    &::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }
    &::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid slategrey;
    }
    .p-panelmenu .p-panelmenu-panel:last-child .p-panelmenu-content{
        border-radius: 0;
    }
    .p-panelmenu .p-panelmenu-panel:first-child .p-panelmenu-header > a{
        border-radius:0;
    }
}
</style>
