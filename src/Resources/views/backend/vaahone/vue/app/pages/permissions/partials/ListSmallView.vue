<script src="./ListSmallViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-permissions') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 :hoverable="true"
                 :row-class="setRowClass"
        >

            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="name" label="Name">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="slug" label="Slug">
                    <vh-copy class="text-copyable"
                             :data="props.row.slug"
                             :label="props.row.slug"
                             @copied="copiedData"
                    >
                    </vh-copy>
                </b-table-column>

                <b-table-column v-if="hasPermission('can-read-permissions') " field="count_roles" label="Roles" >
                    <b-tooltip label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRole(props.row)">
                            {{ props.row.count_roles }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-else field="count_roles" label="Roles" >
                    <b-tooltip label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" disabled>
                            {{ props.row.count_roles }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>


                <b-table-column v-if="hasPermission('can-read-permissions')"
                                field="actions" label=""
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
