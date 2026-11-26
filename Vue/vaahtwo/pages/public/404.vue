<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

import {onMounted} from "vue";
import {useRoute} from "vue-router";
import {vaah} from '../../vaahvue/pinia/vaah'
import { useRootStore } from '../../stores/root';
import { useAuthStore } from '../../stores/auth';
const root = useRootStore();
const authStore = useAuthStore();

const route = useRoute();

onMounted(async () => {
    authStore.sign_in_items.accessed_route = {};
    authStore.sign_in_items.accessed_route.path = route.path;
    authStore.sign_in_items.accessed_route.query = route.query;
    authStore.sign_in_items.accessed_route.is_accessed = true;
    root.toSignIn();
});

</script>
<template>

</template>

