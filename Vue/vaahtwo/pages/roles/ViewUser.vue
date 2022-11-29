<script setup>
import { h, onMounted, ref } from "vue";
import { useRoute } from 'vue-router';

import { useRoleStore } from '../../stores/store-roles';
import { useDialog } from "primevue/usedialog";
import RoleUserDetailsView from "../../components/molecules/RoleUserDetailsView.vue";

const store = useRoleStore();
const route = useRoute();

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
    if(!store.item)
    {
        await store.getItem(route.params.id);
    }

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
                    <template v-if="store.hasPermission('can-update-roles')
                                    || store.hasPermission('can-manage-roles')"
                              class="control"
                    >
                        <Button
                            type="button"
                            @click="toggleItemMenu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                        />

                        <Menu ref="uer_items_menu"
                              :model="store.role_user_menu_items"
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
                    <div class="p-inputgroup">

                        <InputText v-model="store.role_user_query.q"
                                   @keyup.enter="store.delayedItemUsersSearch()"
                                   @keyup.enter.native="store.delayedItemUsersSearch()"
                                   @keyup.13="store.delayedItemUsersSearch()"
                                   placeholder="Search"
                        />
                    </div>
                </div>
            </div>

            <Divider />

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
                        {{ prop.data.email }}l
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
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
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
                        />
                    </template>
                </Column>
            </DataTable>

            <Divider />

            <!--paginator-->
            <Paginator v-if="store && store.role_users"
                       :rows="store.query.rows"
                       :totalRecords="store.role_users.list.total"
                       @page="store.permissionPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
            />
            <!--/paginator-->
        </Panel>

        <DynamicDialog  />
    </div>
</template>
