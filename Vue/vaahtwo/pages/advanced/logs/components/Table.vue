<script setup>
import {vaah} from '../../../../vaahvue/pinia/vaah'
import {useLogStore} from '../../../../stores/store-logs'
const store = useLogStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        {{ store.list.data }}
        <!--table-->
        <DataTable :value="store.list"
                   dataKey="id"
                   class="p-datatable-sm"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name" header="Name"></Column>

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
