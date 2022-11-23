<script setup>
import { useRoleStore } from "../../stores/store-roles";
import { onMounted } from "vue";

const store = useRoleStore();

onMounted(async () => {
    /**
     * Fetch the record from the database
     */
    if(!store.item)
    {
        await store.getItem(route.params.id);
    }
});
</script>
<template>
    <div>
        <div v-if="store && store.active_permission">
            <p class="text-sm">Created By : <span> {{ store.active_permission.json.created_by }}</span></p>
            <Divider />
            <p class="text-sm">Updated By : <span> {{ store.active_permission.json.updated_by }}</span></p>
            <Divider />
            <p class="text-sm">Created At : <span> {{ store.active_permission.json.created_at }}</span></p>
            <Divider />
            <p class="text-sm">Updated At : <span> {{ store.active_permission.json.updated_at }}</span></p>
        </div>

    </div>
</template>
