<script setup>
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

import { useRoleStore } from '../../stores/store-roles'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useRoleStore();
const route = useRoute();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if(!store.item)
    {
        await store.getItem(route.params.id);
    }
});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="p-panel-title">
                        #{{ store.item.id }}  {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <!--/item_menu-->
                    <Button
                        type="button"
                        @click="toggleItemMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.menu_items"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <DataTable :value="store.item"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >

                    <template #body="prop">
                        {{ store.item.name }}
                    </template>
                </Column>
            </DataTable>
        </Panel>
    </div>
</template>
