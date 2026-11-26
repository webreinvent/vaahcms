<script setup>
import {onMounted, reactive} from "vue";

import { useRootStore } from '../stores/root'
const rootStore = useRootStore();


onMounted(async () => {
    await rootStore.getAssets();
    await rootStore.checkLoggedIn();
});


</script>


<template>

    <div class="public-pages">
        <div class="grid">
            <!-- UT-56 — see layouts/Public.vue: `col-8` squeezed the
                 sign-in / signup forms into a 223px column on a 375px
                 viewport. Full width below `md`, 8/12 from `md` up. -->
            <div class="col-12 md:col-8 mt-6 mx-auto">
                <div class="col"><RouterView /></div>
            </div>
        </div>
    </div>

</template>
