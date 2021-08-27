<script src="./ListLargeViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 checkable
                 :hoverable="true"
                 :row-class="setRowClass"
        >

            <template >
                <b-table-column field="id" label="ID" v-slot="props">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="name" label="Name" v-slot="props">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="slug" label="Slug" v-slot="props">
                    <vh-copy class="text-copyable"
                             :data="props.row.slug"
                             :label="props.row.slug"
                             @copied="copiedData"
                    >
                    </vh-copy>
                </b-table-column>

                <b-table-column field="type" label="Type" v-slot="props">
                    {{ props.row.type }}
                </b-table-column>

                <b-table-column v-slot="props" width="10%" field="is_active" label="Is Active">
                    <b-tooltip label="Change Status" type="is-dark">
                        <b-button v-if="props.row.is_active === 1" rounded size="is-small"
                                  type="is-success" :disabled="props.row.deleted_at ? true : false" @click="changeStatus(props.row.id)">
                            Yes
                        </b-button>
                        <b-button v-else rounded size="is-small" type="is-danger"
                                  :disabled="props.row.deleted_at ? true : false" @click="changeStatus(props.row.id)">
                            No
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column field="updated_at" width="15%" label="Updated At" v-slot="props">
                    {{ $vaah.fromNow(props.row.updated_at) }}
                </b-table-column>


                <b-table-column field="actions" label=""
                                v-slot="props"
                                width="40">

                    <b-tooltip label="View" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row)"
                                  icon-left="chevron-right">
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

