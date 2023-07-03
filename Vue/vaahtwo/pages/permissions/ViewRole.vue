<script setup>

import { onMounted, ref } from "vue";
import { usePermissionStore } from "../../stores/store-permissions";
import { useDialog } from 'primevue/usedialog';
import RoleDetailsView from './components/RoleDetasilsView.vue'
import { useRoute } from "vue-router";
import { useRootStore } from "../../stores/root";
import { vaah } from "../../vaahvue/pinia/vaah";

const store = usePermissionStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted( async () => {
    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if (route.params && !route.params.id) {
        store.toList();
        return false;
    }

    /**
     * Fetch the item from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch the record from the database
     */
    if (store.item && !store.permission_roles) {
        await store.getItemRoles();
    }

    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();

    /**
     * Fetch the role menu items
     */
    await store.getRoleMenu();
});


//--------toggle item menu--------//
const role_menu_items = ref();

const toggleItemMenu = (event) => {
    role_menu_items.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openViewModal = () => {
    const dialogRef = dialog.open(RoleDetailsView, {
        props: {
            header: 'Details',
            style: {
                width: '50vw',
            },
            breakpoints:{
                '960px': '75vw',
                '640px': '90vw'
            },
            modal: true
        }
    });
}
//--------toggle dynamic modal--------//

</script>

<template>
    <div class="col-5">
        <Panel v-if="store && store.item" class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="font-semibold text-sm">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">

                    <Button class="p-button-sm"
                            :label=" '#' + store.item.id"
                            data-testid="permission-role_id"
                            @click="useVaah.copy(store.item.id)"
                    />

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-permissions')
                                    || store.hasPermission('can-manage-permissions')"
                              class="control"
                    >
                        <Button class="p-button-sm"
                                icon="pi pi-angle-down"
                                type="button"
                                aria-haspopup="true"
                                data-testid="permission-role_menu"
                                @click="toggleItemMenu"
                        />

                        <Menu ref="role_menu_items"
                              :model="store.roles_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="permission-role_list"
                            @click="store.toList()"
                    />
                </div>
            </template>



            <div class="grid p-fluid mt-1 mb-2">
                <div class="col-12">
                    <div class="p-inputgroup ">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText  class="w-full p-inputtext-sm"
                                        placeholder="Search"
                                        data-testid="permission-role_search"
                                        v-model="store.permission_roles_query.q"
                                        @keyup.enter="store.delayedItemUsersSearch()"
                                        @keyup.enter.native="store.delayedItemUsersSearch()"
                                        @keyup.13="store.delayedItemUsersSearch()"
                            />
                        </span>

                        <Button class="p-button-sm" label="Reset"
                                data-testid="permission-role_reset"
                                @click="store.resetPermissionRolesQuery()"
                        />
                    </div>
                </div>
            </div>
            <DataTable v-if="store && store.permission_roles"
                       :value="store.permission_roles.list.data"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="role"
                        header="Role"
                        class="flex align-items-center"
                >

                    <template #body="prop" >

                        {{ prop.data.name }}

                        <Button class="p-button-tiny p-button-text"
                                data-testid="permissions-role_id"
                                v-tooltip.top="'Copy Slug'"
                                @click="useVaah.copy(prop.data.slug)"
                                icon="pi pi-copy"
                        />

                    </template>
                </Column>

                <Column field="has-permission"
                        header="Has Permission"
                >

                    <template #body="prop"
                              v-if="store.hasPermission('can-update-permissions') || store.hasPermission('can-manage-permissions')"
                    >
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                                data-testid="permission-role_status_yes"
                                @click="store.changePermission(prop.data)"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                                @click="store.changePermission(prop.data)"
                                data-testid="permission-role_status_no"
                        />
                    </template>

                    <template #body="prop"
                              v-else

                    >
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                                disabled
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                disabled
                                v-else
                        />
                    </template>
                </Column>

                <Column>
                    <template #body="prop">
                        <Button class="p-button-sm p-button-rounded"
                                @click="openViewModal(), store.active_permission_role = prop.data"
                                icon="pi pi-eye"
                                data-testid="permission-role_view_details"
                                label="View"
                        />
                    </template>
                </Column>
            </DataTable>


            <!--paginator-->
            <Paginator v-if="store && store.permission_roles"
                       v-model:first="store.rolesFirstElement"
                       :rows="store.permission_roles_query.rows"
                       :totalRecords="store.permission_roles.list.total"
                       @page="store.rolePaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog />
    </div>
</template>

