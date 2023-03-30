<script src="./ListLargeViewJs.js"></script>
<template>
    <div v-if="page.list">
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-module') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 :hoverable="true"
                 :row-class="setRowClass">

            <template>
                <b-table-column v-slot="props"  field="name" label="Module">

                    <h3 class="title is-5 has-margin-bottom-10">{{ props.row.title }}</h3>

                    <div class="content">
                        <p>{{ props.row.excerpt }}</p>

                        <Tags :item="props.row"/>


                    </div>

                </b-table-column>


                <b-table-column v-slot="props"  width="100" field="actions" label="" numeric>




                    <b-field class="float-right" style="float: right;">

                        <p v-if="hasPermission('can-activate-module')
                        || hasPermission('can-deactivate-module')" class="control">
                            <b-button v-if="props.row.is_active && hasPermission('can-deactivate-module')"
                                      :loading="page.active_actions.includes('deactivate-'+props.row.id)"
                                      size="is-small"
                                      type="is-warning"
                                      @click="actions('deactivate', props.row)">
                                Deactivate
                            </b-button>

                            <b-button v-if="!props.row.is_active && hasPermission('can-activate-module')"
                                      :loading="page.active_actions.includes('activate-'+props.row.id)"
                                      size="is-small"
                                      type="is-success"
                                      @click="actions('activate', props.row)">
                                Activate
                            </b-button>
                        </p>

                        <b-tooltip label="Publish Assets" type="is-dark">
                            <p v-if="hasPermission('can-publish-assets-of-module')"
                               class="control">
                                <b-button v-if="props.row.is_active"
                                          :loading="page.active_actions.includes('publish_assets-'+props.row.id)"
                                          size="is-small"
                                          type="is-info"
                                          icon-left="upload"
                                          @click="actions('publish_assets', props.row)">
                                </b-button>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="Run Migration" type="is-dark">
                            <p v-if="hasPermission('can-publish-assets-of-module')"
                               class="control">
                                <b-button v-if="props.row.is_active"
                                          :loading="page.active_actions.includes('run_migration-'+props.row.id)"
                                          size="is-small"
                                          type="is-info"
                                          icon-left="database"
                                          @click="actions('run_migration', props.row)">
                                </b-button>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="Import Sample Data" type="is-dark">
                            <p class="control" v-if="props.row.is_active && props.row.is_sample_data_available
                            && hasPermission('can-import-sample-data-in-module')">
                                <b-button size="is-small"
                                          :loading="page.active_actions.includes('import_sample_data-'+props.row.id)"
                                          icon-left="database"
                                          @click="confirmDataImport(props.row)"
                                          type="is-warning">
                                </b-button>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="Download Updates" type="is-dark">
                            <p class="control" v-if="props.row.is_update_available && hasPermission('can-update-module')">
                                <b-button size="is-small"
                                          icon-left="cloud-download-alt"
                                          type="is-info"
                                          @click="confirmUpdate(props.row)">
                                    Update
                                </b-button>
                            </p>
                        </b-tooltip>

                        <b-tooltip label="Delete" type="is-dark">
                            <p v-if="hasPermission('can-delete-module')" class="control">
                                <b-button size="is-small"
                                          :loading="page.active_actions.includes('delete-'+props.row.id)"
                                          icon-left="trash"
                                          @click="confirmDelete(props.row)"
                                          type="is-danger">
                                </b-button>
                            </p>
                        </b-tooltip>




                        <b-tooltip label="View" type="is-dark">
                            <p v-if="hasPermission('can-read-module')" class="control">
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
