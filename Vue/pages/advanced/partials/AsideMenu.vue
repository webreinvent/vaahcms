<template>

<b-menu class="is-light">
    <b-menu-list label="Advanced">
        <b-menu-item label="Logs"
                     icon="clipboard-list"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/logs')"
                     :to="{name: 'logs.index'}">
        </b-menu-item>
        <b-menu-item label="Jobs"
                     icon="hourglass-half"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/jobs')"
                     :to="{name: 'jobs.list'}">
        </b-menu-item>

        <b-menu-item label="Failed Jobs"
                     icon="times-circle"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/failed-jobs')"
                     :to="{name: 'jobs.failed.index'}">
        </b-menu-item>

        <b-menu-item label="Batches"
                     icon="layer-group"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/batches')"
                     :to="{name: 'batches.list'}">
        </b-menu-item>

    </b-menu-list>
</b-menu>

</template>

<script>
    export default {
        name: "AsideMenu",
    }
</script>

<style scoped>

</style>
