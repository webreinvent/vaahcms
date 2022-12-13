<script setup>
import {onMounted, reactive, ref} from "vue";

import { useRootStore } from '../../stores/root'

const rootStore = useRootStore();
const menu = ref();

onMounted(async () => {
    await rootStore.getTopRightUserMenu();
});

const toggleDropDownMenu= (event) => {
    let self = this;
    menu.value.toggle(event);
}

</script>

<template>
    <Menubar v-if="rootStore.assets && rootStore.top_menu_items"
             :model="rootStore.top_menu_items"
             class="top-nav-fixed py-2 align-items-center">
        <template #start>
            <div class="navbar-logo">
                <img :src="rootStore.assets.backend_logo_url" alt="VaahCMS">
            </div>
        </template>
        <template #item="{item}">
            <router-link :to="item.to" custom v-slot="{href, route, navigate, isActive, isExactActive}">
                <a :href="href" @click="navigate" class="mx-2"><i class="pi" :class="item.icon"></i></a>
            </router-link>
        </template>
        <template #end>
           <div v-if="rootStore.assets.auth_user" class="flex align-items-center">
               <a @click="toggleDropDownMenu" class="cursor-pointer flex align-items-center">
                   <Avatar :image="rootStore.assets.auth_user.avatar"
                           class="mr-2" shape="circle" />
                   <span>{{rootStore.assets.auth_user.name}}</span>
                   <i class="pi pi-chevron-down text-sm mt-1 ml-1"></i>
               </a>
           </div>
            <TieredMenu  v-if="rootStore && rootStore.top_right_user_menu"
                         :model="rootStore.top_right_user_menu"
                         ref="menu"
                         :popup="true"
            >
                <template #item="{item}">
                    <a :href="item.url">
                        <span><i :class="item.icon + ' mx-2 my-2 py-1'" /></span>
                        {{item.label}}
                    </a>
                </template>
            </TieredMenu>
        </template>
    </Menubar>
</template>

<style scoped>

</style>
