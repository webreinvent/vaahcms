<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { usePermissionStore } from '../../../stores/store-permissions';
import { useRootStore } from "../../../stores/root";
const root = useRootStore();
const store = usePermissionStore();
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

            <Column field="id"
                    header="ID"
                    class="vc-text-13"
                    :style="{width: store.getIdWidth()}"
                    :sortable="true"
            />

            <Column field="name" header="Name"
                    :sortable="true">

                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />
                    {{ prop.data.name }}
                </template>
            </Column>

             <Column field="slug"
                     header="Slug"
                    :sortable="true"
                     v-if="store.isViewLarge()"

             >
                <template #body="prop">
                    <!-- UT-27 (M6-T4a Batch 5) — the slug was a button whose
                         label *was* the slug and whose icon was a copy glyph
                         that reads as a document at 12px. The slug is now plain
                         data (monospace) with a separate, labelled copy
                         action. -->
                    <!-- M6-T5 — `.vaah-mono` is 0.875rem (12.25px), off
                         scale; the slug is meta copy, so it takes the 12px
                         caption size of DESIGN-SYSTEM.md §6. -->
                    <span class="vaah-mono vc-text-12 mr-1">{{ prop.data.slug }}</span>

                    <Button class="p-button-tiny p-button-text p-0 vaah-icon-action" text
                            aria-label="Copy slug"
                            data-testid="permission-list_slug_copy"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                            @click="useVaah.copy(prop.data.slug)"
                            icon="pi pi-copy"
                    />

                </template>
            </Column>

             <Column field="total_roles"
                     header="Roles"

             >
                 <template #body="prop">
                     <!-- UT-27 (M6-T4a Batch 5) — the count chip rendered with an
                          empty left half when the count is absent from the payload;
                          `?? 0` shows the real zero (the data gap stays open as
                          UT-13). -->
                     <Button size="small" class="white-space-nowrap" rounded
                             aria-label="View roles with this permission"
                             v-tooltip.top="store.assets.language_strings.toolkit_text_view_role"
                             @click="store.toRole(prop.data)"
                             data-testid="permission-role_view"
                             v-if="store.hasPermission('can-read-permissions')">
                        {{ prop.data.count_roles ?? 0 }} / {{store.total_roles }}
                     </Button>
                 </template>
             </Column>

             <Column field="total_users"
                     header="Users"
             >
                 <template #body="prop">
                     <Button size="small" class="white-space-nowrap" rounded
                             aria-label="View users with this permission"
                             v-tooltip.top="store.assets.language_strings.toolkit_text_view_user" disabled>
                         {{ prop.data.count_users ?? 0 }} / {{store.total_users }}
                     </Button>
                 </template>
             </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    <!-- UT-88 (M6-T4a Batch 17) — every seeded permission
                         carries `updated_at = NULL`, so the cell rendered
                         *empty* and the column looked broken rather than
                         empty. -->
                    <span v-if="prop.data.updated_at" class="vc-text-13">{{ useVaah.ago(prop.data.updated_at) }}</span>
                    <span v-else class="vaah-empty-value">—</span>
                </template>

            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="false"
                    style="width:100px;"
                    header="Is Active"
            >
                <template #body="prop">
                    <ToggleSwitch v-model.bool="prop.data.is_active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                
                                 @input="store.toggleIsActive(prop.data)"
                                 data-testid="permission-list_status"
                                 :aria-label="'Toggle active status for ' + (prop.data.name || '')"
                    />
                </template>

            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <InputGroup class="has-shadowless">

                        <!-- UT-20 (M6-T4a Batch 5) — icon-only action buttons need
                             an accessible name; the tooltip is not one. -->
                        <Button class="p-button-tiny" text
                                aria-label="View permission"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                v-if="store.hasPermission('can-read-permissions')"
                                icon="pi pi-eye"
                                data-testid="permission-list_view"
                        />

                        <Button class="p-button-tiny" text
                                aria-label="Edit permission"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                v-if="store.hasPermission('can-update-permissions')"
                                icon="pi pi-pencil"
                                data-testid="permission-list_edit"
                        />

                        <Button class="p-button-tiny" severity="danger" text
                                aria-label="Move permission to trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-update-permissions')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                                data-testid="permission-list_trash"
                        />

                        <Button class="p-button-tiny" severity="success" text
                                aria-label="Restore permission"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                                data-testid="permission-list_restore"
                        />
                    </InputGroup>
                </template>
            </Column>

             <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                  #empty slot is absent, so the slot says what to do next
                  (DESIGN-SYSTEM §8): a muted line + one primary action.
                  Permissions have no create form — the CTA clears the
                  active search, the only way back to the full list. -->
             <template #empty>
                 <div class="vaah-empty" data-testid="permission-list_empty">
                     <i class="vaah-empty-icon pi pi-key" aria-hidden="true"></i>
                     <p class="vaah-empty-copy">No permissions match your search.</p>
                     <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="permission-list_empty_reset" />
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
                   class="bg-white-alpha-0 pt-2"
        />
        <!--/paginator-->

    </div>

</template>
