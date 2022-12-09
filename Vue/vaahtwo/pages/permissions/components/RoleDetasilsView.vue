<script setup>
import { usePermissionStore } from "../../../stores/store-permissions";

const store = usePermissionStore();
</script>

<template>
    <div>
        <div v-if="store && store.active_permission_role">
            <p class="text-sm">Created By : <span> {{ store.active_permission_role.json.created_by }}</span></p>
            <Divider />
            <p class="text-sm">Updated By : <span> {{ store.active_permission_role.json.updated_by }}</span></p>
            <Divider />
            <p class="text-sm">Created At : <span> {{ store.active_permission_role.json.created_at }}</span></p>
            <Divider />
            <p class="text-sm">Updated At : <span> {{ store.active_permission_role.json.updated_at }}</span></p>
        </div>
    </div>
</template>

