<script setup>
import {onMounted, reactive} from "vue";

import { useRootStore } from '../stores/root'
const rootStore = useRootStore();


onMounted(async () => {
    await rootStore.getAssets();
});


</script>


<template>

    <div class="grid">
        <div class="col"><RouterView /></div>
    </div>

</template>
