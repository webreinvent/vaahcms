<template>
        <img v-if="assets"
             :style="{ height: height+ 'px' }"
             :src="assets.urls.image+'/vaahcms-logo.svg'">
</template>
<script>

    export default {
        props:['assets', 'width', 'height'],
        computed:{
        },
    }

</script>

