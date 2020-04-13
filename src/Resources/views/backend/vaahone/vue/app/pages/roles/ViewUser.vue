<script src="./ViewUserJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="block" v-if="is_content_loading">
            <Loader/>
        </div>

        <div class="card" v-else>
            <!--header-->
            <header class="card-header">
                <div v-if="item" class="card-header-title">
                    <span>{{$vaah.limitString(item.name, 30)}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
                            </b-button>

                        </p>

                        <p v-if="hasPermission('can-update-roles') || hasPermission('can-manage-roles')" class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="bulkActions('1')"
                                >
                                    Attach To All Users
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="bulkActions('0')"
                                >
                                    Detach To All Users
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
                            v-if="item.deleted_at"
            >
                Deleted {{$vaah.fromNow(item.deleted_at)}}
            </b-notification>

            <!--content-->
            <div class="card-content">

                <div class="block"  v-if="items && items.list">

                    <b-field>
                        <b-input placeholder="Search Users"
                                 type="search"
                                 icon="search"
                                 @input="delayedSearch"
                                 @keyup.enter.prevent="delayedSearch"
                                 v-model="search_item">>

                        </b-input>
                    </b-field>


                    <b-table :data="items.list.data"
                             :hoverable="true">

                        <template slot-scope="props">
                            <b-table-column field="name" label="Name" >
                                        {{ props.row.name }}
                            </b-table-column>


                            <b-table-column field="email" label="Email" >
                                <b-tooltip label="Copy Email" type="is-dark">
                                    <b-button type="is-small"
                                              class="is-light"
                                              @click="$vaah.copy(props.row.email)">
                                        {{ props.row.email }}
                                    </b-button>
                                </b-tooltip>
                            </b-table-column>

                            <b-table-column v-if="hasPermission('can-update-roles') || hasPermission('can-manage-roles')" field="actions" class="has-text-right" label="Has Role" numeric>
                                <b-button v-if="props.row.pivot.is_active === 1" rounded size="is-small"
                                          type="is-success" @click="changePermission(props.row)">
                                    Yes
                                </b-button>
                                <b-button v-else rounded size="is-small" type="is-danger"
                                          @click="changePermission(props.row)">
                                    No
                                </b-button>
                            </b-table-column>

                            <b-table-column v-else field="actions" class="has-text-right" label="Has Role" numeric>
                                <b-button v-if="props.row.pivot.is_active === 1" disabled rounded size="is-small"
                                          type="is-success" >
                                    Yes
                                </b-button>
                                <b-button v-else disabled rounded size="is-small" type="is-danger">
                                    No
                                </b-button>
                            </b-table-column>
                        </template>

                    </b-table>

                    <hr style="margin-top: 0;"/>

                </div>



                <div class="block" v-if="items">
                    <vh-pagination  :limit="1" :data="items.list"
                                    @onPageChange="getItemUsers">
                    </vh-pagination>
                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


