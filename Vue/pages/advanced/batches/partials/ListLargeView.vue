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
                <b-table-column field="id" label="ID" v-slot="props">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="name" label="Name" v-slot="props">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="total_jobs" v-slot="props" cell-class="is-vcentered" width="20%" >
                    <span v-if="props.row.total_jobs > 0">
                        <b-progress size="is-small" type="is-success" :value="(props.row.total_jobs - props.row.pending_jobs - props.row.failed_jobs) * 100 / props.row.total_jobs" show-value></b-progress>
                    </span>
                    <span v-else>
                        <b-progress size="is-small" type="is-success" :value="0" show-value></b-progress>
                    </span>
                </b-table-column>

                <!--<b-table-column field="pending_jobs" label="Pending Jobs" v-slot="props">
                    {{ props.row.pending_jobs }}
                </b-table-column>

                <b-table-column field="failed_jobs" label="Failed Jobs" v-slot="props">
                    {{ props.row.failed_jobs }}
                </b-table-column>-->

                <b-table-column field="stats" label="Stats" v-slot="props">
                    <b-button size="is-small"
                              @click="showModal(props.row)"
                              :type="type"
                              rounded
                              icon-left="eye">
                        View
                    </b-button>
                </b-table-column>

                <b-table-column field="failed_job_ids" label="Failed Job Ids" v-slot="props">

                    <ButtonMeta :type="{'is-danger': props.row.count_failed_jobs > 0}"
                                :label="props.row.count_failed_jobs"
                                :value="props.row.failed_job_ids"/>
                </b-table-column>

                <b-table-column field="options" label="Options" v-slot="props">
                    <ButtonMeta :value="props.row.options"/>
                </b-table-column>

                <b-table-column field="cancelled_at" label="Cancelled At" v-slot="props">
                    {{ props.row.cancelled_at }}
                </b-table-column>

                <b-table-column field="created_at" label="Created At" v-slot="props">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column field="finished_at" label="Finished At" v-slot="props">
                    {{ props.row.finished_at }}
                </b-table-column>

                <b-table-column field="actions" label=""
                                v-slot="props"
                                width="40">

                    <b-tooltip label="Delete" type="is-dark">
                        <b-button size="is-small"
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

