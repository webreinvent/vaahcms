<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useModuleStore } from '../../../stores/store-modules'
import { useConfirm } from "openvue/useconfirm";
import {ref} from "vue";
import { useRootStore } from "../../../stores/root";
const root = useRootStore();
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
        acceptProps: { class: 'p-button-danger' },
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
        <!--table-->
        <!-- UT-26 (M6-T4a Batch 5) — the metadata tags used to sit in the
             opposite grid column from the module name and were pushed to the
             far right, so they floated ~1400px away from the thing they
             describe. The name column is now the wide one and the metadata
             sits directly under the description; only the actions stay
             right-aligned. -->
        <div class="grid" v-for="(item,index) in store.list">
            <div class="col-12 md:col-7">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="font-semibold vc-text-16">{{ item.name }}</h2>
                    <Tag value="Default" v-if="item.is_default" severity="success" rounded />
                </div>
                <p class="vc-text-14 vc-muted mt-1">{{ item.description}}</p>

                <div class="flex flex-wrap gap-2 mt-2">
                    <Tag class="vc-chip font-semibold">{{store.assets.language_strings.name}}: {{ item.name }}</Tag>
                    <Tag class="vc-chip font-semibold">{{store.assets.language_strings.version}}: {{ item.version }}</Tag>
                    <Tag class="vc-chip font-semibold">{{store.assets.language_strings.developed_by}}: {{ item.author_name }}</Tag>
                </div>
            </div>

            <div class="col-12 md:col-5">
                <div class="flex flex-wrap justify-content-end gap-2">

                               <InputGroup class="w-auto">
                                    <!-- UT-23 (M6-T4a Batch 5) — `bg-yellow-400 text-color`
                                         was a hard-coded Tailwind pair: the label was
                                         #fafafa on #facc15 in dark mode (1.7:1 — an AA
                                         failure). The v4 `severity="warn"` token pair
                                         (#451a03 on #fbbf24) is scheme-aware. -->
                                    <Button size="small" severity="warn" v-show="item.is_active && store.hasPermission('can-deactivate-module')" :data-testid="'module-deactivate-'+item.slug" :label=store.assets.language_strings.deactivate_button :loading="store.active_action.includes('deactivate_'+item.id)" v-tooltip.top="store.assets.language_strings.toolkit_text_deactivate_module" @click="store.toggleIsActive(item)" />
                                    <Button size="small" severity="warn" v-show="item.is_active && item.is_migratable && store.hasPermission('can-activate-module')" :data-testid="'module-action-'+item.slug" @click="$event => toggle($event,index)"
                                            icon="pi pi-arrow-down"
                                            aria-label="Module actions"
                                            aria-haspopup="true"
                                            :aria-controls="'overlay_tmenu_'+item.slug"
                                            v-tooltip.top="store.assets.language_strings.toolkit_text_actions"
                                    />
                                    <TieredMenu ref="menu" :id="'overlay_tmenu_'+item.slug"
                                                :model="actionItems(item)" popup />
                               </InputGroup>

                    <Button size="small" v-if="!item.is_active && store.hasPermission('can-activate-module')" :data-testid="'module-activate-'+item.slug" v-tooltip.top="store.assets.language_strings.toolkit_text_activate_module" :label=store.assets.language_strings.activate_button :loading="store.active_action.includes('activate_'+item.id)" @click="store.toggleIsActive(item)" />

                    <Button size="small" severity="info" v-if="item.is_active && store.hasPermission('can-publish-assets-of-module')" :data-testid="'module-publish-assets-'+item.slug" :loading="store.active_action.includes('publish_assets_'+item.id)" @click="store.publishAssets(item)" icon="pi pi-arrow-up" aria-label="Publish module assets" v-tooltip.top="store.assets.language_strings.toolkit_text_publish_assets" />

                    <!-- UT-24 (M6-T4a Batch 5) — `size="vc-dense"` is not a v4
                         size (v4 ships small / large / default), so this button
                         silently fell through to the 36px default height while
                         its neighbours were 27px. -->
                    <Button size="small" v-if="item.is_active && item.is_sample_data_available && store.hasPermission('can-import-sample-data-in-module')" :data-testid="'module-import-sample-'+item.slug" icon="pi pi-database" aria-label="Import sample data" v-tooltip.top="store.assets.language_strings.toolkit_text_import_sample_data" :loading="store.active_action.includes('import_sample_data_'+item.id)" @click="importSampleDataModal(item)" />

                    <Button size="small" severity="info" :label=store.assets.language_strings.update_button :data-testid="'module-update-'+item.slug" data-testid="modules-table-action-install-update" icon="pi pi-download" @click="store.confirmUpdate(item)" v-tooltip.top="store.assets.language_strings.toolkit_text_update_module" v-if="item.is_update_available && store.hasPermission('can-update-module')" />

                    <Button size="small" icon="pi pi-eye" aria-label="View module" :data-testid="'module-view-'+item.slug" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" @click="store.toView(item)" v-if="store.hasPermission('can-read-module')" />

                    <Button size="small" severity="danger" text :data-testid="'module-trash-'+item.slug" v-if="!item.deleted_at && store.hasPermission('can-delete-module')" @click="store.confirmDeleteItem(item)" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash" aria-label="Move module to trash" icon="pi pi-trash" />

                </div>
            </div>

            <Divider />
        </div>
        <!--/table-->

        <!-- M7-T3 (F26) — the empty state says what to do next
             (DESIGN-SYSTEM §8): a muted line + one primary action. The
             modules list can be empty because the filter matched nothing,
             or because nothing is installed yet — the Install CTA covers
             the latter; the toolbar's reset covers the former. -->
        <div v-if="!store.list || store.list.length === 0" class="vaah-empty" data-testid="modules-list_empty">
            <i class="vaah-empty-icon pi pi-cog" aria-hidden="true"></i>
            <p class="vaah-empty-copy">No modules match your search — reset the filters, or install one.</p>
            <Button class="vaah-btn-primary" :label="store.assets.language_strings.install_button" icon="pi pi-plus" @click="store.setSixColumns()" data-testid="modules-list_empty_install" v-if="store.hasPermission('can-install-module')" />
        </div>

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                    :rows="store.query.rows"
                   :totalRecords="store.stats.all"
                   @page="store.paginate($event)"
                   :rows-per-page-options="store.rows_per_page"
        />
        <!--/paginator-->
        <ConfirmDialog group="templating" class="vc-dense"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 vc-text-14">{{slotProps.message.message}}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>

</template>
