<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useTaxonomyStore } from '../../../stores/store-taxonomies'
import { useDialog } from "primevue/usedialog";
import TaxonomyTypeModal from "../components/TaxonomyTypeModal.vue"
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
const store = useTaxonomyStore();
const useVaah = vaah();


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openTaxonomyTypeModal = () => {
    const dialogRef = dialog.open(TaxonomyTypeModal, {
        props: {
            header: store.assets.language_strings.taxonomy_type_manage_type_dialogue,
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
    <div v-if="store.list && store.assets">
        <!--table-->
         <DataTable :value="store.list.data"
                    dataKey="id"
                    class="p-datatable-sm p-datatable-hoverable-rows"
                    v-model:selection="store.action.items"
                    stripedRows
                    responsiveLayout="scroll"
         >
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id"
                    header="ID"
                    :style="{ width: store.getIdWidth() }"
                    :sortable="true"
            />
             <Column field="name" header="Name"
                     :sortable="true"
             >
                 <template #body="prop">
                     <Badge v-if="prop.data.deleted_at"
                            value="Trashed"
                            severity="danger"
                     />
                     {{ prop.data.name }}
                 </template>
             </Column>



            <Column field="slug" header="Slug"
                    :sortable="false"
            >
                <template #body="prop">
                    <div class="flex align-items-center">
                        <Button class="p-button-tiny p-button-text p-0 mr-2"
                                data-testid="taxonomies-table-to-edit"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                                @click="useVaah.copy(prop.data.slug)"
                                icon="pi pi-copy"
                        />
                        <p v-if="prop.data.slug">{{ prop.data.slug }}</p>
                    </div>
                </template>
            </Column>
             <Column field="type" header="Type"
                     :sortable="false"
                     class="flex align-items-center justify-content-between"
             >
                 <template #body="prop">
                     <p v-if="prop.data.type"> {{ prop.data.type.name }} </p>

                     <template v-if="store.hasPermission('can-manage-taxonomy-types')">
                         <Button class="p-button-tiny p-button-text"
                                 data-testid="taxonomies-table-to-manage-taxonomy-type-modal"
                                 v-tooltip.top="store.assets.language_strings.toolkit_text_view_type"
                                 icon="pi pi-pencil"
                                 @click="openTaxonomyTypeModal"
                         />
                     </template>
                 </template>
             </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    {{ useVaah.ago(prop.data.updated_at) }}
                </template>
            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="false"
                    style="width:100px;"
                    header="Is Active"
            >
                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 data-testid="taxonomies-table-is-active"
                                 v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
                    v-if="root.assets
                          && root.assets.language_strings
                          && root.assets.language_strings.crud_actions"
            >
                <template #body="prop">
                    <div class="p-inputgroup">

                        <Button class="p-button-tiny p-button-text"
                                data-testid="taxonomies-table-to-view"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                v-if="store.hasPermission('can-read-taxonomies')"
                                icon="pi pi-eye"
                        />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="taxonomies-table-to-edit"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                v-if="store.hasPermission('can-update-taxonomies')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="taxonomies-table-action-trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-delete-taxonomies')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="taxonomies-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <!--/table-->


        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        />
        <!--/paginator-->

        <DynamicDialog  />
    </div>
</template>

<style lang="scss">
.p-inputswitch {
    &.p-inputswitch-checked {
        .p-inputswitch-slider {
            background: #22c55e !important;
            border: #22c55e !important;
        }
    }
}

.p-inputswitch-checked {
    .p-inputswitch-slider:hover {
        background: #2d8631 !important;
        border: #2d8631 !important;
    }
}
</style>
