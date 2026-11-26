<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useRoleStore} from '../../../stores/store-roles'
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
const store = useRoleStore();
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

            <Column field="name" header="Name"
                    :sortable="true"
            >
                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{prop.data.name}}
                </template>
            </Column>

             <Column v-if="store.isViewLarge()"
                     field="slug"
                     header="Slug"
                     :sortable="true"

             >
                 <template #body="prop">
                     <!-- UT-27 (M6-T4a Batch 5) — the slug was a button whose
                          label *was* the slug and whose icon was a copy glyph
                          that reads as a document at 12px. The slug is now
                          plain data (monospace) with a separate, labelled
                          copy action. -->
                     <!-- M6-T5 — `.vaah-mono` is 0.875rem (12.25px), off
                          scale; the slug is meta copy, so it takes the
                          12px caption size of DESIGN-SYSTEM.md §6. -->
                     <span class="vaah-mono vc-text-12 mr-1">{{ prop.data.slug }}</span>

                     <Button class="p-button-tiny p-button-text p-0 vaah-icon-action" text
                             aria-label="Copy slug"
                             data-testid="role-list_slug_copy"
                             v-tooltip.top="'Copy Slug'"
                             @click="useVaah.copy(prop.data.slug)"
                             icon="pi pi-copy"
                     />

                 </template>
             </Column>

             <Column field="permissions"
                     header="Permissions"
             >
                 <template #body="props">
                     <!-- UT-27 (M6-T4a Batch 5) — the count chip rendered as an
                          empty circle ("/ 76"): the count field is absent from the
                          list payload, so the left half of the ratio was blank.
                          `?? 0` renders the real zero instead of nothing. The
                          data layer that omits the count stays open as UT-13. -->
                     <Button size="small" class="white-space-nowrap" rounded
                             aria-label="View permissions"
                             v-tooltip.top="store.assets.language_strings.view_permissions"
                             @click="store.toPermission(props.data)"
                             data-testid="role-list_permission_view"
                             v-if="store.hasPermission('can-read-roles')">
                         {{ props.data.count_permissions ?? 0 }} / {{ store.total_permissions }}
                     </Button>
                 </template>
             </Column>

            <Column field="users"
                     header="Users"
            >
                 <template #body="props">
                     <Button size="small" class="white-space-nowrap" rounded
                             aria-label="View users"
                             v-tooltip.top="store.assets.language_strings.view_users"
                             @click="store.toUser(props.data)"
                             v-if="store.hasPermission('can-read-roles')"
                             data-testid="role-list_user_view">
                         {{ props.data.count_users ?? 0 }} / {{ store.total_users }}
                     </Button>
                 </template>
            </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    <!-- UT-88 (M6-T4a Batch 17) — every seeded role carries
                         `updated_at = NULL`, so the cell rendered *empty* and
                         the column looked broken rather than empty. -->
                    <span v-if="prop.data.updated_at">{{useVaah.ago(prop.data.updated_at)}}</span>
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
                                
                                 data-testid="role-list_status"
                                 :aria-label="'Toggle active status for ' + (prop.data.name || '')"
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions"
                    style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <InputGroup>

                        <!-- UT-20 (M6-T4a Batch 5) — every icon-only action button
                             needs an accessible name; the tooltip is not one. -->
                        <Button class="p-button-tiny" text
                                aria-label="View role"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="role-item_view"
                                v-if="store.hasPermission('can-read-roles')"
                        />

                        <Button class="p-button-tiny" text
                                aria-label="Edit role"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                v-if="store.hasPermission('can-update-roles')"
                                icon="pi pi-pencil"
                                data-testid="role-item_edit"
                        />

                        <Button class="p-button-tiny" severity="danger" text
                                aria-label="Move role to trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at
                                && store.hasPermission('can-update-roles')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                                data-testid="role-item_trash"
                        />

                        <Button class="p-button-tiny" severity="success" text
                                aria-label="Restore role"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                                data-testid="role-item_restore"
                        />
                    </InputGroup>
                </template>
            </Column>

             <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                  #empty slot is absent, so the slot says what to do next
                  (DESIGN-SYSTEM §8): a muted line + one primary action. -->
             <template #empty>
                 <div class="vaah-empty" data-testid="role-list_empty">
                     <i class="vaah-empty-icon pi pi-shield" aria-hidden="true"></i>
                     <p class="vaah-empty-copy">No roles match your search — reset the filters, or create a new role.</p>
                     <Button class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="role-list_empty_create" v-if="store.hasPermission('can-create-roles')" />
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
