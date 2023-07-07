<script setup>
import { usePermissionStore } from "../../../stores/store-permissions";

const store = usePermissionStore();
</script>

<template>
    <div>
        <div v-if="store && store.active_permission_role">
            <p>Created By : <span> {{ store.active_permission_role.json.created_by }}</span></p>
            <Divider class="is-small"/>
            <p>Updated By : <span> {{ store.active_permission_role.json.updated_by }}</span></p>
            <Divider class="is-small"/>
            <p>Created At : <span> {{ store.active_permission_role.json.created_at }}</span></p>
            <Divider class="is-small"/>
            <p>Updated At : <span> {{ store.active_permission_role.json.updated_at }}</span></p>
        </div>
    </div>
</template>

