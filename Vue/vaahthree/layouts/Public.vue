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

        <div class="grid grid-cols-5 gap-4">
            <div class="col-span-3 col-start-2">

                <div class="flex justify-center items-center mt-6 mb-8">

                    <Logo class="w-80 mx-auto" />

                </div>

                <RouterView />

                <Footer class="mt-8" />
            </div>
        </div>

    </div>

</template>
