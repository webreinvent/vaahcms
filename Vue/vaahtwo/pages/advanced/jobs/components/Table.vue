<script setup>
import {vaah} from '../../../../vaahvue/pinia/vaah'
import {useJobStore} from '../../../../stores/store-jobs'
const store = useJobStore();
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

            <Column field="queue" header="Queue">

                <template #body="prop">
                    {{prop.data.queue}}
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

            <Column field="attempts" header="Attempts">

                <template #body="prop">
                    {{prop.data.attempts}}
                </template>

            </Column>

            <Column field="reserved_at" header="Reserved At"
                    v-if="store.isViewLarge()"
                    style="width:150px;">

                <template #body="prop">
                    <Badge v-if="prop.data.reserved_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{prop.data.reserved_at}}
                </template>

            </Column>


            <Column field="available_at" header="Available At"
                    v-if="store.isViewLarge()"
                    style="width:150px;">

                <template #body="prop">
                    {{useVaah.ago(prop.data.available_at)}}
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
            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()">

                <template #body="prop">
                    <div class="p-inputgroup ">
                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('delete', prop.data)"
                                v-tooltip.top="'Delete'"
                                icon="pi pi-trash" />
                    </div>

                </template>


            </Column>


        </DataTable>
        <!--/table-->

        <Divider/>

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->

    </div>
    <Dialog header="Payload"
            v-model:visible="store.payloadModal"
            :style="{width: '40%'}"
    >

        <Card class="w-max">
            <template #content>
                <span v-html="store.payloadContent"></span>
            </template>
        </Card>


    </Dialog>

</template>
