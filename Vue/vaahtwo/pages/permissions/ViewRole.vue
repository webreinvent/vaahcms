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
    <div class="col-6">
        <Panel v-if="store && store.item">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">

                    <Button class="p-button-primary">
                        # {{ store.item.id }}
                    </Button>

                    <!--/item_menu-->
                    <template v-if="store.hasPermission('can-update-permissions')
                                    || store.hasPermission('can-manage-permissions')"
                              class="control"
                    >
                        <Button
                            type="button"
                            @click="toggleItemMenu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                        />

                        <Menu ref="role_menu_items"
                              :model="store.roles_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div class="grid p-fluid">
                <div class="col-12">
                    <div class="p-inputgroup ">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="store.query.permission_roles_query.q"
                                       @keyup.enter="store.delayedItemUsersSearch()"
                                       @keyup.enter.native="store.delayedItemUsersSearch()"
                                       @keyup.13="store.delayedItemUsersSearch()"
                                       placeholder="Search"
                                       class="w-full"
                            />
                        </span>

                        <Button label="Reset"
                                @click="store.resetPermissionRolesQuery()"
                        />
                    </div>
                </div>
            </div>

            <Divider />

            <DataTable v-if="store && store.permission_roles"
                       :value="store.permission_roles.list.data"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >

                    <template #body="prop" >
                        <Button :label="prop.data.name"
                                class="p-button-text"
                                @click="vaah().copy(prop.data.slug)"
                                v-tooltip.top="'Copy Slug'"
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
                                @click="store.changePermission(prop.data)"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                                @click="store.changePermission(prop.data)"
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
                        <Button class="p-button-sm p-button-rounded p-button-outlined"
                                @click="openViewModal(), store.active_permission_role = prop.data"
                                icon="pi pi-eye"
                                label="View"
                        />
                    </template>
                </Column>
            </DataTable>

            <Divider />

            <!--paginator-->
            <Paginator v-if="store && store.permission_roles"
                       v-model:rows="store.query.permission_roles_query.rows"
                       :totalRecords="store.permission_roles.list.total"
                       @page="store.rolePaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog />
    </div>
</template>
