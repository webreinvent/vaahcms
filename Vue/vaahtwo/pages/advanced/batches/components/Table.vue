<script setup>
import { vaah } from '../../../../vaahvue/pinia/vaah'
import { useBatchStore } from '../../../../stores/advanced/store-batches'
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useBatchStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list && store.assets">
        <!--table-->

         <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" data-testid="batches-table-checkbox" stripedRows scrollable>
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
                            <div v-if="store.getJobProgress(prop.data,1,null,true)" v-tooltip.top="{
                                    value: 'Passed ('+store.getJobProgress(prop.data,1,null,true)+')'
                                }"
                                 class="p-progressbar-value p-progressbar-value-animate progress-bar-success"
                                 :style="'width: '+ store.getJobProgress(prop.data,1)+'%;'"
                            >
                                <div class="p-progressbar-label"
                                     data-pc-section="label">
                                    {{store.getJobProgress(prop.data,1,2)}}%
                                </div>
                            </div>
                            <div v-if="store.getJobProgress(prop.data,2,null,true)" v-tooltip.top="{
                                    value: 'Failed ('+store.getJobProgress(prop.data,2,null,true)+')'
                                }"
                                 class="p-progressbar-value p-progressbar-value-animate progress-bar-danger"
                                 :style="'width: '+ store.getJobProgress(prop.data,2)+'%; left: '
                                 + store.getJobProgress(prop.data,1)+'%;'"
                            >
                                <div class="p-progressbar-label" data-pc-section="label">
                                    {{store.getJobProgress(prop.data,2,2)}}%
                                </div>
                            </div>
                            <div v-if="store.getJobProgress(prop.data,3,null,true)" v-tooltip.top="{
                                    value: 'Pending ('+store.getJobProgress(prop.data,3,null,true)+')'
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
                     <Button size="small" v-if="store.hasPermission('can-read-batch-details')" class="p-button-rounded p-button-outlined" data-testid="batches-table-options" @click="store.displayBatchDetails(prop.data.options)">
                         <span class="pi pi-eye mr-1"></span>
                         <span>{{ root.assets.language_strings.crud_actions.toolkit_text_view }}</span>
                     </Button>
                 </template>
             </Column>

             <Column field="failed_job_ids" header="Failed Job Ids"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
             >
                 <template #body="prop">
                     <Button size="small" v-if="store.hasPermission('can-read-batch-failed-ids')" class=" p-button-outlined p-button-rounded" data-testid="batches-table-failed-ids" @click="store.displayFailedIdDetails(prop.data.failed_job_ids)">
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
                     <!-- UT-88 (M6-T4a Batch 17) — a batch that was never
                          cancelled carries `cancelled_at = NULL`; the cell
                          rendered *empty* and the column looked broken
                          rather than empty. -->
                     <span v-if="prop.data.cancelled_at">{{ useVaah.ago(prop.data.cancelled_at) }}</span>
                     <span v-else class="vaah-empty-value">—</span>
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
                     <!-- UT-88 (M6-T4a Batch 17) — a batch that has not
                          finished yet carries `finished_at = NULL`; the
                          cell rendered *empty* and the column looked
                          broken rather than empty. -->
                     <span v-if="prop.data.finished_at">{{ useVaah.ago(prop.data.finished_at) }}</span>
                     <span v-else class="vaah-empty-value">—</span>
                 </template>
             </Column>

             <!-- UT-93 (M6-T4a Batch 18) — the trailing delete column had no
                  header at all and its icon-only button carried no accessible
                  name, so a screen reader announced "button" with nothing
                  else. It now follows the same action-column contract as the
                  other list pages: a named header and a labelled danger
                  button. -->
             <Column v-if="store.isViewLarge()"
                     field="actions"
                     style="width:150px;"
                     :style="{width: store.getActionWidth() }"
                     :header="store.getActionLabel()"
             >
                 <template #body="prop">
                     <Button v-if="store.hasPermission('can-delete-batch')"
                             class="p-button-tiny p-button-danger p-button-text"
                             aria-label="Delete batch"
                             v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                             icon="pi pi-trash"
                             @click="store.deleteItem(prop.data)"
                             data-testid="batches-table-to-trash"
                     />
                 </template>
             </Column>
            <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                 #empty slot is absent, so the slot says what to do next
                 (DESIGN-SYSTEM §8): a muted line + one primary action.
                 Batches are created by the application, not by the admin —
                 the CTA clears the active search. -->
            <template #empty>
                <div class="vaah-empty" data-testid="batches-list_empty">
                    <i class="vaah-empty-icon pi pi-box" aria-hidden="true"></i>
                    <p class="vaah-empty-copy">No batches match your search.</p>
                    <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="batches-list_empty_reset" />
                </div>
            </template>
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
