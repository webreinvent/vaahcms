<script setup>
import {useRootStore} from "../../stores/root";

const root = useRootStore();
</script>
<template>
    <img v-if="root.assets" :src="root.assets.backend_logo_url"
         alt=""
         class=" mb-2">
</template>
