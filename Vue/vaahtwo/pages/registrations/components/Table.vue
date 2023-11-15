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
                    class="p-datatable-sm p-datatable-hoverable-rows"
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
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"
                    />

                    {{ prop.data.name }}
                </template>
            </Column>

             <Column field="email"
                    header="Email"
                    :sortable="true"
             >
                <template #body="prop">
                    {{ prop.data.email }}
                </template>
            </Column>

             <Column field="status"
                    header="Status"
                    :sortable="false"
             >
                <template #body="prop">
                    <Tag v-if="prop.data.status === 'email-verified' "
                         class="mr-2 p-tag-xs bg-green-50 text-green-500 font-medium border-1 border-round-xl px-2"
                         severity="success"
                         :value="useVaah.toLabel(prop.data.status)"
                         :pt="{ value: 'line-height-1' }"
                    />

                    <Tag v-else-if="prop.data.status === 'email-verification-pending' "
                         class="mr-2 p-tag-xs bg-red-50 text-red-500 font-medium border-1 border-round-xl px-2"
                         severity="danger"
                         :value="useVaah.toLabel(prop.data.status)"
                         :pt="{ value: 'line-height-1' }"
                    />

                    <Tag v-else
                         class="mr-2 p-tag-xs bg-blue-50 text-blue-500 font-medium border-1 border-round-xl px-2"
                         severity="info"
                         :value="useVaah.toLabel(prop.data.status)"
                         :pt="{ value: 'line-height-1' }"
                    />
                </template>
            </Column>

             <Column field="updated_at" header="Updated"
                     v-if="store.isViewLarge()"
                     style="width:150px;"
                     :sortable="true"
             >
                 <template #body="prop">
                     {{ useVaah.ago(prop.data.updated_at) }}
                 </template>
             </Column>

             <Column field="gender"
                    header="Gender"
                    v-if="store.isViewLarge()"
                    :sortable="true"
             >
                <template #body="prop">
                    <Tag v-if="prop.data.gender && prop.data.gender=='m'"
                         value="Male"
                         class="mr-2 px-2 p-tag-xs font-medium bg-blue-50 text-blue-500 border-1 border-round-xl"
                         :pt="{ value: 'line-height-1' }"
                    />

                    <Tag v-if="prop.data.gender && prop.data.gender=='f'"
                         value="Female"
                         class="mr-2 px-2 p-tag-xs font-medium bg-blue-50 text-blue-500 border-1 border-round-xl"
                         :pt="{ value: 'line-height-1' }"
                    />
                    <Tag v-if="prop.data.gender && prop.data.gender=='o'"
                         value="others"
                         class="mr-2 px-2 p-tag-xs font-medium bg-blue-50 text-blue-500 border-1 border-round-xl"
                         :pt="{ value: 'line-height-1' }"
                    />
                </template>
            </Column>

             <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <div class="p-inputgroup">
                        <Button class="p-button-tiny p-button-text"
                                v-if="store.hasPermission('can-read-registrations')"
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
                                v-if="store.hasPermission('can-update-registrations')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-update-registrations')"
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



        <!--paginator-->
        <Paginator v-model:first="store.firstElement"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   data-testid="register-table_paginate"
                   class="bg-white-alpha-0 pt-2"
        />
        <!--/paginator-->
    </div>
</template>
<style scoped lang="scss">
::v-deep(.row-accessories) {
    background-color: rgba(0,0,0,.15) !important;
}
</style>
