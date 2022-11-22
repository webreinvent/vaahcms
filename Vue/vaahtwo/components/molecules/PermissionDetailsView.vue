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
        <DataTable :value="store.permission" v-if="store && store.permission" responsiveLayout="scroll">
            <Column field="created_at" header="Created At">
                <template #body="prop">
                    {{ prop.data.created_at }}
                </template>
            </Column>
            <Column field="updated_at" header="Updated At">
                <template #body="prop">
                    {{ prop.data.updated_at }}
                </template>
            </Column>
        </DataTable>

    </div>
</template>
