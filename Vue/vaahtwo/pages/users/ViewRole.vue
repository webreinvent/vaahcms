<script setup>
import { vaah } from '../../vaahvue/pinia/vaah'
import { useUserStore } from '../../stores/store-users'
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import Dialog from 'primevue/dialog';

const store = useUserStore();
const useVaah = vaah();
const route = useRoute();

onMounted(async () => {

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
     * Fetch user roles from the database
     */
    if (store.item && !store.user_roles) {
        await store.getUserRoles();
    }

    /**
     * Fetch user roles menu items
     */
    await store.getUserRolesMenuItems();
});

//--------toggle item menu--------//
const user_roles_menu_state = ref();

const toggleItemMenu = (event) => {
    user_roles_menu_state.value.toggle(event);
};
//--------toggle item menu--------//

</script>
<template>
    <div class="col-5" >
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
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                            data-testid="user-role_id"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            @click="toggleItemMenu"
                            data-testid="user-role_menu"
                            v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')"
                    />

                    <Menu ref="user_roles_menu_state"
                          :model="store.user_roles_menu"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="user-role_view"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div class="grid p-fluid mt-1 mb-2">
                <div class="col-12">
                    <div class="p-inputgroup">
                         <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText class="w-full p-inputtext-sm"
                                       placeholder="Search"
                                       type="text"
                                       v-model="store.user_roles_query.q"
                                       @keyup.enter="store.delayedUserRolesSearch()"
                                       @keyup.enter.native="store.delayedUserRolesSearch()"
                                       @keyup.13="store.delayedUserRolesSearch()"
                            />
                         </span>

                        <Button class="p-button-sm"
                                label="Reset"
                                data-testid="user-role_reset"
                                @click="store.resetUserRolesFilters()"
                        />
                    </div>
                </div>
            </div>

            <div>
                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <div v-if="store && store.user_roles">
                        <DataTable :value="store.user_roles.list.data"
                                   dataKey="id"
                                   class="p-datatable-sm"
                                   stripedRows
                                   responsiveLayout="scroll"
                        >
                            <Column field="role"
                                    header="Roles"
                                    class="flex align-items-center"
                            >
                                <template #body="prop">
                                    {{ prop.data.name }}

                                    <Button class="p-button-tiny p-button-text"
                                            data-testid="taxonomies-table-to-edit"
                                            v-tooltip.top="'Copy Slug'"
                                            @click="useVaah.copy(prop.data.slug)"
                                            icon="pi pi-copy"
                                    />
                                </template>
                            </Column>

                            <Column field="role"
                                    header="Has Role"
                            >
                                <template #body="prop" v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')">
                                    <Button  v-if="prop.data.pivot.is_active === 1"
                                             class="p-button-success p-button-sm p-button-rounded"
                                            label="Yes"
                                             data-testid="user-role_status_yes"
                                            @click="store.changeUserRole(prop.data,route.params.id)"
                                    />

                                    <Button v-else
                                            class="p-button-danger p-button-sm p-button-rounded"
                                            label="No"
                                            data-testid="user-role_status_no"
                                            @click="store.changeUserRole(prop.data,route.params.id)"
                                    />
                                </template>

                                <template #body="prop" v-else>
                                    <Button v-if="prop.data.pivot.is_active === 1"
                                            class="p-button-success p-button-sm p-button-rounded"
                                            label="Yes"
                                            disabled
                                    />

                                    <Button v-else
                                            class="p-button-danger p-button-sm p-button-rounded"
                                            label="No"
                                            disabled
                                    />
                                </template>
                            </Column>

                            <Column field="view"
                                    header="View"
                            >
                                <template #body="prop">
                                    <Button class="p-button-sm p-button-rounded p-button-outlined"
                                            v-tooltip.top="'View'"
                                            @click="store.showModal(prop.data)"
                                            data-testid="user-role_details_view"
                                            icon="pi pi-eye"
                                            label="View"
                                    />
                                </template>
                            </Column>
                        </DataTable>

                        <!--paginator-->
                        <Paginator v-model:first="store.rolesFirstElement"
                                   :rows="store.user_roles_query.rows"
                                   :totalRecords="store.user_roles.list.total"
                                   @page="store.userRolesPaginate($event)"
                                   :rowsPerPageOptions="store.rows_per_page"
                                   class="bg-white-alpha-0 pt-2"
                        >
                        </Paginator>
                        <!--/paginator-->
                    </div>

                </div>
            </div>
        </Panel>

        <Dialog header="Details"
                v-model:visible="store.displayModal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <div v-for="(item,index) in store.modalData" :key="index">
                <span> {{ index }} </span> : {{ item }}

                <Divider />
            </div>
        </Dialog>
    </div>
</template>
