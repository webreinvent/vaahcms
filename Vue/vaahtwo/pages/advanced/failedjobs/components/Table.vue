<script setup>
import { vaah } from '../../../../vaahvue/pinia/vaah'
import { useFailedJobStore } from '../../../../stores/store-failedjobs'

const store = useFailedJobStore();
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

            <Column field="id" header="ID"
                    :style="{width: store.getIdWidth()}"
                    :sortable="true">
            </Column>
             <Column field="queue" header="Queue">

                 <template #body="prop">
                     {{prop.data.queue}}
                 </template>

             </Column>
             <Column field="connection" header="Connection">

                 <template #body="prop">
                     {{prop.data.connection}}
                 </template>

             </Column>
             <Column field="payload" header="Payload">

                 <template #body="prop">
                     <Button class="p-button-tiny p-button-text"
                             v-tooltip.top="'View'"
                             @click="store.viewPayloads(prop.data.payload)"
                             icon="pi pi-eye" />
                 </template>

             </Column>
             <Column field="payload" header="Payload">

                 <template #body="prop">
                     <Button class="p-button-tiny p-button-text"
                             v-tooltip.top="'View'"
                             @click="store.viewPayloads(prop.data.payload)"
                             icon="pi pi-eye" />
                 </template>

             </Column>
             <Column field="failed_at" header="Failed At"
                     v-if="store.isViewLarge()"
                     :sortable="true"
                     style="width:150px;">

                 <template #body="prop">
                     {{prop.data.failed_at}}
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
