<script setup>
import {vaah} from '../../../../vaahvue/pinia/vaah'
import {useLogStore} from '../../../../stores/advanced/store-logs'
import {useRoute} from 'vue-router';
import { useRootStore } from "../../../../stores/root";
const root = useRootStore();
const store = useLogStore();
const useVaah = vaah();
const route = useRoute();


</script>

<template>

    <div v-if="store.list && store.assets">
        <!--table-->
        <DataTable size="small" rowHover :value="store.list" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name" header="Name">
                <template #body="prop">
                    {{ prop.data.name }}
                    <Badge size="small" v-if="prop.data.size"
                           :value="prop.data.size"
                    />
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()">

                <template #body="prop">
                    <InputGroup>

                        <Button aria-label="View log" v-if="store.hasPermission('can-read-log')"
                                class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                :disabled="route.params.name === prop.data.name ||
                                 prop.data.name.substring(prop.data.name.lastIndexOf('.') + 1) !== 'log'"
                                @click="store.toView(prop.data)"
                                data-testid="logs-item_view"
                                icon="pi pi-eye"
                        ></Button>

                        <Button size="small" v-if="store.hasPermission('can-read-log')" icon="pi pi-download" aria-label="Download file" @click="store.downloadFile(prop.data)" data-testid="logs-list_download_file" class=" p-button-rounded p-button-text" v-tooltip.top=" 'Download File' " />

                        <Button aria-label="Delete log" v-if="store.hasPermission('can-delete-log')"
                                class="p-button-tiny p-button-danger p-button-text"
                                @click="store.confirmDelete(prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.view_delete"
                                data-testid="logs-item_trash"
                                icon="pi pi-trash" >
                        </Button>
                    </InputGroup>

                </template>


            </Column>

            <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                 #empty slot is absent, so the slot says what to do next
                 (DESIGN-SYSTEM §8): a muted line + one primary action.
                 Logs are written by the application, not by the admin — the
                 CTA clears the active search. -->
            <template #empty>
                <div class="vaah-empty" data-testid="logs-list_empty">
                    <i class="vaah-empty-icon pi pi-book" aria-hidden="true"></i>
                    <p class="vaah-empty-copy">No log entries match your search.</p>
                    <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="logs-list_empty_reset" />
                </div>
            </template>

        </DataTable>
        <!--/table-->

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list_total"
                   template="PrevPageLink PageLinks NextPageLink RowsPerPageDropdown"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        />
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
