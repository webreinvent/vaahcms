<script src="./ListLargeViewJs.js"></script>
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


                <b-table-column width="300" field="actions" label="" numeric>

                    <div class="buttons float-right">

                        <b-tooltip label="View" type="is-dark">
                            <b-button size="is-small"
                                      class="has-margin-left-5"
                                      type="is-success"
                                      @click="setActiveItem(props.row)">
                                Activate
                            </b-button>
                        </b-tooltip>

                        <b-tooltip label="View" type="is-dark">
                            <b-button size="is-small"
                                      class="has-margin-left-5"
                                      type="is-warning"
                                      @click="setActiveItem(props.row)">
                                Deactivate
                            </b-button>
                        </b-tooltip>

                        <b-tooltip label="View" type="is-dark">
                            <b-button size="is-small"
                                      class="has-margin-left-5"
                                      type="is-info"
                                      @click="setActiveItem(props.row)">
                                Update
                            </b-button>
                        </b-tooltip>

                        <b-tooltip label="Delete" type="is-dark">
                            <b-button size="is-small" class="has-margin-left-5"
                            type="is-danger">
                                Delete
                            </b-button>

                        </b-tooltip>

                        <b-tooltip label="View" type="is-dark">
                            <b-button size="is-small" class="has-margin-left-5"
                                      @click="setActiveItem(props.row)"
                                      icon-left="chevron-right">
                            </b-button>

                        </b-tooltip>

                    </div>


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

