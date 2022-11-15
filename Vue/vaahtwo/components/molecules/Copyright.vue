<script setup>
import {useRootStore} from "../../stores/root";

const root = useRootStore();
</script>

<template>
    <div v-if="root.assets" class="text-xs text-center">

        <p v-if="root.assets.server">
            &copy; {{root.assets.server.current_year}}.
            <a :href="root.assets.vaahcms.website"
               class="text-blue-400"
               target="_blank" >
                {{root.assets.vaahcms.name}}
            </a>
            v{{root.assets.versions.vaahcms_version}}
            | <a :href="root.assets.vaahcms.docs" class="text-blue-400" target="_blank">Documentation</a>
        </p>

        <p v-if="root.assets.versions">
            Laravel v{{root.assets.versions.laravel_version}}
            | PHP v{{root.assets.versions.php_version}}
        </p>
    </div>
</template>

