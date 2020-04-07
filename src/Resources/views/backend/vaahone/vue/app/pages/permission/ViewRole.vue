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
                    <span>{{items.permission.name}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button type="is-light">
                                <vh-copy
                                        :data="item.id"
                                        :confirm_dialog="'buefy'">
                                    <small><b>#{{item.id}}</b></small>
                                </vh-copy>
                            </b-button>
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

                        <template slot-scope="props">
                            <b-table-column field="id" label="Role" >
                                {{ props.row.name }}
                            </b-table-column>

                            <b-table-column field="name" class="has-text-centered" label="Has Permission" numeric >
                                <b-button v-if="props.row.pivot.is_active === 1" rounded size="is-small"
                                          type="is-success" @click="changePermission(props.row)">
                                    Yes
                                </b-button>
                                <b-button v-else rounded size="is-small" type="is-danger"
                                          @click="changePermission(props.row)">
                                    No
                                </b-button>
                            </b-table-column>
                        </template>

                    </b-table>

                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


