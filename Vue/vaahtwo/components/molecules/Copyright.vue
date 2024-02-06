<script setup>
import {useRootStore} from "../../stores/root";

const root = useRootStore();
</script>

<template>
    <div v-if="root.assets" class="text-xs text-center">

        <p v-if="root.assets.server">
            &copy; {{root.assets.server.current_year}}.
            {{root.assets.vaahcms.name}}
            v{{root.assets.versions.vaahcms_version}}
        </p>

        <p v-if="root.assets.versions">
            Laravel v{{root.assets.versions.laravel_version}}
            | PHP v{{root.assets.versions.php_version}}
        </p>
    </div>
</template>

