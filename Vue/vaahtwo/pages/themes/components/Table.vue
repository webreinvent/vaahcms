<script setup>

import { ref } from "vue";
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'
import { useConfirm } from "openvue/useconfirm";
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
        // M6-T3 (F22) — F22 Scenario 4: the removed v3 accept-button
        // class-string prop converts to the v4 `severity` prop (the class
        // string is inert in the v4 engine; `severity` drives the danger
        // button class + tokens in both light and dark schemes). This
        // object stays the F12-approved shape — the removed prop is never
        // reintroduced.
        acceptProps: { severity: 'danger' },
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
            <div class="col-12 md:col-7">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="font-semibold vc-text-16">{{ item.name }}</h2>
                    <Tag v-if="item.is_default" value="Default" severity="success" rounded></Tag>
                </div>
                <p class="vc-text-14 vc-muted mt-1">{{ item.description }}</p>

                <!-- UT-22 (M6-T4a Batch 5) — all three metadata tags were bound
                     to `item.name`, so the version chip read
                     "Version : BulmaBlogTheme" and the author chip read
                     "Developed by : BulmaBlogTheme". They now bind the fields
                     they name (the Modules list already did).
                     UT-26 — the metadata now sits directly under the name
                     instead of floating ~1400px away in the opposite column. -->
                <div class="flex flex-wrap gap-2 mt-2">
                    <Tag class="vc-chip font-semibold"
                         :value="store.assets.language_strings.themes_name + ' : ' + item.name"
                    />

                    <Tag class="vc-chip font-semibold"
                         :value="store.assets.language_strings.themes_version + ' : ' + item.version"
                    />

                    <Tag class="vc-chip font-semibold"
                         :value="store.assets.language_strings.themes_developed_by + ' : ' + item.author_name"
                    />
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
                            <Button size="small" severity="warn" v-show="item.is_active && store.hasPermission('can-deactivate-theme')" :data-testid="'themes-deactivate-'+item.slug" label="Deactivate" :loading="store.active_action.includes('deactivate_'+item.id)" v-tooltip.top="store.assets.language_strings.toolkit_text_deactivate_theme" @click="store.toggleIsActive(item)" />
                            <Button size="small" severity="warn" v-show="item.is_active && item.is_migratable && store.hasPermission('can-activate-theme')" :data-testid="'theme-action-'+item.slug" @click="$event => toggle($event,index)"
                                    icon="pi pi-arrow-down"
                                    aria-label="Theme actions"
                                    aria-haspopup="true" :aria-controls="'overlay_tmenu_'+item.slug"
                                    v-tooltip.top="store.assets.language_strings.themes_toolkit_text_actions"
                            />
                            <TieredMenu ref="menu" :id="'overlay_tmenu_'+item.slug"
                                        :model="actionItems(item)" popup />
                       </InputGroup>

                    <Button size="small" v-if="!item.is_active && store.hasPermission('can-activate-theme')" :loading="store.active_action.includes('activate_'+item.id)" @click="store.toggleIsActive(item)" :data-testid="'themes-activate-'+item.slug" v-tooltip.top="store.assets.language_strings.toolkit_text_activate_theme" :label="store.assets.language_strings.themes_activate_button" />

                    <!-- UT-23 (M6-T4a Batch 5) — `p-button-warning` is the v3
                         class name; v4 spells the severity `warn`. The old class
                         matched nothing, so the "this is the default theme"
                         marker rendered as a plain grey button. -->
                    <Button size="small" severity="warn" v-if="store.hasPermission('can-activate-theme') && item.is_active && item.is_default" v-tooltip.top="'This theme is marked as default'" icon="pi pi-check" aria-label="This theme is marked as default" :data-testid="'themes-is-marked-default-'+item.slug" />

                    <Button size="small" v-if="store.hasPermission('can-activate-theme') && item.is_active && !item.is_default" :loading="store.active_action.includes('make_default_'+item.id)" v-tooltip.top="store.assets.language_strings.toolkit_text_this_theme_is_marked_as_default" :data-testid="'themes-mark-default-'+item.slug" @click="store.makeDefault(item)" label="Make Default" />

                    <Button size="small" severity="info" :data-testid="'themes-update-'+item.slug" :loading="store.active_action.includes('publish_assets_'+item.id)" @click="store.publishAssets(item)" icon="pi pi-arrow-up" aria-label="Publish theme assets" v-tooltip.top="store.assets.language_strings.themes_toolkit_text_publish_assets" v-if="item.is_active && store.hasPermission('can-publish-assets-of-theme')" />

                    <Button size="small" v-if="item.is_active && item.is_sample_data_available && store.hasPermission('can-import-sample-data-in-theme')" v-tooltip.top="store.assets.language_strings.themes_toolkit_text_import_sample_data" :loading="store.active_action.includes('import_sample_data_'+item.id)" icon="pi pi-database" aria-label="Import sample data" :data-testid="'themes-import-sample-'+item.slug" @click="importSampleDataModal(item)" />

                    <Button size="small" severity="info" :label="store.assets.language_strings.update_button" :data-testid="'module-update-'+item.slug" data-testid="modules-table-action-install-update" icon="pi pi-download" @click="store.confirmUpdate(item)" v-tooltip.top="store.assets.language_strings.toolkit_text_update_module" v-if="item.is_update_available && store.hasPermission('can-update-module')" />

                    <Button size="small" icon="pi pi-eye" aria-label="View theme" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" @click="store.toView(item)" v-if="store.hasPermission('can-read-theme')" />

                    <Button size="small" severity="danger" text v-if="!item.deleted_at && store.hasPermission('can-update-theme')" @click="store.confirmDeleteItem(item)" data-testid="themes-table-action-delete" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash" aria-label="Move theme to trash" icon="pi pi-trash" />


                </div>
            </div>
            <Divider class="mt-2" />

        </div>

        <!-- M7-T3 (F26) — the empty state says what to do next
             (DESIGN-SYSTEM §8): a muted line + one primary action. The
             themes list can be empty because the filter matched nothing,
             or because nothing is installed yet — the Install CTA covers
             the latter; the toolbar's reset covers the former. -->
        <div v-if="!store.list || store.list.length === 0" class="vaah-empty" data-testid="themes-list_empty">
            <i class="vaah-empty-icon pi pi-palette" aria-hidden="true"></i>
            <p class="vaah-empty-copy">No themes match your search — reset the filters, or install one.</p>
            <Button class="vaah-btn-primary" :label="store.assets.language_strings.themes_install_button" icon="pi pi-plus" @click="store.setSixColumns()" data-testid="themes-list_empty_install" v-if="store.hasPermission('can-install-theme')" />
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

        <ConfirmDialog group="templating" class="vc-dense"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 vc-text-14">{{ slotProps.message.message }}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>
</template>
