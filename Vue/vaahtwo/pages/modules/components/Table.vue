<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useModuleStore } from '../../../stores/store-modules'
import { useConfirm } from "primevue/useconfirm";

const store = useModuleStore();
const useVaah = vaah();
const confirm = useConfirm();

const importSampleDataModal = (item) => {
    confirm.require({
        message: 'This will import sample/dummy data of the module <b>' + item.name + '</b>. This action cannot be undone.',
        header: 'Importing Sample Data',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
            store.itemAction('import_sample_data', item);
        },
    });
}
</script>

<template>
    <div v-if="store.list">
        <!--table-->
        <div class="col">
            <div class="grid">
                <div class="col-12">
                    <div class="grid" v-for="item in store.list">
                        <div class="col-12 md:col-5">
                            <h5 class="font-semibold text-xl inline">{{ item.name }}</h5>
                            <Tag value="Default" v-if="item.is_default" severity="success" class="ml-2" rounded />
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
                                        class="mr-2 p-button-sm bg-yellow-400 text-color"
                                        label="Deactivate"
                                        v-tooltip.top="'Deactivate Module'"
                                        @click="store.toggleIsActive(item)"
                                />

                                <Button v-if="!item.is_active && store.hasPermission('can-activate-module')"
                                        data-testid="modules-table-action-activate"
                                        v-tooltip.top="'Activate Module'"
                                        label="Activate"
                                        class="mr-2 p-button-sm"
                                        @click="store.toggleIsActive(item)"
                                />

                                <Button v-if="item.is_active && store.hasPermission('can-import-sample-data-in-module')"
                                        data-testid="modules-table-action-sample-data"
                                        size="is-small"
                                        label="Import Data"
                                        class="mr-2 p-button-sm"
                                        v-tooltip.top="'Import Data'"
                                        @click="importSampleDataModal(item)"
                                />

                                <Button class="mr-2 p-button-info p-button-sm"
                                        label="Update"
                                        data-testid="modules-table-action-install-update"
                                        icon="cloud-download-alt"
                                        @click="store.confirmUpdate(item)"
                                        v-tooltip.top="'Update Module'"
                                        v-if="item.is_update_available && store.hasPermission('can-update-module')"
                                />

                                <Button class="mr-2 p-button-info p-button-sm"
                                        label="Publish Assets"
                                        data-testid="modules-table-action-install-update"
                                        @click="store.publishAssets(item)"
                                        v-tooltip.top="'Publish Assets'"
                                        v-if="!item.is_assets_published && store.hasPermission('can-install-module')"
                                />

                                <Button class="p-button-danger p-button-sm"
                                        data-testid="modules-table-action-trash"
                                        v-if="!item.deleted_at && store.hasPermission('can-delete-module')"
                                        @click="store.confirmDeleteItem(item)"
                                        v-tooltip.top="'Trash'"
                                        icon="pi pi-trash"
                                />
                            </div>
                        </div>

                        <Divider />
                    </div>
                </div>
            </div>
        </div>
        <!--/table-->

        <!--paginator-->
        <Paginator v-model:first="store.firstElement"
                    :rows="store.query.rows"
                   :totalRecords="store.stats.all"
                   @page="store.paginate($event)"
                   :rows-per-page-options="store.rows_per_page"
        />
        <!--/paginator-->

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
    </div>

</template>
