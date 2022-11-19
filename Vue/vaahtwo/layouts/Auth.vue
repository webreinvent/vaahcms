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
            <div class="col-8 mt-6 mx-auto">
                <div class="col"><RouterView /></div>
            </div>
        </div>
    </div>

</template>
