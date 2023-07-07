<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { usePermissionStore } from '../../../stores/store-permissions'

const store = usePermissionStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list.data"
                    dataKey="id"
                    class="p-datatable-sm p-datatable-hoverable-rows"
                    v-model:selection="store.action.items"
                    stripedRows
                    responsiveLayout="scroll"

         >

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id"
                    header="ID"
                    class="text-sm"
                    :style="{width: store.getIdWidth()}"
                    :sortable="true"
            />

            <Column field="name" header="Name"
                    :sortable="true">

                <template #body="prop" class="text-xs">
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
                <template #body="prop" class="text-xs">
                    <Button class="p-button-tiny p-button-text p-0"
                            data-testid="permission-list_slug_copy"
                            v-tooltip.top="'Copy Slug'"
                            @click="useVaah.copy(prop.data.slug)"
                            icon="pi pi-copy"
                            :label="prop.data.slug"
                    />

                </template>
            </Column>

             <Column field="total_roles"
                     header="Roles"

             >
                 <template #body="prop">
                     <Button class="p-button p-button-rounded p-button-sm white-space-nowrap"
                             v-tooltip.top="'View Role'"
                             @click="store.toRole(prop.data)"
                             data-testid="permission-role_view"
                             v-if="store.hasPermission('can-read-permissions')"
                     >
                        {{ prop.data.count_roles }} / {{store.total_roles }}
                     </Button>
                 </template>
             </Column>

             <Column field="total_users"
                     header="Users"
             >
                 <template #body="prop">
                     <Button class="p-button p-button-rounded p-button-sm white-space-nowrap"
                             v-tooltip.top="'User'"
                             disabled
                     >
                         {{ prop.data.count_users }} / {{store.total_users }}
                     </Button>
                 </template>
             </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop" class="text-sm">
                    {{ useVaah.ago(prop.data.updated_at) }}
                </template>

            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="false"
                    style="width:100px;"
                    header="Is Active"
            >
                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 @input="store.toggleIsActive(prop.data)"
                                 data-testid="permission-list_status"
                    />
                </template>

            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <div class="p-inputgroup has-shadowless">

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                v-if="store.hasPermission('can-read-permissions')"
                                icon="pi pi-eye"
                                data-testid="permission-list_view"
                        />

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                v-if="store.hasPermission('can-update-permissions')"
                                icon="pi pi-pencil"
                                data-testid="permission-list_edit"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-update-permissions')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                                data-testid="permission-list_trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
                                data-testid="permission-list_restore"
                        />
                    </div>
                </template>
            </Column>

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
