<script setup>

import {onMounted} from "vue";
import {useRoute} from "vue-router";
import {vaah} from '../../vaahvue/pinia/vaah'
import { useRootStore } from '../../stores/root';
import { useAuthStore } from '../../stores/auth';
const root = useRootStore();
const authStore = useAuthStore();

const route = useRoute();

onMounted(async () => {
    authStore.sign_in_items.accessed_route = vaah().clone(route);
    authStore.sign_in_items.accessed_route.is_accessed = true;
    root.toSignIn();
});

</script>
<template>

</template>

