<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'

const store = useThemeStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">

        <!--table-->
         <DataTable :value="store.list"
                       dataKey="id"
                   class="p-datatable-sm"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em">
            </Column>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name" header="Name" :sortable="true">

                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{ prop.data.name }}
                </template>

            </Column>


                <Column field="updated_at" header="Updated"
                        v-if="store.isViewLarge()"
                        style="width:150px;"
                        :sortable="true">

                    <template #body="prop">
                        {{useVaah.ago(prop.data.updated_at)}}
                    </template>

                </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="true"
                    style="width:100px;"
                    header="Is Active">

                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 data-testid="themes-table-is-active"
                                 v-bind:false-value="0"  v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 @input="store.toggleIsActive(prop.data)">
                    </InputSwitch>
                </template>

            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()">

                <template #body="prop">
                    <div class="p-inputgroup ">

                        <Button class="p-button-tiny p-button-text"
                                data-testid="themes-table-to-view"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye" />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="themes-table-to-edit"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil" />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="themes-table-action-trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash" />


                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="themes-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay" />


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
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->
        <div class="grid extend">
            <div class="col">
                <Card>
                    <template #header>
                        <div class="flex justify-content-between align-items-center">
                            <h5 class="font-semibold text-lg">Themes</h5>
                            <div class="p-inputgroup justify-content-end">
                                <Button label="Install" icon="pi pi-plus" class="p-button-sm"/>
                                <Button class="p-button-sm" icon="pi pi-download" label="Check Updates"/>
                                <Button icon="pi pi-refresh" class="p-button-sm"/>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <div class="grid">
                            <div class="col-4 mb-5">
                                <Dropdown placeholder="Select a filter"></Dropdown>
                            </div>
                            <div class="col-5 col-offset-3 mb-5">
                                <div class="p-inputgroup">
                                    <InputText placeholder="Search"></InputText>
                                    <Button label="Filter"></Button>
                                    <Button label="Reset"></Button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="grid">
                                    <div class="col-12 md:col-5">
                                        <h5 class="font-semibold text-xl inline">Theme for Jalapeno</h5>
                                        <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                                        <p class="text-sm text-gray-600 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                                    </div>
                                    <div class="col-12 md:col-7">
                                        <div class="flex justify-content-end mb-3">
                                            <Tag value="Name: Jalapeno" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                            <Tag value="Version: 1.1.10" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                            <Tag value="Developed by: WebReinvent" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                        </div>
                                        <div class="flex justify-content-end">
                                            <Button label="Deactivate" class="mr-2 p-button-sm"></Button>
                                            <Button label="Import Data" class="mr-2 p-button-sm"></Button>
                                            <Button icon="pi pi-check" class="mr-2 p-button-sm p-button-warning"></Button>
                                            <Button icon="pi pi-trash" class="mr-2 p-button-sm p-button-danger"></Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <Divider />
                            <div class="col-12">
                                <div class="grid">
                                    <div class="col-12 md:col-9">
                                        <h5 class="font-semibold text-xl inline">Theme for Jalapeno</h5>
                                        <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                                        <p class="text-sm text-gray-600 mt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                                        <div class="flex mt-3">
                                            <Tag value="Name: Jalapeno" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                            <Tag value="Version: 1.1.10" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                            <Tag value="Developed by: WebReinvent" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                        </div>
                                    </div>
                                    <div class="col-12 md:col-3">
                                        <div class="flex justify-content-end">
                                            <Button label="Deactivate" class="mr-2 p-button-sm"></Button>
                                            <Button icon="pi pi-ellipsis-v" class="p-button-link" @click="toggle"></Button>
                                        </div>
                                        <TieredMenu :model="menu_options" ref="menu" :popup="true">
                                        </TieredMenu>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6" v-if="show_themes">
                <Card>
                    <template #header>
                        <div class="flex justify-content-between align-items-center">
                            <h5 class="white-space-nowrap font-semibold text-lg">Install Themes</h5>
                            <div class="p-inputgroup justify-content-end w-6">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText placeholder="Search" class="w-full"></InputText>
                        </span>
                                <Button icon="pi pi-times" class="p-button-sm" @click="hideThemes"/>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <div class="grid">
                            <div class="col-12 md:col-6">
                                <Card>
                                    <template #header>
                                        <img src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png" style="height: 15rem" />
                                    </template>
                                    <template #content>
                                        <h5 class="text-xl font-semibold mb-1">Bulma Blog Theme</h5>
                                        <p class="mb-3 text-sm">Bulma is a multipurpose responsive VaahCms theme.</p>
                                        <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                        <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                        <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                                    </template>
                                    <template #footer>
                                        <Button label="Install" icon="pi pi-download" class="p-button-outlined p-button-sm"></Button>
                                    </template>
                                </Card>
                            </div>
                            <div class="col-12 md:col-6">
                                <Card>
                                    <template #header>
                                        <img src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png" style="height: 15rem" />
                                    </template>
                                    <template #content>
                                        <h5 class="text-xl font-semibold mb-1">Bulma Blog Theme</h5>
                                        <p class="mb-3 text-sm">Bulma is a multipurpose responsive VaahCms theme.</p>
                                        <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                        <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                        <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                                    </template>
                                    <template #footer>
                                        <Button label="Install" icon="pi pi-download" class="p-button-outlined p-button-sm"></Button>
                                    </template>
                                </Card>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>
        </div>

    </div>

</template>
