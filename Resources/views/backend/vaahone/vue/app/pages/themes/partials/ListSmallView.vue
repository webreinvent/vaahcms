<script src="./ListSmallViewJs.js"></script>
<template>
    <div v-if="page.list">
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-theme') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 :hoverable="true"
                 :row-class="setRowClass">

            <template slot-scope="props">
                <b-table-column field="name" label="Theme">

                    <h3 class="title is-5 has-margin-bottom-10">{{ props.row.title }}</h3>

                    <div class="content">
                        <p>{{ props.row.excerpt }}</p>

                        <Tags :item="props.row"/>


                    </div>

                </b-table-column>


                <b-table-column width="100" field="actions" label="" numeric>




                    <b-field class="float-right" style="float: right;">

                        <p v-if="hasPermission('can-activate-theme') || hasPermission('can-deactivate-theme')" class="control">
                            <b-button v-if="props.row.is_active && hasPermission('can-deactivate-theme')"
                                      size="is-small"
                                      type="is-warning"
                                      @click="actions('deactivate', props.row)">
                                Deactivate
                            </b-button>

                            <b-button v-if="!props.row.is_active && hasPermission('can-activate-theme')" size="is-small"
                                      type="is-success"
                                      @click="actions('activate', props.row)">
                                Activate
                            </b-button>
                        </p>

                        <p v-if="hasPermission('can-activate-theme') && props.row.is_active"
                           class="control">

                            <b-tooltip label="This theme is marked as Default" v-if="props.row.is_default"
                                       type="is-dark">
                                <b-button
                                    size="is-small"
                                    icon-left="check"
                                    type="is-success">
                                </b-button>
                            </b-tooltip>

                            <b-tooltip label="Mark this theme as Default" v-else
                                       type="is-dark">
                                <b-button
                                    size="is-small"
                                    type="is-success"
                                    @click="actions('make_default', props.row)">
                                    Make Default
                                </b-button>
                            </b-tooltip>

                        </p>

                        <p class="control" v-if="props.row.is_active && props.row.is_sample_data_available
                         && hasPermission('can-import-sample-data-in-theme')">
                            <b-tooltip label="Import Sample Data" type="is-dark">
                                <b-button size="is-small"
                                          icon-left="database"
                                          @click="confirmDataImport(props.row)"
                                          type="is-warning">
                                </b-button>
                            </b-tooltip>
                        </p>

                        <p class="control" v-if="props.row.is_update_available && hasPermission('can-update-theme')">
                            <b-tooltip label="Download Updates" type="is-dark">
                                <b-button size="is-small"
                                          icon-left="cloud-download-alt"
                                          type="is-info"
                                          @click="confirmUpdate(props.row)">
                                    Update
                                </b-button>
                            </b-tooltip>
                        </p>

                        <p v-if="hasPermission('can-delete-theme')" class="control">
                            <b-tooltip label="Delete" type="is-dark">
                                <b-button size="is-small"
                                          icon-left="trash"
                                          @click="confirmDelete(props.row)"
                                          type="is-danger">
                                </b-button>
                            </b-tooltip>
                        </p>





                        <p v-if="hasPermission('can-read-theme')" class="control">
                            <b-tooltip label="View" type="is-dark">
                                <b-button size="is-small"
                                          @click="setActiveItem(props.row)"
                                          icon-left="chevron-right">
                                </b-button>
                            </b-tooltip>
                        </p>




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
