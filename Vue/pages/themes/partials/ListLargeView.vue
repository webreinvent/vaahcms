<script src="./ListLargeViewJs.js"></script>
<template>
    <div v-if="page.list">
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-theme') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 :hoverable="true"
                 :row-class="setRowClass">

            <template>
                <b-table-column v-slot="props"  field="name" label="Theme">

                    <h3 class="title is-5 has-margin-bottom-10">
                        {{ props.row.title }}
                    </h3>

                    <div class="content">
                        <p>{{ props.row.excerpt }}</p>

                        <Tags :item="props.row"/>


                    </div>

                </b-table-column>


                <b-table-column v-slot="props"  width="100" field="actions"
                                label="" numeric>




                    <b-field class="float-right" style="float: right;">

                        <p v-if="hasPermission('can-activate-theme')
                        || hasPermission('can-deactivate-theme')"
                           class="control">
                            <b-button v-if="props.row.is_active
                            && hasPermission('can-deactivate-theme')"
                                      :loading="page.active_actions.includes('deactivate-'+props.row.id)"
                                      size="is-small"
                                      type="is-warning"
                                      @click="actions('deactivate', props.row)">
                                Deactivate
                            </b-button>

                            <b-button v-if="!props.row.is_active
                            && hasPermission('can-activate-theme')"
                                      :loading="page.active_actions.includes('activate-'+props.row.id)"
                                      size="is-small"
                                      type="is-success"
                                      @click="actions('activate', props.row)">
                                Activate
                            </b-button>

                        </p>

                        <b-tooltip label="Action" type="is-dark">
                            <p v-if="props.row.is_active && hasPermission('can-activate-theme')"
                               class="control">
                                <b-dropdown class="action-items" label="Action">
                                    <template #trigger>
                                        <b-button class="action-button" type="is-warning" icon-right="caret-down" />
                                    </template>

                                    <b-dropdown-item @click="actions('run_migrations', props.row)">Run Migrations</b-dropdown-item>
                                    <b-dropdown-item @click="actions('run_seeds', props.row)">Run Seeds</b-dropdown-item>
                                    <b-dropdown-item @click="confirmRefresh(props.row)">Refresh Migrations</b-dropdown-item>
                                </b-dropdown>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="Publish Assets" type="is-dark">
                            <p v-if="hasPermission('can-publish-assets-of-theme')"
                               class="control">
                                <b-button v-if="props.row.is_active"
                                          style="border-radius: 0px"
                                          :loading="page.active_actions.includes('publish_assets-'+props.row.id)"
                                          size="is-small"
                                          type="is-info"
                                          icon-left="upload"
                                          @click="actions('publish_assets', props.row)">
                                </b-button>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="This theme is marked as Default"
                                   v-if="props.row.is_default"
                                   type="is-dark">
                            <p v-if="hasPermission('can-activate-theme')
                            && props.row.is_active"
                               class="control">

                                    <b-button
                                        size="is-small"
                                        icon-left="check"
                                        type="is-success">
                                    </b-button>

                            </p>
                        </b-tooltip>

                        <b-tooltip label="Mark this theme as Default"
                                   v-else type="is-dark">
                            <p v-if="hasPermission('can-activate-theme')
                            && props.row.is_active"
                               class="control">

                                <b-button
                                        size="is-small"
                                        type="is-success"
                                        @click="actions('make_default', props.row)">
                                    Make Default
                                </b-button>

                            </p>
                        </b-tooltip>


                        <b-tooltip v-if="props.row.is_active && props.row.is_sample_data_available
                                    && hasPermission('can-import-sample-data-in-theme')"
                                   label="Import Sample Data" type="is-dark">
                            <p class="control" >

                                <b-button size="is-small"
                                          :loading="page.active_actions.includes('import_sample_data-'+props.row.id)"
                                          icon-left="database"
                                          @click="confirmDataImport(props.row)"
                                          type="is-warning">
                                </b-button>

                            </p>
                        </b-tooltip>

                        <b-tooltip  v-if="props.row.is_update_available
                        && hasPermission('can-update-theme')"
                                    label="Download Updates" type="is-dark">
                            <p class="control">

                                <b-button size="is-small"
                                          icon-left="cloud-download-alt"
                                          type="is-info"
                                          @click="confirmUpdate(props.row)">
                                    Update
                                </b-button>

                            </p>
                        </b-tooltip>

                        <b-tooltip v-if="hasPermission('can-delete-theme')"
                                   label="Delete" type="is-dark">
                            <p  class="control">

                                <b-button size="is-small"
                                          :loading="page.active_actions.includes('delete-'+props.row.id)"
                                          icon-left="trash"
                                          @click="confirmDelete(props.row)"
                                          type="is-danger">
                                </b-button>

                            </p>
                        </b-tooltip>


                        <b-tooltip v-if="hasPermission('can-read-theme')"
                                   label="View" type="is-dark">
                            <p  class="control">

                                <b-button size="is-small"
                                          @click="setActiveItem(props.row)"
                                          icon-left="chevron-right">
                                </b-button>

                            </p>
                        </b-tooltip>

                    </b-field>


                </b-table-column>

            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>

        </b-table>
    </div>
</template>
<style scoped>
.action-items {
    text-align: left!important;
}
.action-button {
    height: 1.6rem;
    border-radius: 0px;
}
</style>
