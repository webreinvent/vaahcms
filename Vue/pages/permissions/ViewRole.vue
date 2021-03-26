<script src="./ViewRoleJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="block" v-if="is_content_loading">
            <Loader/>
        </div>

        <div class="card" v-else>
            <!--header-->
            <header class="card-header">
                <div v-if="items && items.permission" class="card-header-title">
                    <span>{{$vaah.limitString(items.permission.name, 30)}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p v-if="item" class="control">
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
                            </b-button>

                        </p>

                        <p v-if="hasPermission('can-update-permissions') || hasPermission('can-manage-permissions')" class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="bulkActions('1')">
                                    Active All Roles
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="bulkActions('0')">
                                    Inactive All Roles
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button type="is-light"
                                    @click="resetActiveItem()"
                                    icon-left="times">
                            </b-button>
                        </p>



                    </div>


                </div>

            </header>
            <!--/header-->

            <b-notification type="is-danger"
                            :closable="false"
                            class="is-light is-small"
                            v-if="item && item.deleted_at"
            >
                Deleted {{$vaah.fromNow(item.deleted_at)}}
            </b-notification>

            <!--content-->
            <div class="card-content">

                <div class="block"  v-if="items && items.list">

                    <b-field>
                        <b-input placeholder="Search Roles"
                                 type="search"
                                 icon="search"
                                 @input="delayedSearch"
                                 @keyup.enter.prevent="delayedSearch"
                                 v-model="search_item">>

                        </b-input>
                    </b-field>


                    <b-table :data="items.list.data"
                             :hoverable="true"
                    >

                        <template>
                            <b-table-column v-slot="props" field="id" label="Role" >
                                <b-tooltip label="Copy Slug" type="is-dark">
                                    <b-button type="is-small"
                                              class="is-light"
                                              @click="$vaah.copy(props.row.slug)">
                                        {{ props.row.name }}
                                    </b-button>
                                </b-tooltip>
                            </b-table-column>

                            <b-table-column v-slot="props"
                                            field="name" class="has-text-centered" label="Has Permission" numeric >
                                <span v-if="hasPermission('can-update-permissions') || hasPermission('can-manage-permissions')">
                                     <b-button v-if="props.row.pivot.is_active === 1" rounded size="is-small"
                                               type="is-success" @click="changePermission(props.row)">
                                        Yes
                                    </b-button>
                                    <b-button v-else rounded size="is-small" type="is-danger"
                                              @click="changePermission(props.row)">
                                        No
                                    </b-button>
                                </span>
                                <span v-else>
                                    <b-button v-if="props.row.pivot.is_active === 1" disabled rounded size="is-small"
                                              type="is-success">
                                        Yes
                                    </b-button>
                                    <b-button v-else disabled rounded size="is-small" type="is-danger">
                                        No
                                    </b-button>
                                </span>
                            </b-table-column>

                            <b-table-column  v-slot="props"  field="name" class="has-text-centered" >
                                <b-button size="is-small"
                                          :disabled="props.row.json_length <= 0"
                                          dusk="action-view_detail"
                                          @click="showModal(props.row)"
                                          type="is-default"
                                          rounded
                                          icon-left="eye">
                                    View
                                </b-button>
                            </b-table-column>
                        </template>

                    </b-table>

                    <hr style="margin-top: 0;"/>

                </div>

                <b-pagination  :total="items.list.total"
                               :current.sync="items.list.current_page"
                               :per-page="items.list.per_page"
                               range-before=1
                               range-after=1
                               @change="getItemRoles">
                </b-pagination>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


