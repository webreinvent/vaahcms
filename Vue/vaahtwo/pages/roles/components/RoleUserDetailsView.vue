<script setup>
import { useRoleStore } from "../../../stores/store-roles";
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
        <div v-if="store && store.active_role_user">
            <p>Created By : <span> {{ store.active_role_user.json.created_by }}</span></p>
           <Divider class="is-small"/>
            <p>Updated By : <span> {{ store.active_role_user.json.updated_by }}</span></p>
           <Divider class="is-small"/>
            <p>Created At : <span> {{ store.active_role_user.json.created_at }}</span></p>
           <Divider class="is-small"/>
            <p>Updated At : <span> {{ store.active_role_user.json.updated_at }}</span></p>
        </div>

    </div>
</template>
