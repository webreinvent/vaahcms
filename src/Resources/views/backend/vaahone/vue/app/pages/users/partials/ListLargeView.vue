<script src="./ListLargeViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-users') ? true : false"
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

                <b-table-column  field="email" label="Email">
                    <b-tooltip label="Copy Email" type="is-dark">
                        <vh-copy class="text-copyable"
                                 :data="props.row.email"
                                 :label="props.row.email"
                                 @copied="copiedData"
                        >
                        </vh-copy>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-if="props.row.deleted_at || ( !hasPermission('can-manage-users') && !hasPermission('can-update-users'))" field="is_active" label="Is Active">

                    <b-button v-if="props.row.is_active === 1" disabled rounded size="is-small"
                              type="is-success">
                        Yes
                    </b-button>
                    <b-button v-else rounded size="is-small" disabled type="is-danger">
                        No
                    </b-button>

                </b-table-column>

                <b-table-column v-if="!props.row.deleted_at && ( hasPermission('can-manage-users') || hasPermission('can-update-users') )" field="is_active" label="Is Active">
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

                <b-table-column v-if="hasPermission('can-manage-users') || hasPermission('can-update-users' ) || hasPermission('can-read-users' )" field="roles" label="Roles">
                    <b-tooltip label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRole(props.row)">
                            {{ props.row.active_roles_count }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-else field="roles" label="Roles">
                        <b-button rounded size="is-small"
                                  type="is-primary" disabled>
                            {{ props.row.active_roles_count }} / {{page.total_roles}}
                        </b-button>
                </b-table-column>

                <b-table-column field="status" label="Status">
                    <b-tag v-if="props.row.status == 'active'" type="is-small" class="is-success">
                        {{ props.row.status }}
                    </b-tag>
                    <b-tag v-else type="is-small" class="is-danger">
                        {{ props.row.status }}
                    </b-tag>
                </b-table-column>

                <b-table-column field="last_login_at" label="Last Login At" >
                    {{ $vaah.fromNow(props.row.last_login_at) }}
                </b-table-column>

                <b-table-column field="created_at" label="Created At" >
                    {{ $vaah.fromNow(props.row.created_at) }}
                </b-table-column>


                <b-table-column v-if="( hasPermission('can-manage-users') || hasPermission('can-update-users')
                         || hasPermission('can-create-users') || hasPermission('can-read-users')
                          || hasPermission('can-delete-users'))"  field="actions" label=""
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

