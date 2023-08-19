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

            <a :href="item.url"
               :target="item.target"
               v-tooltip.bottom="item.tooltip"
               :data-testid="'Topnav-'+item.icon.split('-')[1]"
               class="px-2">
                <i class="pi" :class="item.icon"></i></a>
        </template>
        <template #end>
            <div v-if="rootStore.assets.is_impersonating">
                <div class="p-inputgroup flex-1">
                    <Button size="small" label="Impersonating" outlined  />
                    <InputText class="p-inputtext-sm" disabled :placeholder="rootStore.assets.auth_user.name"
                               :value="rootStore.assets.auth_user.name" />
                    <Button size="small" @click="rootStore.impersonateLogout()"
                            severity="danger" label="Leave" />
                </div>
<!--                <p class="text-red-500"><strong>Impersonating</strong> {{rootStore.assets.auth_user.name}}</p>-->
            </div>
           <div v-if="rootStore.assets.auth_user && !rootStore.assets.is_impersonating" class="flex align-items-center">
               <a @click="toggleDropDownMenu"
                  data-testid="Topnav-Avatar"
                  class="cursor-pointer flex align-items-center">
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
            </TieredMenu>
        </template>
    </Menubar>
</template>

<style scoped>

</style>
