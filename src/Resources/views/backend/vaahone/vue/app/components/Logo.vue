<template>
        <img v-if="assets"
             :style="{ height: height+ 'px' }"
             :src="assets.urls.image+'/vaahcms-logo.svg'">
</template>
<script>

    export default {
        props:['width', 'height'],
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
    }

</script>

