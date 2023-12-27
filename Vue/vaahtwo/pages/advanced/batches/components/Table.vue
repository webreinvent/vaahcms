<script setup>
import { vaah } from '../../../../vaahvue/pinia/vaah'
import { useBatchStore } from '../../../../stores/advanced/store-batches'

const store = useBatchStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list">
        <!--table-->

         <DataTable :value="store.list.data"
                    dataKey="id"
                    class="p-datatable-sm p-datatable-hoverable-rows"
                    v-model:selection="store.action.items"
                    data-testid="batches-table-checkbox"
                    stripedRows
                    responsiveLayout="scroll"
         >
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true" />

            <Column field="name" header="" style="width: 30%;">
                <template #body="prop">
                    <span >

                           <div role="progressbar"
                                class="p-progressbar p-component p-progressbar-determinate batch-progress-bar">
                            fsdfsdfsfsf
                            <div v-tooltip.top="{
                                    value: 'Passed'
                                }"
                                 class="p-progressbar-value p-progressbar-value-animate progress-bar-success"
                                 :style="'width: '+ store.getJobProgress(prop.data,1)+'%;'"
                            >
                                <div class="p-progressbar-label"
                                     data-pc-section="label">
                                    {{store.getJobProgress(prop.data,1,2)}}%
                                </div>
                            </div>
                            <div v-tooltip.top="{
                                    value: 'Failed'
                                }"
                                 class="p-progressbar-value p-progressbar-value-animate progress-bar-danger"
                                 :style="'width: '+ store.getJobProgress(prop.data,2)+'%; left: '
                                 + store.getJobProgress(prop.data,1)+'%;'"
                            >
                                <div class="p-progressbar-label" data-pc-section="label">
                                    {{store.getJobProgress(prop.data,2,2)}}%
                                </div>
                            </div>
                            <div v-tooltip.top="{
                                    value: 'Pending'
                                }"
                                 class="p-progressbar-value p-progressbar-value-animate progress-bar-warning"
                                 :style="'width: '+ store.getJobProgress(prop.data,3)+'%; left: '
                                 + (store.getJobProgress(prop.data,1)+store.getJobProgress(prop.data,2))+'%;'"
                            >
                                <div class="p-progressbar-label" data-pc-section="label">
                                    {{store.getJobProgress(prop.data,3,2)}}%
                                </div>
                            </div>
                        </div>
                    </span>

                </template>
            </Column>

             <Column field="actions" style="width:150px;"
                     :style="{width: store.getActionWidth() }"
                     header="Detail"
             >
                 <template #body="prop">
                     <Button v-if="store.hasPermission('can-read-batch-details')"
                             class="p-button-rounded p-button-sm p-button-outlined"
                             data-testid="batches-table-options"
                             @click="store.displayBatchDetails(prop.data.options)"
                     >
                         <span class="pi pi-eye mr-1"></span>
                         <span>View</span>
                     </Button>
                 </template>
             </Column>

             <Column field="failed_job_ids" header="Failed Job Ids"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
             >
                 <template #body="prop">
                     <Button v-if="store.hasPermission('can-read-batch-failed-ids')"
                             class="p-button-sm p-button-outlined p-button-rounded"
                             data-testid="batches-table-failed-ids"
                             @click="store.displayFailedIdDetails(prop.data.failed_job_ids)"
                     >
                         <span class="pi pi-eye mr-1"></span>
                         <span v-if="prop.data.failed_job_ids &&
                          (typeof prop.data.failed_job_ids === 'array' ||
                          typeof prop.data.failed_job_ids === 'object' )">
                             {{ prop.data.failed_job_ids.length }}
                         </span>
                         <span v-else>
                             0
                         </span>
                     </Button>
                 </template>
             </Column>

             <Column field="cancelled_at" header="Cancelled At"
                     v-if="store.isViewLarge()"
                     :sortable="true"
                     style="width:150px;"
             >
                 <template #body="prop">
                     {{ useVaah.ago(prop.data.cancelled_at) }}
                 </template>
             </Column>

             <Column field="created_at"
                     header="Created At"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true"
             >
                 <template #body="prop">
                     {{ useVaah.ago(prop.data.created_at) }}
                 </template>
             </Column>

             <Column field="finished_at" header="Finished At"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true"
             >
                 <template #body="prop">
                     {{ useVaah.ago(prop.data.finished_at) }}
                 </template>
             </Column>

             <Column v-if="store.isViewLarge()"
                     style="width:150px;"
             >
                 <template #body="prop">
                     <Button v-if="store.hasPermission('can-delete-batch')"
                             class="p-button-rounded p-button-text"
                             @click="store.deleteItem(prop.data)"
                             data-testid="batches-table-to-trash"
                     >
                         <span class="pi pi-trash"></span>
                     </Button>
                 </template>
             </Column>
        </DataTable>
        <!--/table-->

        <Dialog header="Options"
                v-model:visible="store.display_detail"
                data-testid="batch-table-detail_dialog"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}"
        >
                <Card class="w-max">
                    <template #content>
                        <span v-html="store.dialog_content"></span>
                    </template>
                </Card>
        </Dialog>

        <Dialog header="Failed Ids"
                v-model:visible="store.display_failed_ids"
                data-testid="batch-table-failed_ids_dialog"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}"
        >
                <Card class="w-max">
                    <template #content>
                        <span v-html="store.dialog_content"></span>
                    </template>
                </Card>
        </Dialog>

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   data-testid="batch-table-paginator"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        >
        </Paginator>
        <!--/paginator-->
    </div>
</template>
