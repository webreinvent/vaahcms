<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useModuleStore } from '../../../stores/store-modules'
import { useConfirm } from "primevue/useconfirm";
import {ref} from "vue";

const store = useModuleStore();
const useVaah = vaah();
const confirm = useConfirm();
const menu = ref();


const importSampleDataModal = (item) => {
    confirm.require({
        message: 'This will import sample/dummy data of the ' +
            'module <b>' + item.name + '</b>. ' +
            'This action cannot be undone.',
        header: 'Importing Sample Data',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
            store.active_action.push('import_sample_data_'+item.id);
            store.itemAction('import_sample_data', item);
        },
    });
}

const toggle = (event,slug) => {
    menu.value[slug].toggle(event);
};

const confirmRefresh = (item) =>
{
    confirm.require({
        header: 'Refresh Migrations',
        message: 'Are you sure you want to <b>Refresh</b> Migrations? ' +
            'This action will <b>rollback</b> all the migrations and ' +
            'then <b>re-run</b> the migrations of this module.',
        icon: 'pi pi-info-circle',
        acceptClass: 'p-button-danger',
        accept: () => {
            store.refreshMigrations(item);
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
                confirmRefresh(item);
            }
        },
    ];
    return list;
}

</script>

<template>
    <div v-if="store.list">
        <Divider class="mt-2"/>
        <!--table-->
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

                               <span class="p-inputgroup mr-2 w-auto">
                                    <Button v-show="item.is_active
                                            && store.hasPermission('can-deactivate-module')"
                                            :data-testid="'module-deactivate-'+item.slug"
                                            class="p-button-sm bg-yellow-400 text-color"
                                            label="Deactivate"
                                            :loading="store.active_action.includes('deactivate_'+item.id)"
                                            v-tooltip.top="'Deactivate Module'"
                                            @click="store.toggleIsActive(item)"
                                    />
                                    <Button v-show="item.is_active && item.is_migratable
                                             && store.hasPermission('can-activate-module')"
                                            class="p-button-sm bg-yellow-400 text-color"
                                            :data-testid="'module-action-'+item.slug"
                                            @click="$event => toggle($event,index)"
                                            icon="pi pi-arrow-down"
                                            aria-haspopup="true"
                                            :aria-controls="'overlay_tmenu_'+item.slug"
                                            v-tooltip.top="'Actions'"
                                    />
                                    <TieredMenu ref="menu" :id="'overlay_tmenu_'+item.slug"
                                                :model="actionItems(item)" popup />
                               </span>

                    <Button v-if="!item.is_active && store.hasPermission('can-activate-module')"
                            :data-testid="'module-activate-'+item.slug"
                            v-tooltip.top="'Activate Module'"
                            label="Activate"
                            class="mr-2 p-button-sm"
                            :loading="store.active_action.includes('activate_'+item.id)"
                            @click="store.toggleIsActive(item)"
                    />

                    <Button v-if="item.is_active && store.hasPermission('can-publish-assets-of-module')"
                            class="mr-2 p-button-info p-button-sm"
                            :data-testid="'module-publish-assets-'+item.slug"
                            :loading="store.active_action.includes('publish_assets_'+item.id)"
                            @click="store.publishAssets(item)"
                            icon="pi pi-arrow-up"
                            v-tooltip.top="'Publish Assets'"
                    />

                    <Button v-if="item.is_active && item.is_sample_data_available
                                 && store.hasPermission('can-import-sample-data-in-module')"
                            :data-testid="'module-import-sample-'+item.slug"
                            size="is-small mr-2"
                            icon="pi pi-database"
                            class="p-button-sm mr-2"
                            v-tooltip.top="'Import Sample Data'"
                            :loading="store.active_action.includes('import_sample_data_'+item.id)"
                            @click="importSampleDataModal(item)"
                    />

                    <Button class="p-button-info p-button-sm mr-2"
                            label="Update"
                            :data-testid="'module-update-'+item.slug"
                            data-testid="modules-table-action-install-update"
                            icon="cloud-download-alt"
                            @click="store.confirmUpdate(item)"
                            v-tooltip.top="'Update Module'"
                            v-if="item.is_update_available && store.hasPermission('can-update-module')"
                    />

                    <Button class="p-button-sm mr-2"
                            icon="pi pi-eye"
                            :data-testid="'module-view-'+item.slug"
                            v-tooltip.top=" 'View' "
                            @click="store.toView(item)"
                            v-if="store.hasPermission('can-read-module')"
                    />

                    <Button class="p-button-danger p-button-sm"
                            :data-testid="'module-trash-'+item.slug"
                            v-if="!item.deleted_at && store.hasPermission('can-delete-module')"
                            @click="store.confirmDeleteItem(item)"
                            v-tooltip.top="'Trash'"
                            icon="pi pi-trash"
                    />

                </div>
            </div>

            <Divider />
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
