<script src="./ListSmallViewJs.js"></script>
<template>
    <div v-if="page.list">
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-permissions') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 :hoverable="true"
                 :row-class="setRowClass"
        >

            <template slot-scope="props">
                <b-table-column field="name" label="Module">

                    <h3 class="title is-5 has-margin-bottom-10">{{ props.row.title }}</h3>

                    <div class="content">
                        <p>{{ props.row.excerpt }}</p>

                        <Tags :item="props.row"/>


                    </div>

                </b-table-column>


                <b-table-column width="100" field="actions" label="" numeric>




                    <b-field>

                        <p class="control">
                            <b-button v-if='props.row.is_active'
                                      size="is-small"
                                      type="is-warning"
                                      @click="actions('deactivate', props.row)">
                                Deactivate
                            </b-button>

                            <b-button v-else size="is-small"
                                      type="is-success"
                                      @click="actions('activate', props.row)">
                                Activate
                            </b-button>
                        </p>
                        <p class="control" v-if="props.row.is_active && props.row.is_sample_data_available">
                            <b-tooltip label="Import Sample Data" type="is-dark">
                                <b-button size="is-small"
                                          icon-left="database"
                                          @click="confirmDataImport(props.row)"
                                          type="is-warning">
                                </b-button>
                            </b-tooltip>
                        </p>

                        <p class="control">
                            <b-tooltip label="Delete" type="is-dark">
                                <b-button size="is-small"
                                          icon-left="trash"
                                          @click="confirmDelete(props.row)"
                                          type="is-danger">
                                </b-button>
                            </b-tooltip>
                        </p>

                        <p class="control">
                            <b-tooltip label="View" type="is-dark">
                                <b-button size="is-small"
                                          v-if="props.row.is_update_available"
                                          type="is-info"
                                          @click="installUpdate(props.row)">
                                    Update
                                </b-button>
                            </b-tooltip>
                        </p>



                        <p class="control">
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
