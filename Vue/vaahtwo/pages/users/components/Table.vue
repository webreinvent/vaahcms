<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useUserStore } from '../../../stores/store-users'

const store = useUserStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list && store.assets">
        <!--table-->
        <DataTable :value="store.list.data"
                   dataKey="id"
                   class="p-datatable-sm"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll"
        >
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
                    <Button class="p-button-sm p-button-rounded white-space-nowrap"
                            data-testid="user-list_data_role"
                            @click="store.toRole(prop.data)"
                    >
                        {{ prop.data.active_roles_count }} / {{ store.assets.totalRole }}
                    </Button>
                </template>
            </Column>

            <Column v-if="store.isViewLarge() || ( store.hasPermission('can-manage-users') && store.hasPermission('can-update-users'))"
                    field="is_active"
                    header="Is Active"
                    :sortable="false"
                    style="width:100px;"
            >
                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 data-testid="user-list_data_active"
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{ width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop" >
                    <div class="p-inputgroup">

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="user-list_data_view"
                                v-if="store.hasPermission('can-read-users')"
                        />

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                data-testid="user-list_data_edit"
                                v-if="store.hasPermission('can-update-users')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-delete-users')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                                data-testid="user-list_data_trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
                                data-testid="user-list_data_restore"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:first="store.firstElement"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->
    </div>
</template>
