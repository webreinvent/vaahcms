<script setup>
import {useRootStore} from "../../stores/root";

const root = useRootStore();
</script>
<template>
    <div v-if="root && root.assets">
        <img :src="root.assets.backend_logo_url"
             alt=""
             class="w-5 mb-2">
    </div>
</template>
