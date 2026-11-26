<script setup>
import {vaah} from '../../../../vaahvue/pinia/vaah'
import {useJobStore} from '../../../../stores/advanced/store-jobs'
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useJobStore();
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

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true" />

            <Column field="queue" header="Queue">

                <template #body="prop">
                    {{prop.data.queue}}
                </template>
            </Column>

            <Column field="queue" header="Name">

                <template #body="prop">
                    <p v-tooltip.top="prop.data.payload.displayName">
                        {{store.displayJobName(prop.data.payload.displayName)}}
                    </p>
                </template>
            </Column>

            <Column field="payload" header="Payload">
                <template #body="prop">
                    <Button aria-label="View payload" v-if="store.hasPermission('can-read-jobs-payload')"
                            class="p-button-tiny p-button-text"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                            data-testid="jobs-view_payload"
                            @click="store.viewPayloads(prop.data.payload)"
                            icon="pi pi-eye"
                    />
                </template>
            </Column>

            <Column field="attempts" header="Attempts">
                <template #body="prop">
                    {{prop.data.attempts}}
                </template>
            </Column>

            <Column field="reserved_at" header="Reserved At"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
            >
                <template #body="prop">
                    {{prop.data.reserved_at}}
                </template>
            </Column>

            <Column field="available_at" header="Available At"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
            >
                <template #body="prop">
                    <!-- UT-88 (M6-T4a Batch 17) — a job with no scheduled
                         run time carries `available_at = NULL`; the cell
                         rendered *empty* and the column looked broken
                         rather than empty. -->
                    <span v-if="prop.data.available_at">{{useVaah.ago(prop.data.available_at)}}</span>
                    <span v-else class="vaah-empty-value">—</span>
                </template>
            </Column>

            <Column field="created_at" header="Created At"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    {{useVaah.ago(prop.data.created_at)}}
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <InputGroup>
                        <Button aria-label="Delete job" v-if="store.isViewLarge() && !prop.data.deleted_at && store.hasPermission('can-delete-jobs')"
                                class="p-button-tiny p-button-danger p-button-text"
                                @click="store.itemAction('delete', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.view_delete"
                                data-testid="jobs-trash"
                                icon="pi pi-trash"
                        />
                    </InputGroup>
                </template>
            </Column>
            <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                 #empty slot is absent, so the slot says what to do next
                 (DESIGN-SYSTEM §8): a muted line + one primary action.
                 Jobs are created by the application, not by the admin — the
                 CTA clears the active search. -->
            <template #empty>
                <div class="vaah-empty" data-testid="jobs-list_empty">
                    <i class="vaah-empty-icon pi pi-history" aria-hidden="true"></i>
                    <p class="vaah-empty-copy">No jobs match your search.</p>
                    <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="jobs-list_empty_reset" />
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
