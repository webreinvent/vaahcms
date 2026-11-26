<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useRegistrationStore } from '../../../stores/store-registrations'
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
const store = useRegistrationStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        <!--table-->
         <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>
             <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            >
            </Column>

             <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
             </Column>

             <Column field="name"
                    header="Name"
                    :sortable="true"
            >
                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />

                    {{ prop.data.name }}
                </template>
            </Column>

             <Column field="email"
                    header="Email"
                    :sortable="true"
             >
                <template #body="prop">
                    {{ prop.data.email }}
                </template>
            </Column>

             <Column field="status"
                    header="Status"
                    :sortable="false"
             >
                <template #body="prop">
                    <Tag v-if="prop.data.status === 'email-verified' "
                         class="mr-2 p-tag-xs"
                         severity="success"
                         :value="useVaah.toLabel(prop.data.status)"
                    />

                    <Tag v-else-if="prop.data.status === 'email-verification-pending' "
                         class="mr-2 p-tag-xs"
                         severity="danger"
                         :value="useVaah.toLabel(prop.data.status)"
                    />

                    <Tag v-else
                         class="mr-2 p-tag-xs"
                         severity="info"
                         :value="useVaah.toLabel(prop.data.status)"
                    />
                </template>
            </Column>

             <Column field="updated_at" header="Updated"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true"
             >
                 <template #body="prop">
                     <!-- UT-88 (M6-T4a Batch 17) — a registration that has
                          never been edited carries `updated_at = NULL`, so
                          the cell rendered *empty* and the column looked
                          broken rather than empty. -->
                     <span v-if="prop.data.updated_at">{{ useVaah.ago(prop.data.updated_at) }}</span>
                     <span v-else class="vaah-empty-value">—</span>
                 </template>
             </Column>

             <Column field="gender"
                    header="Gender"
                    v-if="store.isViewLarge() && store.assets
                          && store.assets.language_strings"
                    :sortable="true"
             >
                <template #body="prop">
                    <Tag severity="info"
                         class="mr-2 p-tag-xs"
                         v-if="prop.data.gender && prop.data.gender=='m'"
                         :value="store.assets.language_strings.table_gender_male"
                    />

                    <Tag severity="info"
                         class="mr-2 p-tag-xs"
                         v-if="prop.data.gender && prop.data.gender=='f'"
                         :value="store.assets.language_strings.table_gender_female"
                    />
                    <Tag severity="info"
                         class="mr-2 p-tag-xs"
                         v-if="prop.data.gender && prop.data.gender=='o'"
                         :value="store.assets.language_strings.table_gender_others"
                    />
                </template>
            </Column>

             <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
                     v-if="root.assets
                          && root.assets.language_strings
                          && root.assets.language_strings.crud_actions"
            >
                <template #body="prop">
                    <InputGroup>
                        <!-- UT-20 (M6-T4a Batch 5) — icon-only action buttons need
                             an accessible name; the tooltip is not one. -->
                        <Button class="p-button-tiny p-button-text"
                                aria-label="View registration"
                                v-if="store.hasPermission('can-read-registrations')"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="register-table_to_view"
                        />

                        <Button class="p-button-tiny p-button-text"
                                aria-label="Edit registration"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                data-testid="register-table_to_edit"
                                v-if="store.hasPermission('can-update-registrations')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                aria-label="Move registration to trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-update-registrations')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                                data-testid="register-table_item_action_restore"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                aria-label="Restore registration"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                                data-testid="register-table_item_action_delete"
                        />
                    </InputGroup>
                </template>
            </Column>

             <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                  #empty slot is absent, so the slot says what to do next
                  (DESIGN-SYSTEM §8): a muted line + one primary action. -->
             <template #empty>
                 <div class="vaah-empty" data-testid="register-list_empty">
                     <i class="vaah-empty-icon pi pi-id-card" aria-hidden="true"></i>
                     <p class="vaah-empty-copy">No registrations match your search — reset the filters, or create a new registration.</p>
                     <Button class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="register-list_empty_create" v-if="store.hasPermission('can-create-registrations')" />
                 </div>
             </template>
        </DataTable>
        <!--/table-->



        <!--paginator-->
        <Paginator v-model:first="store.firstElement"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   data-testid="register-table_paginate"
                   class="bg-white-alpha-0 pt-2"
        />
        <!--/paginator-->
    </div>
</template>
<style scoped lang="scss">
::v-deep(.row-accessories) {
    background-color: rgba(0,0,0,.15) !important;
}
</style>
