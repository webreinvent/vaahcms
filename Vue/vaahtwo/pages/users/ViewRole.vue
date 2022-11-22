<script setup>
import { vaah } from '../../vaahvue/pinia/vaah'
import { useUserStore } from '../../stores/store-users'
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {onMounted} from "vue";
import {useRoute} from "vue-router";
import Dialog from 'primevue/dialog';

const store = useUserStore();
const useVaah = vaah();
const route = useRoute();

onMounted(async () => {
    store.getRole(route.params.id);
});

</script>
<template>
    <div class="col-6" >

        <Panel v-if="store">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        #{{store.item.id}}
                    </div>

                </div>

            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <!--item_menu-->
                    <Button
                        type="button"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"/>

                </div>



            </template>


            <div>
                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <VhField>
                        <InputText
                            v-model="store.query.filter.q"
                            @keyup.enter="store.delayedSearch()"
                            @keyup.enter.native="store.delayedSearch()"
                            @keyup.13="store.delayedSearch()"
                            placeholder="Search Roles"
                            class="w-full"
                            name="account-search"
                            data-testid="account-search">
                        </InputText >
                    </VhField>
                    <div v-if="store.roles_list">
                        <DataTable :value="store.roles_list.data"
                                   dataKey="id"
                                   class="p-datatable-sm"
                                   stripedRows
                                   responsiveLayout="scroll">
                            <Column field="role" header="Roles"
                                    :sortable="true">
                                <template #body="prop">
                                    {{prop.data.name}}
                                </template>
                            </Column>
                            <Column field="role" header="Has Permission"
                                    :sortable="true">
                                <template #body="prop">
                                    <Button label="Yes"
                                            v-if="prop.data.pivot.is_active === 1"
                                            rounded size="is-small"
                                            type="is-success"
                                            @click="store.changePermission(prop.data,route.params.id)"
                                    />
                                    <Button label="No"
                                            v-else
                                            rounded size="is-small"
                                            type="is-danger"
                                            @click="store.changePermission(prop.data,route.params.id)"
                                    />
                                </template>
                            </Column>
                            <Column field="view" header="View"
                                    :sortable="true">
                                <template #body="prop">
                                    <Button class="p-button-tiny p-button-text"
                                            v-tooltip.top="'View'"
                                            @click="store.showModal(prop.data)"
                                            icon="pi pi-eye" />
                                </template>
                            </Column>


                        </DataTable>
                        <!--paginator-->
                        <Paginator v-model:rows="store.query.rows"
                                   :totalRecords="store.roles_list.total"
                                   @page="store.paginate($event)"
                                   :rowsPerPageOptions="store.rows_per_page">
                        </Paginator>
                        <!--/paginator-->
                    </div>

                </div>
            </div>
        </Panel>

    </div>
    <Dialog header="Detail" v-model:visible="store.displayModal" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
        <div v-for="(item,index) in store.modalData" :key="index">
            <span>{{index}}</span> : {{item}}
        </div>
    </Dialog>
</template>
