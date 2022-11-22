<script setup>
import { h, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useDialog } from 'primevue/usedialog';

import { useRoleStore } from '../../stores/store-roles'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import PermissionDetailsView from '../../components/molecules/PermissionDetailsView.vue';
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

//--------toggle item menu--------//
const item_menu_state = ref();

const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------toggle item menu--------//

//--------toggle dynamic modal--------//
const dialog = useDialog();

const openViewModal = () => {
    const dialogRef = dialog.open(PermissionDetailsView, {
        props: {
            header: 'Details',
            style: {
                width: '50vw',
            },
            breakpoints:{
                '960px': '75vw',
                '640px': '90vw'
            },
            modal: true
        }
    });
}

//--------toggle dynamic modal--------//

</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{ store.item.name }}
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

            <DataTable v-if="store && store.permission"
                       :value="store.permission"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >

                    <template #body="prop">
                        {{ prop.data.name }}
                    </template>
                </Column>

                <Column field="has-role"
                        header="Has Role"
                >

                    <template #body="prop">
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                        />
                    </template>
                </Column>

                <Column field="is-active"
                        header="Permission Status"
                >

                    <template #body="prop">
                        <Button label="Yes"
                                class="p-button-sm p-button-rounded p-button-success"
                                v-if="prop.data.is_active === 1"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                        />
                    </template>
                </Column>

                <Column>
                    <template #body="prop">
                        <Button class="p-button-sm p-button-rounded p-button-outlined"
                                @click="openViewModal"
                                icon="pi pi-eye"
                                label="View"
                        />
                    </template>
                </Column>
            </DataTable>
        </Panel>

        <DynamicDialog  />
    </div>
</template>
