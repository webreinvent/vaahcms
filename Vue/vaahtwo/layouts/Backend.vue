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
    await rootStore.getAssets();
});


</script>


<template>

    <div v-if="rootStore.is_logged_in" class="grid">
        <div><Topnav /></div>
        <div class="col-2 mt-6"> <Sidebar/> </div>
<!--        <div class="col-2 mt-6"><Aside/></div>-->
        <div class="col mt-6"><RouterView /></div>
    </div>

    <Footer />

</template>
