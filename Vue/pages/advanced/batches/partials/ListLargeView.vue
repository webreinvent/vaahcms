<script src="./ListLargeViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 checkable
                 :hoverable="true"
                 :row-class="setRowClass">

            <template >
                <b-table-column field="id" label="ID" width="100" v-slot="props">
                    <b-tooltip label="Copy Id" type="is-dark">
                        <vh-copy class="text-copyable"
                                 dusk="action-click_to_copy"
                                 :data="props.row.id"
                                 :label="props.row.id.toString()"
                                 @copied="copiedData"
                        >
                        </vh-copy>
                    </b-tooltip>
                </b-table-column>

                <b-table-column field="name" label="Name" v-slot="props" >
                    {{ props.row.name }}



                    <b-progress v-if="props.row.total_jobs > 0" size="is-small" format="percent" class="mt-3">
                        <template #bar>
                            <b-progress-bar :value="(props.row.total_jobs - props.row.pending_jobs
                                    - props.row.failed_jobs) * 100 / props.row.total_jobs" type="is-success" show-value></b-progress-bar>
                            <b-progress-bar :value="props.row.failed_jobs * 100 / props.row.total_jobs" type="is-danger" show-value></b-progress-bar>
                                <b-progress-bar :value="props.row.pending_jobs * 100 / props.row.total_jobs" type="is-light" show-value></b-progress-bar>
                        </template>
                    </b-progress>

                    <b-progress v-else size="is-small" type="is-success" format="percent"
                                :value="0" show-value></b-progress>
                </b-table-column>

                <b-table-column field="detail" label="Detail" width="100" v-slot="props">
                    <b-button size="is-small"
                              dusk="action-view_detail"
                              @click="showModal(props.row)"
                              type="is-default"
                              rounded
                              icon-left="eye">
                        View
                    </b-button>
                </b-table-column>

                <b-table-column field="failed_job_ids" label="Failed Job Ids" width="120" v-slot="props">

                    <ButtonMeta :type="{'is-danger': props.row.count_failed_jobs > 0}"
                                dusk="action-view_failed_jobs"
                                :label="props.row.count_failed_jobs"
                                :value="props.row.failed_job_ids"/>
                </b-table-column>

                <b-table-column field="cancelled_at" label="Cancelled At" width="100" v-slot="props">
                    {{ props.row.cancelled_at }}
                </b-table-column>

                <b-table-column field="created_at" label="Created At" width="100" v-slot="props">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column field="finished_at" label="Finished At" width="100" v-slot="props">
                    {{ props.row.finished_at }}
                </b-table-column>

                <b-table-column field="actions" label=""
                                v-slot="props"
                                width="40">

                    <b-tooltip label="Delete" type="is-dark">
                        <b-button size="is-small"
                                  dusk="action-delete_item"
                                  @click="deleteItem(props.row)"
                                  icon-left="trash">
                        </b-button>
                    </b-tooltip>

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

