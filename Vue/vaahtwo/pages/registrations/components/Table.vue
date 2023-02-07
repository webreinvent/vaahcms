<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useRegistrationStore } from '../../../stores/store-registrations'

const store = useRegistrationStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list.data"
                    dataKey="id"
                    class="p-datatable-sm"
                    v-model:selection="store.action.items"
                    stripedRows
                    responsiveLayout="scroll"
         >
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            >
            </Column>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name"
                    header="Name"
                    :sortable="true"
                    >
                <template #body="prop">
                    {{ prop.data.name }}
                </template>
            </Column>

             <Column field="email"
                    header="Email"
                    :sortable="true">
                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />

                    {{ prop.data.email }}
                </template>
            </Column>

             <Column field="status"
                    header="Status"
                    :sortable="false"
             >
                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />

                    <Tag class="mr-2" severity="success"  v-if="prop.data.status">
                        {{ prop.data.status }}
                    </Tag>
                </template>
            </Column>

             <Column field="updated_at" header="Updated"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true">
                 <template #body="prop">
                     {{ useVaah.ago(prop.data.updated_at) }}
                 </template>
             </Column>

             <Column field="gender"
                    header="Gender"
                    v-if="store.isViewLarge()"
                    :sortable="true"
             >
                <template #body="prop"  >
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />

                    <Tag severity="primary"
                         class="mr-2"
                         v-if="prop.data.gender && prop.data.gender=='m'"
                    >
                         Male
                    </Tag>

                    <Tag severity="primary"
                         class="mr-2"
                         v-if="prop.data.gender && prop.data.gender=='f'"
                    >
                        Female
                    </Tag>

                    <Tag severity="primary"
                         class="mr-2" v-if="prop.data.gender && prop.data.gender=='o'"
                    >
                        Other
                    </Tag>
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <div class="p-inputgroup">
                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                data-testid="register-table_to_view"
                        />

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                data-testid="register-table_to_edit"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                                data-testid="register-table_item_action_restore"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
                                data-testid="register-table_item_action_delete"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   data-testid="register-table_paginate"
        />
        <!--/paginator-->
    </div>
</template>
