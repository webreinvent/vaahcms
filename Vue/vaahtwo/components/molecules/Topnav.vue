<script setup>
import { onMounted , ref} from 'vue';
import { useRootStore } from "../../stores/root";

const root = useRootStore();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();
    await root.menuItems();
});

const menu = ref();

const toggle = (event) => {
    menu.value.toggle(event);
}

const items = ref( [
    {
        to:'/',
        title:'',
        icon:'pi pi-home'
    },
    {
        to:'/',
        title:'',
        icon:'pi pi-link'
    }
]);


if(root &&  root.assets && root.assets.extended_views) {
    const manu_items_value =  root.assets.extended_views.top_right_user_menu.success;
    const menu_item = ref(manu_items_value);
}


</script>

<template>
    <div v-if="root && root.assets && root.assets.extended_views && root.assets.extended_views.top_right_user_menu">
        <Menubar :model="items" class="top-nav-fixed py-2">
            <template #start>
                <div class="navbar-logo">
                    <img src="https://develop.jalapeno.app/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="VaahCMS">
                </div>
            </template>

            <template #item="{item}">
                <router-link :to="item.to" custom v-slot="{href, route, navigate, isActive, isExactActive}">
                    <a :href="href" @click="navigate" class="mx-2"><i class="pi" :class="item.icon"></i></a>
                </router-link>
            </template>

            <template #end>
                <Button icon="pi pi-bars" @click="toggle"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                />

<!--                <template v-for="menu_options in root.assets.extended_views.top_right_user_menu.success">-->
<!--                    <template v-for="link in menu_options">-->
<!--                        <TieredMenu id="overlay_menu" :model="link" ref="menu" :popup="true" />-->
<!--                    </template>-->
<!--                </template>-->

<!--                <template v-for="menu_options in root.assets.extended_views.top_right_user_menu.success">-->
<!--                    <TieredMenu id="overlay_menu" :model="menu_options" ref="menu" :popup="true" />-->
<!--                </template>-->

                <TieredMenu id="overlay_menu" :model="root.assets.extended_views.top_right_user_menu.success.vaahcms" ref="menu" :popup="true" />
            </template>
        </Menubar>
    </div>
</template>
