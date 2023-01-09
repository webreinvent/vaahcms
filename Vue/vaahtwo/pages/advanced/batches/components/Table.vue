<script setup>
import { vaah } from '../../../../vaahvue/pinia/vaah'
import { useBatchStore } from '../../../../stores/store-batches'

const store = useBatchStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list.data"
                       dataKey="id"
                   class="p-datatable-sm"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em">
            </Column>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name" header="Name" :sortable="true">

                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{prop.data.name}}
                </template>
            </Column>

             <Column field="actions" style="width:150px;"
                     :style="{width: store.getActionWidth() }"
                     header="Detail">
                 <template #body="prop">
                     <div class="p-inputgroup ">
                         <Button class="p-button-outlined"
                                 data-testid="batches-table-to-view"
                                 @click="store.toView(prop.data)"
                                 >
                             <span class="pi pi-eye"></span>
                             <span>View</span>
                         </Button>
                     </div>
                 </template>
             </Column>

             <Column field="failed_job_ids" header="Failed Job Ids"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.failed_job_ids)}}
                 </template>

             </Column>

             <Column field="cancelled_at" header="Cancelled At"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.cancelled_at)}}
                 </template>
             </Column>

             <Column field="created_at" header="Created At"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.created_at)}}
                 </template>

             </Column>
             <Column field="finished_at" header="Finished At"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.finished_at)}}
                 </template>
             </Column>

             <Column  header="Delete"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">

                 <template #body="prop">
                     <Button class="p-button-rounded p-button-text"
                             data-testid="batches-table-to-trash"
                     >
                         <span class="pi pi-trash"></span>
                     </Button>
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
