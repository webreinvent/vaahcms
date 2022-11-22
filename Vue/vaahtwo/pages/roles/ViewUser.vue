<script setup>
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

import { useRoleStore } from '../../stores/store-roles';

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
});

//--------toggle item menu--------//
const uer_items_menu = ref();

const toggleItemMenu = (event) => {
    uer_items_menu.value.toggle(event);
};
//--------toggle item menu--------//
</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item">
            <div class="grid p-fluid">
                <div class="col-12">
                    <div class="p-inputgroup ">

                        <InputText v-model="store.query.q"
                                   @keyup.enter="store.delayedItemUsersSearch()"
                                   @keyup.enter.native="store.delayedItemUsersSearch()"
                                   @keyup.13="store.delayedItemUsersSearch()"
                                   placeholder="Search"
                        />

                        <Button @click="store.delayedItemUsersSearch()"
                                icon="pi pi-search"
                        />
                    </div>
                </div>
            </div>

            <Divider />

            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <!--/item_menu-->
                    <Button
                        type="button"
                        @click="toggleItemMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"
                    />

                    <Menu ref="uer_items_menu"
                          :model="store.role_user_menu"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"
                    />
                </div>
            </template>

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
                    <template #body="prop">
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                v-else
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
                       :rowsPerPageOptions="store.rows_per_page">
            </Paginator>
            <!--/paginator-->
        </Panel>
    </div>
</template>
