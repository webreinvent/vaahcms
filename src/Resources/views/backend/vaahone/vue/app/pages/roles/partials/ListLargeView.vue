<script src="./ListLargeViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-roles') ? true : false"
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

                <b-table-column v-if="props.row.deleted_at || ( !hasPermission('can-manage-roles') && !hasPermission('can-update-roles'))" field="status" label="Is Active">

                    <b-button v-if="props.row.is_active === 1" disabled rounded size="is-small"
                           type="is-success">
                        Yes
                    </b-button>
                    <b-button v-else disabled rounded size="is-small" type="is-danger">
                        No
                    </b-button>

                </b-table-column>

                <b-table-column v-if="!props.row.deleted_at && ( hasPermission('can-manage-roles') || hasPermission('can-update-roles') )" field="status" label="Is Active">
                    <b-tooltip label="Change Status" type="is-dark">
                        <b-button v-if="props.row.is_active === 1" rounded size="is-small"
                                  type="is-success" @click="changeStatus(props.row.id)">
                            Yes
                        </b-button>
                        <b-button v-else rounded size="is-small" type="is-danger"
                                  @click="changeStatus(props.row.id)">
                            No
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-if="hasPermission('can-read-roles') " field="count_permissions" label="Permission" >
                    <b-tooltip label="View Permission" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRolePermission(props.row)">
                            {{ props.row.count_permissions }} / {{page.total_permissions}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-else field="count_permissions" label="Permission" >

                        <b-button rounded size="is-small"
                                  type="is-primary" disabled>
                            {{ props.row.count_permissions }} / {{page.total_permissions}}
                        </b-button>

                </b-table-column>

                <b-table-column  v-if="hasPermission('can-read-roles') "
                                    field="count_users" label="Users">
                    <b-tooltip label="View User" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRoleUser(props.row)" >
                            {{ props.row.count_users }} / {{page.total_users}}
                        </b-button>
                    </b-tooltip>

                </b-table-column>

                <b-table-column v-else field="count_users" label="Users">
                        <b-button rounded size="is-small"
                                  type="is-primary" disabled >
                            {{ props.row.count_users }} / {{page.total_users}}
                        </b-button>

                </b-table-column>

                <b-table-column field="updated_at" label="Updated At">
                    {{ $vaah.fromNow(props.row.updated_at) }}
                </b-table-column>


                <b-table-column v-if="hasPermission('can-read-roles')"
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

