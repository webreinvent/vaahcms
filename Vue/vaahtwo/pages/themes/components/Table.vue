<script setup>

import { ref } from "vue";
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'
import { useConfirm } from "primevue/useconfirm";
import { useRootStore } from "../../../stores/root";

const store = useThemeStore();
const root = useRootStore();
const useVaah = vaah();
const menu = ref();

const confirm = useConfirm();

const importSampleDataModal = (item) => {
    confirm.require({
        message: 'This will import sample/dummy data of ' +
            'the theme <b>' + item.name + '</b>.' +
            ' This action cannot be undone.',
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

const confirmRefresh = (item) => {
    confirm.require({
        header: 'Refresh Migrations',
        message: 'Are you sure you want to <b>Refresh</b> Migrations? ' +
            'This action will <b>rollback</b> all the migrations ' +
            'and then <b>re-run</b> the migrations of this theme.',
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
            label: store.assets.language_strings.actions_run_migrations,
            icon: 'pi pi-database',
            command: () => {
                store.runMigrations(item);
            }
        },
        {
            label: store.assets.language_strings.actions_run_seeds,
            icon: 'pi pi-server',
            command: () => {
                store.runSeeds(item);
            }
        },
        {
            label: store.assets.language_strings.actions_refresh_migrations,
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

    <div v-if="store.list && store.assets">
        <Divider class="mt-2"/>
        <div class="grid" v-for="(item, index) in store.list">
            <div class="col-12 md:col-5">
                <h5 class="font-semibold text-xl inline">{{ item.name }}</h5>
                <Tag v-if="item.is_default" value="Default" severity="success" class="ml-2" rounded></Tag>
                <p class="text-sm text-gray-600 mt-2">{{ item.description }}</p>
            </div>
            <div class="col-12 md:col-7">
                <div class="flex justify-content-end mb-3">
                    <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                         :value="store.assets.language_strings.themes_name + ' : ' + item.name"
                    />

                    <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                         :value="store.assets.language_strings.themes_version + ' : ' + item.name"
                    />

                    <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                         :value="store.assets.language_strings.themes_developed_by + ' : ' + item.name"
                    />
                </div>

                <div class="flex justify-content-end">

                         <span class="p-inputgroup mr-2 w-auto">
                            <Button v-show="item.is_active
                                    && store.hasPermission('can-deactivate-theme')"
                                    :data-testid="'themes-deactivate-'+item.slug"
                                    class="p-button-sm bg-yellow-400 text-color"
                                    label="Deactivate"
                                    :loading="store.active_action.includes('deactivate_'+item.id)"
                                    v-tooltip.top="store.assets.language_strings.toolkit_text_deactivate_theme"
                                    @click="store.toggleIsActive(item)"
                            />
                            <Button v-show="item.is_active && item.is_migratable
                                     && store.hasPermission('can-activate-theme')"
                                    class="p-button-sm bg-yellow-400 text-color"
                                    :data-testid="'theme-action-'+item.slug"
                                    @click="$event => toggle($event,index)"
                                    icon="pi pi-arrow-down"
                                    aria-haspopup="true" :aria-controls="'overlay_tmenu_'+item.slug"
                                    v-tooltip.top="store.assets.language_strings.themes_toolkit_text_actions"
                            />
                            <TieredMenu ref="menu" :id="'overlay_tmenu_'+item.slug"
                                        :model="actionItems(item)" popup />
                       </span>

                    <Button v-if="!item.is_active && store.hasPermission('can-activate-theme')"
                            class="mr-2 p-button-sm"
                            :loading="store.active_action.includes('activate_'+item.id)"
                            @click="store.toggleIsActive(item)"
                            :data-testid="'themes-activate-'+item.slug"
                            v-tooltip.top="store.assets.language_strings.toolkit_text_activate_theme"
                            :label="store.assets.language_strings.themes_activate_button"
                    />

                    <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && item.is_default"
                            v-tooltip.top="'This theme is marked as default'"
                            icon="pi pi-check"
                            :data-testid="'themes-is-marked-default-'+item.slug"
                            class="mr-2 p-button-warning p-button-sm"
                    />

                    <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && !item.is_default"
                            class="mr-2 p-button-sm"
                            :loading="store.active_action.includes('make_default_'+item.id)"
                            v-tooltip.top="store.assets.language_strings.toolkit_text_this_theme_is_marked_as_default"
                            :data-testid="'themes-mark-default-'+item.slug"
                            @click="store.makeDefault(item)"
                            label="Make Default"
                    />

                    <Button class="mr-2 p-button-info p-button-sm"
                            :data-testid="'themes-update-'+item.slug"
                            :loading="store.active_action.includes('publish_assets_'+item.id)"
                            @click="store.publishAssets(item)"
                            icon="pi pi-arrow-up"
                            v-tooltip.top="store.assets.language_strings.themes_toolkit_text_publish_assets"
                            v-if="item.is_active && store.hasPermission('can-publish-assets-of-theme')"
                    />

                    <Button v-if="item.is_active && item.is_sample_data_available
                        && store.hasPermission('can-import-sample-data-in-theme')"
                            v-tooltip.top="store.assets.language_strings.themes_toolkit_text_import_sample_data"
                            class="mr-2 p-button-sm"
                            :loading="store.active_action.includes('import_sample_data_'+item.id)"
                            icon="pi pi-database"
                            :data-testid="'themes-import-sample-'+item.slug"
                            @click="importSampleDataModal(item)"
                    />

                    <Button class="p-button-info p-button-sm mr-2"
                            :label="store.assets.language_strings.update_button"
                            :data-testid="'module-update-'+item.slug"
                            data-testid="modules-table-action-install-update"
                            icon="pi pi-download"
                            @click="store.confirmUpdate(item)"
                            v-tooltip.top="store.assets.language_strings.toolkit_text_update_module"
                            v-if="item.is_update_available && store.hasPermission('can-update-module')"
                    />

                    <Button class="p-button-sm mr-2"
                            icon="pi pi-eye"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                            @click="store.toView(item)"
                            v-if="store.hasPermission('can-read-theme')"
                    />

                    <Button class="p-button-danger p-button-sm"
                            v-if="!item.deleted_at && store.hasPermission('can-update-theme')"
                            @click="store.confirmDeleteItem(item)"
                            data-testid="themes-table-action-delete"
                            v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                            icon="pi pi-trash" />


                </div>
            </div>
            <Divider class="mt-2" />

        </div>

        <div v-if="!store.list || store.list.length === 0" class="text-center py-3">
            No records found.
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
