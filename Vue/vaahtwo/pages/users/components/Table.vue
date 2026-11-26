<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useRootStore } from "../../../stores/root";
import { useUserStore } from '../../../stores/store-users'

const root = useRootStore();
const store = useUserStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list && store.assets">
        <!--table-->
        <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge() || (store.hasPermission('can-update-users') || store.hasPermission('can-manage-users'))"
                    headerStyle="width: 3em"
            />

            <Column field="id" header="ID" :style="{ width: store.getIdWidth() }" :sortable="true" />

            <Column field="name" header="Name"
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

            <Column field="email" header="Email"
                    :sortable="true"
            >
                <template #body="prop">
                    {{ prop.data.email }}
                </template>
            </Column>

            <Column  v-if="store.isViewLarge()"
                     field="last_login_at"
                     header="Last Login At"
            >
                <template #body="prop">
                    {{ prop.data.last_login_at }}
                </template>
            </Column>

            <Column field="roles"
                    header="Roles"
                    v-if="store.hasPermission('can-read-users')"
            >
                <template #body="prop">

                    <!-- UT-27 (M6-T4a Batch 5) — the ratio chip rendered with an
                         empty left half ("/ 76") when the count is absent from
                         the payload; `?? 0` shows the real zero. The underlying
                         data gap stays open as UT-13. -->
                    <Button rounded
                            aria-label="View roles"
                            data-testid="user-list_data_role"
                            @click="store.toRole(prop.data)"
                            size="small" class="white-space-nowrap"
                            :label="(prop.data.active_roles_count ?? 0) + ' / ' + store.assets.totalRole"/>
                </template>
            </Column>

            <Column v-if="store.isViewLarge() || ( store.hasPermission('can-manage-users') && store.hasPermission('can-update-users'))"
                    field="is_active"
                    header="Is Active"
                    :sortable="false"
                    style="width:100px;"
            >
                <template #body="prop">
                    <ToggleSwitch v-model.bool="prop.data.is_active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                
                                 data-testid="user-list_data_active"
                                 :aria-label="'Toggle active status for ' + (prop.data.name || '')"
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions"
                    v-if="root.assets
                          && root.assets.language_strings
                          && root.assets.language_strings.crud_actions"
                    style="width:150px;"
                    :style="{ width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop" >
                    <InputGroup>

                        <!-- UT-20 (M6-T4a Batch 5) — icon-only action buttons need
                             an accessible name; the tooltip is not one. -->
                        <Button v-if="store.hasPermission('can-impersonate-users')
                                      && store.assets.language_strings"
                                class="p-button-tiny p-button-text"
                                aria-label="Impersonate user"
                                v-tooltip.top="store.assets.language_strings.toolkit_text_impersonate"
                                @click="store.impersonate(prop.data)"
                                icon="pi pi-user"
                                :disabled="!prop.data.is_active"
                                data-testid="users-list_data_impersonate"
                        />

                        <Button class="p-button-tiny p-button-text"
                                aria-label="View user"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="user-list_data_view"
                                v-if="store.hasPermission('can-read-users')"
                        />

                        <Button class="p-button-tiny p-button-text "
                                aria-label="Edit user"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                data-testid="user-list_data_edit"
                                v-if="store.hasPermission('can-update-users')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                aria-label="Move user to trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at && store.hasPermission('can-delete-users')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                                data-testid="user-list_data_trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                aria-label="Restore user"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                                data-testid="user-list_data_restore"
                        />
                    </InputGroup>
                </template>
            </Column>

            <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                 #empty slot is absent, so the slot says what to do next
                 (DESIGN-SYSTEM §8): a muted line + one primary action. An
                 empty list is a state, not an error — the copy never paints
                 a zero count as a failure. -->
            <template #empty>
                <div class="vaah-empty" data-testid="user-list_empty">
                    <i class="vaah-empty-icon pi pi-user" aria-hidden="true"></i>
                    <p class="vaah-empty-copy">No users match your search — reset the filters, or create a new user.</p>
                    <Button class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="user-list_empty_create" v-if="store.hasPermission('can-create-users')" />
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
        >
        </Paginator>
        <!--/paginator-->
    </div>
</template>
