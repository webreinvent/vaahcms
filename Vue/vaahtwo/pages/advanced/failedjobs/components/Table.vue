<script setup>
import { vaah } from '../../../../vaahvue/pinia/vaah'
import { useFailedJobStore } from '../../../../stores/advanced/store-failedjobs'
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useFailedJobStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list && store.assets">
        <!--table-->
        <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id" header="ID"
                    :style="{width: store.getIdWidth()}"
                    :sortable="true"
            />

            <Column field="queue" header="Queue">
                <template #body="prop">
                    {{ prop.data.queue }}
                </template>
            </Column>

            <Column field="connection" header="Connection">
                <template #body="prop">
                    {{ prop.data.connection }}
                </template>
            </Column>

            <Column field="payload" header="Payload">
                <template #body="prop">
                    <Button aria-label="View payload" v-if="store.hasPermission('can-read-payload-failed-jobs')"
                            class="p-button-tiny p-button-text"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                            data-testid="failedjobs-view_payload"
                            @click="store.viewFailedJobsContent(prop.data.payload,'Payload')"
                            icon="pi pi-eye"
                    />
                </template>
            </Column>

            <Column field="exception" header="Exception">
                <template #body="prop">
                    <Button aria-label="View exception" v-if="store.hasPermission('can-read-failed-jobs-exception')"
                            class="p-button-tiny p-button-text"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                            data-testid="failedjobs-view_exception"
                            @click="store.viewFailedJobsContent(prop.data.exception,'Exception')"
                            icon="pi pi-eye"
                    />
                </template>
            </Column>

            <Column field="failed_at" header="Failed At"
                    v-if="store.isViewLarge()"
                    :sortable="true"
                    style="width:150px;"
            >
                <template #body="prop">
                    {{ prop.data.failed_at }}
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <InputGroup>
                        <Button aria-label="Delete failed job" v-if="store.isViewLarge() && !prop.data.deleted_at && store.hasPermission('can-delete-failed-jobs')"
                                class="p-button-tiny p-button-danger p-button-text"
                                @click="store.itemAction('delete', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.view_delete"
                                icon="pi pi-trash"
                                data-testid="failedjobs-trash"
                        />
                    </InputGroup>
                </template>
            </Column>
            <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                 #empty slot is absent, so the slot says what to do next
                 (DESIGN-SYSTEM §8): a muted line + one primary action.
                 An empty failed-jobs queue is the healthy state — the copy
                 says so rather than painting a zero as a failure. -->
            <template #empty>
                <div class="vaah-empty" data-testid="failedjobs-list_empty">
                    <i class="vaah-empty-icon pi pi-check-circle" aria-hidden="true"></i>
                    <p class="vaah-empty-copy">No failed jobs — nothing needs attention.</p>
                    <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="failedjobs-list_empty_reset" v-if="store.query.filter.q || store.count_filters > 0" />
                </div>
            </template>
        </DataTable>
        <!--/table-->

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        >
        </Paginator>
        <!--/paginator-->
    </div>

    <Dialog :header="store.failed_job_content_heading"
            v-model:visible="store.failed_job_modal"
            :style="{width: '40%'}"
    >
        <Card class="w-max">
            <template #content>
                <span v-html="store.failed_job_content"></span>
            </template>
        </Card>
    </Dialog>
</template>
