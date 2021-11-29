<script src="./ListLargeViewJs.js"></script>
<template>
    <div>
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-permissions') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 :hoverable="true"
                 :row-class="setRowClass"
        >

            <template>
                <b-table-column v-slot="props" field="id" label="ID" width="85">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column v-slot="props" field="name" label="Name">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column v-slot="props" field="slug" label="Slug">
                    <b-tooltip label="Copy Slug" type="is-dark">
                        <vh-copy class="text-copyable"
                                 :data="props.row.slug"
                                 :label="props.row.slug+' '+icon_copy"
                                 @copied="copiedData"
                        >
                        </vh-copy>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-slot="props" field="status" label="Is Active">
                    <span  v-if="props.row.deleted_at || ( !hasPermission('can-manage-permissions')
                     && !hasPermission('can-update-permissions'))">
                        <b-button v-if="props.row.is_active === 1" disabled rounded size="is-small"
                                  type="is-success">
                            Yes
                        </b-button>
                        <b-button v-else disabled rounded size="is-small" type="is-danger">
                            No
                        </b-button>
                    </span>
                    <span v-if="!props.row.deleted_at && ( hasPermission('can-manage-permissions') || hasPermission('can-update-permissions') )">
                        <b-button v-if="props.row.is_active === 1" rounded size="is-small"
                                  type="is-success" @click="changeStatus(props.row.id)">
                            Yes
                        </b-button>
                        <b-button v-else rounded size="is-small" type="is-danger" @click="changeStatus(props.row.id)">
                            No
                        </b-button>
                    </span>
                </b-table-column>

                <b-table-column v-slot="props" field="count_roles" label="Roles" >
                    <b-tooltip v-if="hasPermission('can-read-permissions') "  label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" @click="getRole(props.row)">
                            {{ props.row.count_roles }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                    <b-tooltip v-else label="View Role" type="is-dark">
                        <b-button rounded size="is-small"
                                  type="is-primary" disabled>
                            {{ props.row.count_roles }} / {{page.total_roles}}
                        </b-button>
                    </b-tooltip>
                </b-table-column>

                <b-table-column v-slot="props" field="count_users" label="Users">
                    <b-button disabled rounded size="is-small"
                           type="is-light">
                        {{ props.row.count_users }} / {{page.total_users}}
                    </b-button>

                </b-table-column>

                <b-table-column v-slot="props" field="updated_at" label="Updated At">
                    {{ $vaah.fromNow(props.row.updated_at) }}
                </b-table-column>


                <b-table-column v-slot="props" field="actions" label=""
                                width="80">

                    <b-tooltip v-if="hasPermission('can-update-permissions')"
                               label="Edit" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row,'perm.edit')"
                                  icon-left="edit">
                        </b-button>
                    </b-tooltip>

                    <b-tooltip v-if="hasPermission('can-read-permissions')"
                               label="View" type="is-dark">
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

