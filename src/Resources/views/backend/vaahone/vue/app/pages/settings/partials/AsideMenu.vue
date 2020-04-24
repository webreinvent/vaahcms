<template>

<b-menu class="is-light">
    <b-menu-list label="Settings">
        <b-menu-item label="General"
                     icon="cog"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/general')"
                     :to="{name: 'general.index'}">
        </b-menu-item>
        <b-menu-item label="Env Variables"
                     icon="lock"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/env-variables')"
                     :to="{name: 'env.index'}">
        </b-menu-item>
        <b-menu-item label="Notifications"
                     icon="bell"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/general/')"
                     :to="{name: 'general.index'}">
        </b-menu-item>
        <b-menu-item label="Localization"
                     icon="language"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/localization')"
                     :to="{name: 'localization.index'}">
        </b-menu-item>
        <b-menu-item label="Scheduled Actions"
                     icon="stopwatch"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/general/')"
                     :to="{name: 'general.index'}">
        </b-menu-item>
        <b-menu-item label="Backups"
                     icon="hdd"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/backups/')"
                     :to="{name: 'backups.index'}">
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
