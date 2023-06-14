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
                   class="p-datatable-sm"
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
                    <span v-if="prop.data.total_jobs > 0">

                        <div class="progress mt-1 vh-progress-bar"
                             show-value="true">
                            <div class="progress-bar bg-success"
                                 role="progressbar"
                                 :aria-valuenow="store.getBarValue('success',prop.data)"
                                 aria-valuemin="0" aria-valuemax="100"
                                 :style="'width: '+store.getBarValue('success',prop.data)+'%;'">
                                <span>{{store.getBarValue('success',prop.data)}}% </span>
                            </div>
                            <div class="progress-bar bg-danger"
                                 role="progressbar"
                                 :aria-valuenow="store.getBarValue('danger',prop.data)"
                                 aria-valuemin="0" aria-valuemax="100"
                                 :style="'width: '+store.getBarValue('danger',prop.data)+'%;'">
                                <span>{{store.getBarValue('danger',prop.data)}}% </span>
                            </div>
                            <div class="progress-bar bg-light"
                                 role="progressbar"
                                 :aria-valuenow="store.getBarValue('light',prop.data)"
                                 aria-valuemin="0" aria-valuemax="100"
                                 :style="'width: '+store.getBarValue('light',prop.data)+'%;'">
                                <span class="text-black-alpha-90">
                                    {{store.getBarValue('light',prop.data)}}%
                                </span>
                            </div>
                        </div>

                    </span>
                    <span v-else>
                        <ProgressBar :value="0" style="height:10px;" />
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
                             @click="store.displayBatchDetails(prop.data)"
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
                             :severity="prop.data.failed_job_ids.length > 0?'danger':''"
                             data-testid="batches-table-failed-ids"
                             @click="store.displayFailedIdDetails(prop.data.failed_job_ids)"
                     >
                         <span class="pi pi-eye mr-1"></span>
                         <span>{{ prop.data.failed_job_ids.length }}</span>
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

        <Divider />

        <Dialog header="Options"
                v-model:visible="store.display_detail"
                data-testid="batch-table-detail_dialog"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                :style="{width: '50vw'}"
        >
                <Card class="w-max">
                    <template #content>
                        <table role="table" class="p-datatable-table" style="min-width:50rem;">
                            <tbody class="p-datatable-tbody" role="rowgroup" style=""><!---->
                            <tr class="" tabindex="-1" role="row" draggable="false">
                                <th class="" role="cell">Total Jobs</th>
                                <td class="" role="cell">:</td>
                                <td class="" role="cell">{{store.dialog_item.total_jobs}}</td>
                            </tr><!----><!----><!---->
                            <tr class="" tabindex="-1" role="row">
                                <th class="" role="cell">Pending Jobs</th>
                                <td class="" role="cell">:</td>
                                <td class="" role="cell">{{store.dialog_item.pending_jobs}}</td>
                            </tr><!----><!----><!---->
                            <tr class="" tabindex="-1" role="row">
                                <th class="" role="cell">Failed Jobs</th>
                                <td class="" role="cell">:</td>
                                <td class="" role="cell">{{store.dialog_item.failed_jobs}}</td>
                            </tr><!----><!----><!---->
                            <tr class="" tabindex="-1" role="row">
                                <th class="" role="cell">Options</th>
                                <td class="" role="cell">:</td>
                                <td class="w-5rem" role="cell">
                                    {{JSON.stringify(store.dialog_item.options, null, 2)}}
                                </td>
                            </tr><!----><!----><!---->
                          </tbody>
                        </table>
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
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->
    </div>
</template>

