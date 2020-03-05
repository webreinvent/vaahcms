<template>
    <div>

        <p v-if="root.assets">
            &copy; {{root.assets.server.current_year}}.
            {{root.assets.vaahcms.name}}
            v{{root.assets.vaahcms.version}}
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
