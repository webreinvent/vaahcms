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

                <b-table-column field="queue" label="Queue" v-slot="props">
                    {{ props.row.queue }}
                </b-table-column>

                <b-table-column field="connection" label="Connection" v-slot="props">
                    {{ props.row.connection }}
                </b-table-column>

                <b-table-column field="payload" label="Payload" width="100" v-slot="props">
                    <ButtonMeta dusk="action-view_payload" :value="props.row.payload"/>
                </b-table-column>

                <b-table-column field="exception" label="Exception" width="100" v-slot="props">
                    <ButtonMeta dusk="action-view_exception" :value="props.row.exception"/>
                </b-table-column>

                <b-table-column field="failed_at" label="Failed At" width="150" v-slot="props">
                    {{ props.row.failed_at }}
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

