<template>
    <div>
        <p>
            &copy; VaahCMS
        </p>
    </div>
</template>

<script>
    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
        },
    }
</script>
