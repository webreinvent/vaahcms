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

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}"></Column>

            <Column field="name" header="" style="width: 30%;">
                <template #body="prop">
                    <span v-if="prop.data.pending_jobs > 0">
                        <ProgressBar :value="store.getJobProgress(prop.data,1)" />
                        <ProgressBar :value="store.getJobProgress(prop.data,2)" />
                        <ProgressBar :value="store.getJobProgress(prop.data,3)" />
                    </span>
                    <span v-else>
                        <ProgressBar :value="0" style="height:10px;" />
                    </span>
                </template>
            </Column>

             <Column field="actions" style="width:150px;"
                     :style="{width: store.getActionWidth() }"
                     header="Detail">
                 <template #body="prop">
                     <div class="p-inputgroup">
                         <Button class="p-button-sm p-button-outlined p-button-rounded"
                                 data-testid="batches-table-options"
                                 @click="store.displayBatchDetails(prop.data.options)">
                             <span class="pi pi-eye mr-1"></span>
                             <span>View</span>
                         </Button>
                     </div>
                 </template>
             </Column>

             <Column field="failed_job_ids" header="Failed Job Ids"
                     v-if="store.isViewLarge()"
                     style="width:150px;">

                 <template #body="prop">
                     <div class="p-inputgroup">
                         <Button class="p-button-sm p-button-outlined p-button-rounded"
                                 data-testid="batches-table-failed-ids"
                                 @click="store.displayFailedIdDetails(prop.data.failed_job_ids)">
                             <span class="pi pi-eye mr-1"></span>
                             <span>{{ prop.data.failed_job_ids.length }}</span>
                         </Button>
                     </div>
                 </template>

             </Column>

             <Column field="cancelled_at" header="Cancelled At"
                     v-if="store.isViewLarge()"
                     style="width:150px;">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.cancelled_at)}}
                 </template>
             </Column>

             <Column field="created_at" header="Created At"
                     v-if="store.isViewLarge()"
                     style="width:150px;">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.created_at)}}
                 </template>

             </Column>
             <Column field="finished_at" header="Finished At"
                     v-if="store.isViewLarge()"
                     style="width:150px;">

                 <template #body="prop">
                     {{useVaah.ago(prop.data.finished_at)}}
                 </template>
             </Column>

             <Column v-if="store.isViewLarge()"
                     style="width:150px;">

                 <template #body="prop">
                     <Button class="p-button-rounded p-button-text"
                             @click="store.deleteItem(prop.data)"
                             data-testid="batches-table-to-trash"
                     >
                         <span class="pi pi-trash"></span>
                     </Button>
                 </template>
             </Column>
        </DataTable>
        <!--/table-->

        <Divider />
        <Dialog header="Options"
                v-model:visible="store.displayDetail"
                data-testid="batch-table-detail-dialog"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}"
        >
                <Card class="w-max">
                    <template #content>
                        <span v-html="store.dialogContent"></span>
                    </template>
                </Card>
        </Dialog>
        <Dialog header="Failed Ids"
                v-model:visible="store.displayFailedIds"
                data-testid="batch-table-detail-dialog"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}"
        >
                <Card class="w-max">
                    <template #content>
                        <span v-html="store.dialogContent"></span>
                    </template>
                </Card>
        </Dialog>
        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->
    </div>

</template>
