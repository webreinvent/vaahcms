<script setup>

import { ref } from "vue";
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'
import { useConfirm } from "primevue/useconfirm";

const store = useThemeStore();
const useVaah = vaah();


const menu_options = ref();
const hideThemes = ref();
const toggle = ref();

const confirm = useConfirm();

const importSampleDataModal = (item) => {
    confirm.require({
        message: 'This will import sample/dummy data of the theme <b>' + item.name + '</b>. This action cannot be undone.',
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
                store.resetTheme(item);
            }
        },
    ];
    return list;
}

</script>

<template>

    <div v-if="store.list">
        <div class="col-12" v-for="(item, index) in store.list">
            <div class="grid">
                <div class="col-12 md:col-5">
                    <h5 class="font-semibold text-xl inline">{{ item.name }}</h5>
                    <Tag v-if="item.is_default" value="Default" severity="success" class="ml-2" rounded></Tag>
                    <p class="text-sm text-gray-600 mt-2">{{ item.description }}</p>
                </div>
                <div class="col-12 md:col-7">
                    <div class="flex justify-content-end mb-3">
                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Name: ' + item.name "
                        />

                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Version: ' + item.version "
                        />

                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Developed by: ' + item.author_name "
                        />
                    </div>

                    <div class="flex justify-content-end">
                        <Button v-if="item.is_active && store.hasPermission('can-deactivate-theme')"
                                class="mr-2 p-button-sm bg-yellow-400 text-color"
                                :loading="store.active_action.includes('deactivate_'+item.id)"
                                @click="store.toggleIsActive(item)"
                                data-testid="themes-table-action-deactivate"
                                v-tooltip.top="'Deactivate Module'"
                                label="Deactivate"
                        />

                        <Button v-if="!item.is_active && store.hasPermission('can-activate-theme')"
                                class="mr-2 p-button-sm"
                                :loading="store.active_action.includes('activate_'+item.id)"
                                @click="store.toggleIsActive(item)"
                                data-testid="themes-table-action-activate"
                                v-tooltip.top="'Activate Module'"
                                label="Activate"
                        />

                        <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && item.is_default"
                                v-tooltip.top="'This theme is marked as default'"
                                icon="pi pi-check"
                                data-testid="themes-table-action-is_default_marked"
                                class="mr-2 p-button-warning p-button-sm"
                        />

                        <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && !item.is_default"
                                class="mr-2 p-button-sm"
                                :loading="store.active_action.includes('make_default_'+item.id)"
                                v-tooltip.top="'Mark this theme as Default'"
                                data-testid="themes-table-action-mark_default"
                                @click="store.makeDefault(item)"
                                label="Make Default"
                        />

                        <Button class="mr-2 p-button-info p-button-sm"
                                data-testid="modules-table-action-install-update"
                                :loading="store.active_action.includes('publish_assets_'+item.id)"
                                @click="store.publishAssets(item)"
                                icon="pi pi-arrow-up"
                                v-tooltip.top="'Publish Assets'"
                                v-if="item.is_active && store.hasPermission('can-publish-assets-of-theme')"
                        />

                        <SplitButton label="Actions"
                                     v-if="item.is_active && store.hasPermission('can-deactivate-theme')"
                                     v-tooltip.top="'Actions'"
                                     class="mr-1"
                                     data-testid="themes-table_action"
                                     :model="actionItems(item)" />

                        <Button v-if="item.is_active && store.hasPermission('can-import-sample-data-in-theme')"
                                v-tooltip.top="'Import Sample Data'"
                                class="mr-2 p-button-sm"
                                :loading="store.active_action.includes('import_sample_data_'+item.id)"
                                icon="pi pi-database"
                                data-testid="themes-table-action-import_sample_data"
                                @click="importSampleDataModal(item)"
                        />

                        <Button class="mr-2 p-button-danger p-button-sm"
                                v-if="!item.deleted_at && store.hasPermission('can-update-theme')"
                                @click="store.confirmDeleteItem(item)"
                                data-testid="themes-table-action-delete"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash" />

                        <Button class="p-button-sm ml-2"
                                icon="pi pi-eye"
                                v-tooltip.top=" 'View' "
                                @click="store.toView(item)"
                                v-if="item.is_active && store.hasPermission('can-read-theme')"
                        />
                    </div>
                </div>
            </div>
            <Divider />
        </div>

        <!--paginator-->
        <Paginator v-model:first="store.firstElement"
                   :rows="store.query.rows"
                   :totalRecords="store.stats.all"
                   @page="store.paginate($event)"
                   data-testid="themes-list-pagination"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->

        <ConfirmDialog group="templating" class="is-small"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 text-sm">{{ slotProps.message.message }}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>
</template>
