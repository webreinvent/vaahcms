<script setup>
import {onMounted, reactive, ref} from "vue";

import { useRootStore } from '../../stores/root'
import ThemeToggle from './ThemeToggle.vue'

const rootStore = useRootStore();
const menu = ref();

onMounted(async () => {
    await rootStore.getTopRightUserMenu();
});

const toggleDropDownMenu= (event) => {
    let self = this;
    menu.value.toggle(event);
}

function getLink(item)
{
    return rootStore.base_url+item.to;
}


</script>

<template>
    <Menubar v-if="rootStore.assets && rootStore.top_menu_items"
             :model="rootStore.top_menu_items"
             class="top-nav-fixed py-2 align-items-center">
        <template #start>
            <div :class="{'w-225':!rootStore.assets.is_logo_compressed_with_sidebar}" class="navbar-logo">
                <img :src="rootStore.assets.backend_logo_url" alt="VaahCMS">
            </div>
        </template>
        <template #item="{item}">
            <a :href="item.url"
               :target="item.target"
               v-tooltip.bottom="item.tooltip"
               :aria-label="item.tooltip"
               :data-testid="'Topnav-'+item.icon.split('-')[1]"
               class="px-2">
                <i class="pi" :class="item.icon"></i></a>
        </template>

        <template #end>
            <ThemeToggle testId="Topnav-DarkModeToggle"
                         @toggle="(m) => rootStore.setDarkMode(m)" />
            <div v-if="rootStore.assets.is_impersonating">
                <InputGroup class="flex-1">
                    <Button size="small" label="Impersonating" outlined  />
                    <InputText size="small" class="" disabled :placeholder="rootStore.assets.auth_user.name" :value="rootStore.assets.auth_user.name" />
                    <Button size="small" @click="rootStore.impersonateLogout()"
                            severity="danger" label="Leave" />
                </InputGroup>
            </div>
            <div v-if="rootStore.assets.auth_user && !rootStore.assets.is_impersonating" class="flex align-items-center">
                <a @click="toggleDropDownMenu"
                   data-testid="Topnav-Avatar"
                   class="cursor-pointer flex align-items-center topnav-account">
                    <Avatar :image="rootStore.assets.auth_user.avatar"
                            class="mr-2" shape="circle" />
                    <!-- M6-T5 — the account name inherited the menubar's
                         12.25px; it is supporting copy, so it takes the
                         13px secondary size. -->
                    <span class="vc-text-13">{{rootStore.assets.auth_user.name}}</span>
                    <i class="pi pi-chevron-down vc-text-13 mt-1 ml-1"></i>
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

/* UT-99 (M6-T4a Batch 21) — the account chip is a plain link whose target
   was the text line box (21px, the height of the 1.5rem avatar beside it),
   under the WCAG 2.2 SC 2.5.8 floor of 24 × 24px. The avatar keeps its
   compact size; only the link's own box grows, so the chip stays a chip. */
.topnav-account {
    min-height: 24px;
}

</style>
