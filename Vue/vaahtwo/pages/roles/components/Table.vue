<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useRoleStore} from '../../../stores/store-roles'


const store = useRoleStore();
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
                    responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true" />

            <Column field="name" header="Name"
                    :sortable="true"
            >
                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{prop.data.name}}
                </template>
            </Column>

             <Column v-if="store.isViewLarge()"
                     field="slug"
                     header="Slug"
                     :sortable="true"
                     class="flex align-items-center"
             >
                 <template #body="prop">
                     {{ prop.data.slug }}

                     <Button class="p-button-tiny p-button-text"
                             data-testid="taxonomies-table-to-edit"
                             v-tooltip.top="'Copy Slug'"
                             @click="useVaah.copy(prop.data.slug)"
                             icon="pi pi-copy"
                     />

                 </template>
             </Column>

             <Column field="permissions"
                     header="Permissions"
             >
                 <template #body="props">
                     <Button class="p-button-sm p-button-rounded white-space-nowrap"
                             v-tooltip.top="'View Permissions'"
                             @click="store.toPermission(props.data)"
                     >
                         {{ props.data.count_permissions }} / {{ store.total_permissions }}
                     </Button>
                 </template>
             </Column>

            <Column field="users"
                     header="Users"
            >
                 <template #body="props">
                     <Button class="p-button-sm p-button-rounded white-space-nowrap"
                             v-tooltip.top="'View Users'"
                             @click="store.toUser(props.data)"
                     >
                         {{ props.data.count_users }} / {{ store.total_users }}
                     </Button>
                 </template>
            </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    {{useVaah.ago(prop.data.updated_at)}}
                </template>
            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="false"
                    style="width:100px;"
                    header="Is Active"
            >
                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions"
                    style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <div class="p-inputgroup ">

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                        />

                        <Button class="p-button-tiny p-button-text"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
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
                   :rowsPerPageOptions="store.rows_per_page"
        />
        <!--/paginator-->

    </div>

</template>
