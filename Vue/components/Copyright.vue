<template>
    <div>

        <p v-if="assets">
            &copy; {{root.assets.server.current_year}}.



            <a :href="assets.vaahcms.app_url" target="_blank">{{root.assets.vaahcms.app_name}}</a>
            <span v-if="assets.vaahcms.app_version">v{{root.assets.vaahcms.app_version}}</span>

            | <a :href="assets.vaahcms.website" target="_blank">{{root.assets.vaahcms.cms}}</a> v{{root.assets.vaahcms.cms_version}}
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
