<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A layout declares
// none of them, so Vue's attribute inheritance drops the param on the
// layout's root element - as id="1", id="5", ... - and the same param
// reaches the family layout and the page, so one screen carried the same
// id three or four times. A layout takes nothing from the router, so it
// opts out of the inheritance; the page keeps its own (unique) id.
defineOptions({ inheritAttrs: false });
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
