<script setup>

import {onMounted} from "vue";

import { useRootStore } from '../../stores/root';
const root = useRootStore();

onMounted(async () => {
    root.toSignIn()
});

</script>
<template>

</template>

