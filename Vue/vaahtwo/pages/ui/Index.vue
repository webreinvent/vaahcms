
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
        <draggable
            :list="list"
            :disabled="!enabled"
            item-key="name"
            class="list-group"
            ghost-class="ghost"
            @start="dragging = true"
            @end="dragging = false"
        >
            <template #item="{ element }">
                <div class="list-group-item" :class="{ 'not-draggable': !enabled }">
                    {{ element.name }}
                </div>
            </template>
        </draggable>
        <router-view></router-view>
    </div>
</template>
<script setup>
import draggable from 'vuedraggable';
import { VueTreeList, Tree, TreeNode } from 'vue-tree-list';
import {ref} from "vue";
import Sidebar from "../../organisms/Sidebar.vue";
import Topnav from "../../organisms/Topnav.vue";

const enabled = ref(true);

const list = ref([
    { name: "John", id: 0 },
    { name: "Joao", id: 1 },
    { name: "Jean", id: 2 }
]);
const dragging = ref(false);

const myArray = ref([
    {
        name: 'Node 1',
        id: 1,
        pid: 0,
        dragDisabled: true,
        addTreeNodeDisabled: true,
        addLeafNodeDisabled: true,
        editNodeDisabled: true,
        delNodeDisabled: true,
        children: [
            {
                name: 'Node 1-2',
                id: 2,
                isLeaf: true,
                pid: 1
            }
        ]
    },
    {
        name: 'Node 2',
        id: 3,
        pid: 0,
        disabled: true
    },
    {
        name: 'Node 3',
        id: 4,
        pid: 0
    }
])

const pages = ref([
    {
        label:'Signin',
        to:'/public/signin'
    },
    {
        label:'Signup',
        to:'/public/signup'
    },
    {
        label:'Multi factor authentication',
        to:'/public/multi-factor-auth'
    },
    {
        label:'Forgot Password',
        to:'/public/forgot-password'
    },
    {
        label:'Dashboard',
        to:'/private/dashboard'
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
    },
    {
        label:'Extend',
        to:'/private/extend'
    },
    {
        label:'Taxonomies',
        to:'/private/taxonomies'
    },
    {
        label: 'Media',
        to: '/private/media'
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
    top: 65px;
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
