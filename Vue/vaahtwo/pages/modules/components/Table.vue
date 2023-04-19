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
            store.active_action.push('import_sample_data_'+item.id);
            store.itemAction('import_sample_data', item);
        },
    });
}

function actionItems(item){
    let list =[
        {
            label: 'Run Migrations',
            icon: 'pi pi-database',
            command: () => {
                store.runMigrations(item);
            }
        },
        {
            label: 'Run Seeds',
            icon: 'pi pi-server',
            command: () => {
                store.runSeeds(item);
            }
        },
        {
            label: 'Refresh Migrations',
            icon: 'pi pi-refresh',
            command: () => {
                store.resetModule(item);
            }
        },
    ];
    return list;
}

</script>

<template>
    <div v-if="store.list">
        <!--table-->
        <div class="col">
            <div class="grid">
                <div class="col-12">
                    <div class="grid" v-for="(item,index) in store.list">
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
                                        :loading="store.active_action.includes('deactivate_'+item.id)"
                                        v-tooltip.top="'Deactivate Module'"
                                        @click="store.toggleIsActive(item)"
                                />

                                <Button v-if="!item.is_active && store.hasPermission('can-activate-module')"
                                        data-testid="modules-table-action-activate"
                                        v-tooltip.top="'Activate Module'"
                                        label="Activate"
                                        class="mr-2 p-button-sm"
                                        :loading="store.active_action.includes('activate_'+item.id)"
                                        @click="store.toggleIsActive(item)"
                                />

                                <Button v-if="item.is_active && store.hasPermission('can-publish-assets-of-module')"
                                        class="mr-2 p-button-info p-button-sm"
                                        data-testid="modules-table-action-install-update"
                                        :loading="store.active_action.includes('publish_assets_'+item.id)"
                                        @click="store.publishAssets(item)"
                                        icon="pi pi-arrow-up"
                                        v-tooltip.top="'Publish Assets'"
                                />

                                <SplitButton label="Actions"
                                             v-if="item.is_active && store.hasPermission('can-deactivate-module')"
                                             v-tooltip.top="'Actions'"
                                             class="mr-1"
                                             data-testid="modules-table_action"
                                             :model="actionItems(item)" />

                                <Button v-if="item.is_active && store.hasPermission('can-import-sample-data-in-module')"
                                        data-testid="modules-table-action-sample-data"
                                        size="is-small"
                                        icon="pi pi-database"
                                        class="mr-2 p-button-sm"
                                        v-tooltip.top="'Import Sample Data'"
                                        :loading="store.active_action.includes('import_sample_data_'+item.id)"
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

                                <Button class="p-button-danger p-button-sm"
                                        data-testid="modules-table-action-trash"
                                        v-if="!item.deleted_at && store.hasPermission('can-delete-module')"
                                        @click="store.confirmDeleteItem(item)"
                                        v-tooltip.top="'Trash'"
                                        icon="pi pi-trash"
                                />

                                <Button class="p-button-sm ml-2"
                                        icon="pi pi-eye"
                                        v-tooltip.top=" 'View' "
                                        @click="store.toView(item)"
                                        v-if="item.is_active && store.hasPermission('can-read-module')"
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
        <Paginator v-model:first="store.first_element"
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
