<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useModuleStore } from '../../../stores/store-modules'

const store = useModuleStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list"
                   dataKey="id"
                   class="p-datatable-sm"
                   checkable="store.hasPermission('can-update-module') ? true : false"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll"
                    data-testid="modules-table-action-select">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em">
            </Column>

             <Column field="name" header="Module">
                 <template #body="prop">
                     <h3 class="title is-5 has-margin-bottom-10">{{ prop.data.name }} <Tag v-if="prop.data.is_default" value="Default" severity="success" class="ml-2" rounded></Tag></h3>
                     <div>{{ prop.data.excerpt }}</div>
                     <Tag class="mb-2 mt-2 bg-black-alpha-90 border-noround">Name:</Tag>
                     <Tag class="mt-2 border-noround" v-if="prop.data.name"> {{ prop.data.name }}</Tag>
                     <Tag class="ml-2 mb-2 mt-2 bg-black-alpha-90 border-noround">Version:</Tag>
                     <Tag class="mt-2 border-noround" v-if="prop.data.version">{{ prop.data.version }}</Tag>
                     <Tag class="ml-2 mb-2 mt-2 bg-black-alpha-90 border-noround">Developed by:</Tag>
                     <Tag class="mb-2 mt-2 border-noround" v-if="prop.data.author_name">{{ prop.data.author_name }}</Tag>
                 </template>
             </Column>

             <Column>
                 <template #body="prop">
                     <span class="p-buttonset template flex justify-content-end">
                         <Button v-if="prop.data.is_active && store.hasPermission('can-deactivate-module')"
                                 data-testid="modules-table-action-deactivate"
                                 class="p-button-sm bg-yellow-300 text-900"
                                 v-tooltip.top="'Deactivate Module'"
                                 @click="store.toggleIsActive(prop.data)">
                             Deactivate
                         </Button>

                         <Button v-if="!prop.data.is_active && store.hasPermission('can-activate-module')"
                                 data-testid="modules-table-action-activate"
                                 class="p-button-sm bg-green-400"
                                 v-tooltip.top="'Activate Module'"
                                 @click="store.toggleIsActive(prop.data)">
                             Activate
                         </Button>
                         <Button v-if="prop.data.is_active && store.hasPermission('can-import-sample-data-in-module')"
                                 data-testid="modules-table-action-sample-data"
                                 size="is-small"
                                 class="p-button-sm bg-yellow-300"
                                 icon="pi pi-database"
                                 v-tooltip.top="'Import Data'"
                                 @click="store.itemAction('import_sample_data', prop.data)">
                         </Button>

                        <Button class="p-button-info p-button-sm"
                                  data-testid="modules-table-action-install-update"
                                  icon="cloud-download-alt"
                                  @click="store.confirmUpdate(prop.data)"
                                  v-tooltip.top="'Update Module'"
                                  v-if="prop.data.is_update_available && store.hasPermission('can-update-module')">
                            Update
                        </Button>

                         <Button class="p-button-danger p-button-sm"
                                 data-testid="modules-table-action-trash"
                                 v-if="!prop.data.deleted_at && store.hasPermission('can-delete-module')"
                                 @click="store.confirmDeleteItem(prop.data)"
                                 v-tooltip.top="'Trash'"
                                 icon="pi pi-trash" />

                         <Button class="p-button-outlined p-button-sm"
                                 v-if="store.hasPermission('can-read-module')"
                                 data-testid="modules-table-action-view"
                                 v-tooltip.top="'View'"
                                 @click="store.toView(prop.data)"
                                 icon="pi pi-eye" />
                    </span>
                 </template>

                 <template #empty>
                     No customers found.
                 </template>
             </Column>
        </DataTable>
        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->

    </div>

</template>
