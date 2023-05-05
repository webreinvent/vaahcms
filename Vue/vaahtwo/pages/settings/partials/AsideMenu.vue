<template>

<b-menu class="is-light">
    <b-menu-list label="Settings">
        <b-menu-item label="General"
                     icon="tools"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/general')"
                     :to="{name: 'general.index'}">
        </b-menu-item>
        <b-menu-item label="User Settings"
                     icon="users-cog"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/user-settings')"
                     :to="{name: 'user-setting.index'}">
        </b-menu-item>
        <b-menu-item label="Env Variables"
                     icon="code"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/env-variables')"
                     :to="{name: 'env.index'}">
        </b-menu-item>

        <b-menu-item label="Localizations"
                     icon="language"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/localization')"
                     :to="{name: 'localization.index'}">
        </b-menu-item>

        <b-menu-item label="Notifications"
                     icon="bell"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/notifications')"
                     :to="{name: 'notifications.index'}">
        </b-menu-item>

        <b-menu-item label="Update"
                     icon="download"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/settings/update')"
                     :to="{name: 'update.index'}">
        </b-menu-item>

        <b-menu-item label="Reset"
                     icon="retweet"
                     tag="router-link"
                     :to="{name: 'setup.index'}">
        </b-menu-item>

        <!--<b-menu-item label="Scheduled Actions"
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
        </b-menu-item>-->
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
