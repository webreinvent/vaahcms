<template>
    <div v-if="assets">
        <img style="max-height: 40px;" :src="assets.urls.image+'/vaahcms-logo.svg'">
    </div>
</template>
<script>

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
    }

</script>

