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
                <b-table-column field="id" label="ID" width="8%" v-slot="props">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="queue" label="Queue" v-slot="props">
                    {{ props.row.queue }}
                </b-table-column>

                <b-table-column field="payload" label="Payload" width="10%" v-slot="props">
                    <ButtonMeta :value="props.row.payload"/>
                </b-table-column>


                <b-table-column field="attempts" label="Attempts" width="10%" v-slot="props">
                    {{ props.row.attempts }}
                </b-table-column>

                <b-table-column field="reserved_at" label="Reserved At" width="15%" v-slot="props">
                    {{ props.row.reserved_at }}
                </b-table-column>

                <b-table-column field="available_at" label="Available At" width="15%" v-slot="props">
                    {{ props.row.available_at }}
                </b-table-column>


                <b-table-column field="created_at" label="Created At" width="15%" v-slot="props">
                    {{ props.row.created_at }}
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

