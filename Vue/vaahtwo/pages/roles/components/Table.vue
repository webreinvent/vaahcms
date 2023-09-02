<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useRoleStore} from '../../../stores/store-roles'


const store = useRoleStore();
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
                    responsiveLayout="scroll">

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
                     <Button class="p-button-tiny p-button-text p-0 mr-2"

                             data-testid="role-list_slug_copy"
                             v-tooltip.top="'Copy Slug'"
                             @click="useVaah.copy(prop.data.slug)"
                             icon="pi pi-copy"
                             :label="prop.data.slug"
                     />

                 </template>
             </Column>

             <Column field="permissions"
                     header="Permissions"
             >
                 <template #body="props">
                     <Button class="p-button-sm p-button-rounded white-space-nowrap"
                             v-tooltip.top="'View Permissions'"
                             @click="store.toPermission(props.data)"
                             data-testid="role-list_permission_view"
                             v-if="store.hasPermission('can-read-roles')"
                     >
                         {{ props.data.count_permissions }} / {{ store.total_permissions }}
                     </Button>
                 </template>
             </Column>

            <Column field="users"
                     header="Users"
            >
                 <template #body="props">
                     <Button class="p-button-sm p-button-rounded white-space-nowrap"
                             v-tooltip.top="'View Users'"
                             @click="store.toUser(props.data)"
                             v-if="store.hasPermission('can-read-roles')"
                             data-testid="role-list_user_view"
                     >
                         {{ props.data.count_users }} / {{ store.total_users }}
                     </Button>
                 </template>
            </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    {{useVaah.ago(prop.data.updated_at)}}
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
                                 data-testid="role-list_status"
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
                    <div class="p-inputgroup ">

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="role-item_view"
                                v-if="store.hasPermission('can-read-roles')"
                        />

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                v-if="store.hasPermission('can-update-roles')"
                                icon="pi pi-pencil"
                                data-testid="role-item_edit"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="store.isViewLarge() && !prop.data.deleted_at
                                && store.hasPermission('can-update-roles')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                                data-testid="role-item_trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
                                data-testid="role-item_restore"
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
