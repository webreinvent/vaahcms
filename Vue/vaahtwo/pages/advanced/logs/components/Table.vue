<script setup>
import {vaah} from '../../../../vaahvue/pinia/vaah'
import {useLogStore} from '../../../../stores/advanced/store-logs'
import {useRoute} from 'vue-router';

const store = useLogStore();
const useVaah = vaah();
const route = useRoute();


</script>

<template>

    <div v-if="store.list">
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

                        <Button v-if="store.hasPermission('can-read-log')"
                                class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                :disabled="route.params.name === prop.data.name"
                                @click="store.toView(prop.data)"
                                data-testid="logs-item_view"
                                icon="pi pi-eye"
                        ></Button>

                        <Button v-if="store.hasPermission('can-delete-log')"
                                class="p-button-tiny p-button-danger p-button-text"
                                @click="store.confirmDelete(prop.data)"
                                v-tooltip.top="'Delete'"
                                data-testid="logs-item_trash"
                                icon="pi pi-trash" >
                        </Button>
                    </div>

                </template>


            </Column>


        </DataTable>
        <!--/table-->

        <Divider/>

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list_total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page" />
        <!--/paginator-->

    </div>
    <Dialog header="Payload"
            v-model:visible="store.payload_modal"
            :style="{width: '40%'}"
    >

        <Card class="w-max">
            <template #content>
                <span v-html="store.payload_content"></span>
            </template>
        </Card>

    </Dialog>

</template>
