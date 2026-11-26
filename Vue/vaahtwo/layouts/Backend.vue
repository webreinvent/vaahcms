<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A layout declares
// none of them, so Vue's attribute inheritance drops the param on the
// layout's root element - as id="1", id="5", ... - and the same param
// reaches the family layout and the page, so one screen carried the same
// id three or four times. A layout takes nothing from the router, so it
// opts out of the inheritance; the page keeps its own (unique) id.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";

import Aside from '../components/molecules/Aside.vue';

import { useRootStore } from '../stores/root'
import { useAuthStore } from '../stores/auth';
import {useRoute} from "vue-router";
import Topnav from "../components/molecules/Topnav.vue";
import Footer from "../components/organisms/Footer.vue";
import Sidebar from "../components/molecules/Sidebar.vue";
import Notices from '../components/molecules/Notices.vue'
import {vaah} from "../vaahvue/pinia/vaah";

const rootStore = useRootStore();
const authStore = useAuthStore();
const route = useRoute();

onMounted(async () => {
    authStore.sign_in_items.accessed_route = {};
    authStore.sign_in_items.accessed_route.path = route.path;
    authStore.sign_in_items.accessed_route.query = route.query;


    await rootStore.checkLoggedIn();
    await rootStore.getAssets();
    await rootStore.getPermission();
});

</script>


<template>
    <div id="nav-shell"
         :class="['nav-shell', { 'nav-collapsed': rootStore.sidebar_collapsed }]">

        <div v-if="rootStore.is_logged_in" class="grid" >

            <Topnav />

            <!-- M6 (F31): the nav is a persistent inline rail (always in the
                 layout) instead of the retired modal off-canvas Drawer that
                 closed on every route change. The topnav burger and the
                 `.nav-collapsed` class (rootStore.sidebar_collapsed)
                 maximize/minimize it. -->
            <Sidebar/>

            <div class="grid main-container">

                <div class="col-12">
                    <Notices/>
                    <RouterView></RouterView>
                </div>
            </div>

        </div>

        <Footer />
    </div>
</template>

