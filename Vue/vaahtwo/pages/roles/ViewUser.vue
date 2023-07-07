<script setup>
import { h, onMounted, ref } from "vue";
import { useRoute } from 'vue-router';

import { useRoleStore } from '../../stores/store-roles';
import { vaah } from '../../vaahvue/pinia/vaah';
import { useDialog } from "primevue/usedialog";
import RoleUserDetailsView from "./components/RoleUserDetailsView.vue";

const store = useRoleStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch item users from the database
     */
    if (store.item && !store.role_users) {
        await store.getItemUsers();
    }

    /**
     * Fetch user menu item from store
     */
    await store.getRoleUserMenuItems();
});

//--------toggle item menu--------//
const uer_items_menu = ref();

const toggleItemMenu = (event) => {
    uer_items_menu.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openDetailsViewModal = () => {
    const dialogRef = dialog.open(RoleUserDetailsView, {
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
    <div class="col-6">
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
                            @click="useVaah.copy(store.item.id)"
                            data-testid="role-user_id"
                    />

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-roles')
                                    || store.hasPermission('can-manage-roles')"
                              class="control"
                    >
                        <Button class="p-button-sm"
                                icon="pi pi-angle-down"
                                type="button"
                                aria-haspopup="true"
                                data-testid="role-user_menu"
                                @click="toggleItemMenu"
                        />

                        <Menu ref="uer_items_menu"
                              :model="store.role_user_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="role-user_list"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div class="grid p-fluid mt-1 mb-2">
                <div class="col-12">
                    <div class="p-inputgroup">
                         <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="store.role_users_query.q"
                                       @keyup.enter="store.delayedRoleUsersSearch()"
                                       @keyup.enter.native="store.delayedRoleUsersSearch()"
                                       @keyup.13="store.delayedRoleUsersSearch()"
                                       placeholder="Search"
                                       type="text"
                                       data-testid="role-user_search"
                                       class="w-full p-inputtext-sm"
                            />
                         </span>

                        <Button class="p-button-sm"
                                data-testid="role-user_search_reset"
                                label="Reset"
                                @click="store.resetRoleUserFilters()"

                        />
                    </div>
                </div>
            </div>


            <DataTable v-if="store && store.role_users"
                       :value="store.role_users.list.data"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >
                    <template #body="prop">
                        {{ prop.data.name }}
                    </template>
                </Column>

                <Column field="email"
                        header="Email"
                >
                    <template #body="prop">
                        {{ prop.data.email }}
                    </template>
                </Column>

                <Column field="has-role"
                        header="Has Role"
                >
                    <template #body="prop"
                              v-if="store.hasPermission('can-update-roles')||
                                    store.hasPermission('can-manage-roles')"
                    >
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                                @click="store.changeUserRole(prop.data)"
                                data-testid="role-user_status_yes"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                data-testid="role-user_status_no"
                                v-else
                                @click="store.changeUserRole(prop.data)"
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
                                v-else
                                disabled
                        />
                    </template>
                </Column>

                <Column>
                    <template #body="prop">
                        <Button class="p-button-sm p-button-rounded p-button-outlined"
                                @click="openDetailsViewModal(), store.active_role_user = prop.data"
                                icon="pi pi-eye"
                                label="View"
                                data-testid="role-user_view_details"
                        />
                    </template>
                </Column>
            </DataTable>
            <!--paginator-->
            <Paginator v-if="store && store.role_users"
                       v-model:rows="store.role_users_query.rows"
                       :totalRecords="store.role_users.list.total"
                       @page="store.userPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog  />
    </div>
</template>
