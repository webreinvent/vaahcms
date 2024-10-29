<script setup>
import {onMounted, reactive} from "vue";

import { useRootStore } from '../stores/root'
import Logo from "../components/molecules/Logo.vue";
import Footer from "../components/organisms/Footer.vue";
const rootStore = useRootStore();


onMounted(async () => {
    await rootStore.getAssets();
});


</script>


<template>

    <div class="public-pages">

        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-4 md:col-start-2">

                <div class="flex justify-center items-center mt-6 mb-8">

                    <Logo class="w-80 mx-auto" />

                </div>

                <RouterView />

                <Footer class="mt-8" />
            </div>
        </div>

    </div>

</template>
