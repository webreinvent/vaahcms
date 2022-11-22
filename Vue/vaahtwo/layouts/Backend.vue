<script setup>
import {onMounted, reactive} from "vue";

import Aside from '../components/molecules/Aside.vue';

import { useRootStore } from '../stores/root'
import Topnav from "../components/molecules/Topnav.vue";
import Footer from "../components/organisms/Footer.vue";
import Sidebar from "../components/molecules/Sidebar.vue";

const rootStore = useRootStore();


onMounted(async () => {

    await rootStore.checkLoggedIn();
    await rootStore.reloadAssets();
});


</script>


<template>

    <div v-if="rootStore.is_logged_in" class="grid">
        <Topnav />
        <Sidebar/>
        <div class="grid main-container">
            <div class="col-12">
                <RouterView></RouterView>
            </div>
        </div>

    </div>

    <Footer />

</template>
