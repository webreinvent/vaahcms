<template>
        <img v-if="assets"
             :style="{ height: height+ 'px' }"
             :src="assets.backend_logo_url">
</template>
<script>

    export default {
        props:['assets', 'width', 'height'],
        computed:{
        },
    }

</script>

