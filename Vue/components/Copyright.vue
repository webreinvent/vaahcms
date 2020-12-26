<template>
    <div>

        <p v-if="assets">
            &copy; {{root.assets.server.current_year}}.
            <a :href="assets.vaahcms.website" target="_blank">{{root.assets.vaahcms.name}}</a>
            v{{root.assets.vaahcms.version}}
            | <a :href="assets.vaahcms.docs" target="_blank">Documentation</a>
        </p>
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
