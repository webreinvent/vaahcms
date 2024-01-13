<script setup>

import {onMounted} from "vue";
import {useRoute} from "vue-router";
import { useRootStore } from '../../stores/root';
import { useAuthStore } from '../../stores/auth';
const root = useRootStore();
const authStore = useAuthStore();

const route = useRoute();

onMounted(async () => {
    authStore.sign_in_items.hash_path = route.path;
    root.toSignIn();
});

</script>
<template>

</template>

