<script setup>
import {onMounted, reactive, ref} from "vue";

import Aside from '../components/molecules/Aside.vue';

import { useRootStore } from '../stores/root'
import Topnav from "../components/molecules/Topnav.vue";
import Footer from "../components/organisms/Footer.vue";
import Sidebar from "../components/molecules/Sidebar.vue";
import Notices from '../components/molecules/Notices.vue'


const rootStore = useRootStore();




onMounted(async () => {

    await rootStore.checkLoggedIn();
    await rootStore.getAssets();
    await rootStore.getPermission();
});

</script>


<template>
    <div>

        <div v-if="rootStore.is_logged_in" class="grid" >

            <Topnav />

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

