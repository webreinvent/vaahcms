<script setup>
import { h, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useDialog } from 'primevue/usedialog';
import { useConfirm } from "primevue/useconfirm";
import { useRoleStore } from '../../stores/store-roles'
import { useRootStore } from "../../stores/root"
import { vaah } from "../../vaahvue/pinia/vaah";

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import PermissionDetailsView from './components/PermissionDetailsView.vue';

const useVaah = vaah();
const store = useRoleStore();
const route = useRoute();
const root = useRootStore();

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
     * Fetch item permissions from the database
     */
    if (store.item && !store.role_permissions) {
        await store.getItemPermissions();
    }

    /**
     * Fetch permission menu item from store
     */
    await store.getPermissionMenuItems();

    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();
});


//--------toggle item menu--------//
const permission_menu = ref();

const toggleItemMenu = (event) => {
    permission_menu.value.toggle(event);
};
//--------toggle item menu--------//


//--------toggle dynamic modal--------//
const dialog = useDialog();

const openViewModal = () => {
    const dialogRef = dialog.open(PermissionDetailsView, {
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


//--------toggle confirm modal--------//
const confirm = useConfirm();

const confirmChangeStatus = (event, id) => {
    confirm.require({
        group: 'templating',
        message: 'Are you sure you want to change the status? This action will impact all roles that assign to this permission.',
        header: 'Changing Status',
        icon: 'pi pi-exclamation-circle text-red-600',
        acceptClass:'p-button p-button-danger is-small',
        acceptLabel:'Change',
        rejectLabel:'Cancel',
        rejectClass:' is-small btn-dark',

        accept: () => {
            store.changeRoleStatus(id);
        },
    })
};
//--------toggle confirm modal--------//
</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item">
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
                                @click="toggleItemMenu"
                        />

                        <Menu ref="permission_menu"
                              :model="store.permission_menu_items"
                              :popup="true"
                        />
                    </template>
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div class="flex justify-content-between">

                <div v-if="store && store.assets">
                    <Dropdown v-model="store.role_permissions_query.module"
                              :options="store.assets.modules"
                              placeholder="Select a Module"
                              @change="store.getModuleSection()"
                    >
                        <template #option="slotProps">
                            <div>
                                {{ slotProps.option.charAt(0).toUpperCase() + slotProps.option.slice(1) }}
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <div v-if="store.role_permissions_query.module && store.module_section_list"
                     class="mx-1"
                >
                    <Dropdown v-model="store.role_permissions_query.section"
                              :options="store.module_section_list"
                              placeholder="Select a Section"
                              @click="store.getItemPermissions()"
                    >
                        <template #option="slotProps">
                            <div>
                                {{ slotProps.option.charAt(0).toUpperCase() + slotProps.option.slice(1) }}
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <div class="grid p-fluid">
                    <div class="col-12">
                        <div class="p-inputgroup">
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="store.role_permissions_query.q"
                                           @keyup.enter="store.delayedRolePermissionSearch()"
                                           @keyup.enter.native="store.delayedRolePermissionSearch()"
                                           @keyup.13="store.delayedRolePermissionSearch()"
                                           placeholder="Search"
                                           type="text"
                                           class="w-full"
                                />
                            </span>

                            <Button label="Reset"
                                    @click="store.resetRolePermissionFilters()"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <DataTable v-if="store && store.role_permissions"
                       :value="store.role_permissions.list.data"
                       dataKey="id"
                       class="p-datatable-sm mt-3"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >

                    <template #body="prop">

                        <Button :label="prop.data.name"
                                class="p-button-text text-left"
                                @click="useVaah.copy(prop.data.slug)"
                                v-tooltip.top="'Copy Slug'"
                        />
                    </template>
                </Column>

                <Column field="has-permission"
                        header="Has Permission"
                >

                    <template #body="prop"
                              v-if="store.hasPermission('can-update-roles') || store.hasPermission('can-manage-roles')"
                    >
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                                @click="store.changeRolePermission(prop.data)"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                                @click="store.changeRolePermission(prop.data)"
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

                <Column field="is-active"
                        header="Permission Status"
                >

                    <template #body="prop"
                              v-if="(store.hasPermission('can-update-permissions')|| store.hasPermission('can-manage-permissions'))
                               && (store.hasPermission('can-update-roles')|| store.hasPermission('can-manage-roles'))"
                    >
                        <Button label="Active"
                                class="p-button-sm p-button-rounded p-button-success"
                                v-if="prop.data.is_active === 1"
                                @click="confirmChangeStatus(event, prop.data.id)"
                        />

                        <Button label="Inactive"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                                @click="confirmChangeStatus(event, prop.data.id)"
                        />
                    </template>

                    <template #body="prop"
                              v-else
                    >
                        <Button label="Active"
                                class="p-button-sm p-button-rounded p-button-success"
                                v-if="prop.data.is_active === 1"
                                disabled
                        />

                        <Button label="Inactive"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
                                disabled
                        />
                    </template>
                </Column>

                <Column>
                    <template #body="prop">
                        <Button class="p-button-sm p-button-rounded p-button-outlined"
                                @click="openViewModal(), store.active_role_permission = prop.data"
                                icon="pi pi-eye"
                                label="View"
                        />
                    </template>
                </Column>
            </DataTable>

            <Divider />

            <!--paginator-->
            <Paginator v-if="store && store.role_permissions"
                       v-model:rows="store.role_permissions_query.rows"
                       :totalRecords="store.role_permissions.list.total"
                       @page="store.permissionPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
            />
            <!--/paginator-->
        </Panel>

        <ConfirmDialog group="templating" class="is-small"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 text-sm">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>

        <DynamicDialog  />
    </div>
</template>
