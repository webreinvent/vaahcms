<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useModuleStore } from '../../../stores/store-modules'

const store = useModuleStore();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.list">
        <!--table-->
        <div class="col">
            <Card>

                <template #content>
                    <div class="grid">
                        <div class="col-12">
                            <div class="grid" v-for="item in store.list">
                                <div class="col-12 md:col-5">
                                    <h5 class="font-semibold text-xl inline">{{ item.name }}</h5>
                                    <Tag value="Default" v-if="item.is_default" severity="success" class="ml-2" rounded></Tag>
                                    <p class="text-sm text-gray-600 mt-2">{{ item.description}}</p>
                                </div>
                                <div class="col-12 md:col-7">
                                    <div class="flex justify-content-end mb-3">
                                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold">Name: {{ item.name }}</Tag>
                                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold">Version: {{ item.version }}</Tag>
                                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold">Developed by: {{ item.author_name }}</Tag>
                                    </div>
                                    <div class="flex justify-content-end">
                                        <Button v-if="item.is_active && store.hasPermission('can-deactivate-module')"
                                                data-testid="modules-table-action-deactivate"
                                                class="mr-2 p-button-sm"
                                                label="Deactivate"
                                                v-tooltip.top="'Deactivate Module'"
                                                @click="store.toggleIsActive(item)">
                                        </Button>
                                        <Button v-if="!item.is_active && store.hasPermission('can-activate-module')"
                                                data-testid="modules-table-action-activate"
                                                v-tooltip.top="'Activate Module'"
                                                label="Activate"
                                                class="mr-2 p-button-sm"
                                                @click="store.toggleIsActive(item)">
                                        </Button>
                                        <Button v-if="item.is_active && store.hasPermission('can-import-sample-data-in-module')"
                                                data-testid="modules-table-action-sample-data"
                                                size="is-small"
                                                label="Import Data"
                                                class="mr-2 p-button-sm"
                                                v-tooltip.top="'Import Data'"
                                                @click="store.itemAction('import_sample_data', item)">
                                        </Button>
                                        <Button class="p-button-info p-button-sm"
                                                data-testid="modules-table-action-install-update"
                                                icon="cloud-download-alt"
                                                @click="store.confirmUpdate(item)"
                                                v-tooltip.top="'Update Module'"
                                                v-if="item.is_update_available && store.hasPermission('can-update-module')">
                                            Update
                                        </Button>
                                        <Button class="p-button-danger p-button-sm"
                                                data-testid="modules-table-action-trash"
                                                v-if="!item.deleted_at && store.hasPermission('can-delete-module')"
                                                @click="store.confirmDeleteItem(item)"
                                                v-tooltip.top="'Trash'"
                                                icon="pi pi-trash" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Divider />
                    </div>
                </template>
            </Card>
        </div>

        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->

    </div>

</template>
