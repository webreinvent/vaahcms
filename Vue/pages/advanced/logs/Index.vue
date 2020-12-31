<script src="./IndexJs.js"></script>
<template>
    <div class="container" >

        <div class="columns">

            <!--left-->
            <div class="column is-4">

                <!--card-->
                <div class="card" >

                    <!--header-->
                    <header class="card-header">

                        <div class="card-header-title">
                            Logs
                        </div>

                        <div class="card-header-buttons">
                            <b-button icon-left="redo-alt"></b-button>
                        </div>

                    </header>
                    <!--/header-->

                    <!--content-->
                    <div class="card-content">

                        <b-field>
                            <b-input placeholder="Search..."
                                     type="search"
                                     expanded
                                     icon="search">
                            </b-input>
                            <p class="control">
                                <button class="button is-primary">Search</button>
                            </p>
                        </b-field>


                        <div v-if="is_list_fetched">
                            <b-table
                                :data="page.list_is_empty ? [] : page.list"
                                 :checkable="true"
                                 :checked-rows.sync="page.bulk_action.selected_items"
                                 checkbox-position="left"
                                 :hoverable="true"
                                 :row-class="setRowClass">

                                <b-table-column field="id" label="ID" v-slot="props">
                                    {{ props.row.id }}
                                </b-table-column>

                                <b-table-column field="name" label="Name"  v-slot="props">
                                    {{ props.row.name }}
                                </b-table-column>

                                <b-table-column field="actions" label="Actions"
                                                v-slot="props"
                                                width="80">

                                    <b-tooltip label="Delete" type="is-dark">
                                        <b-button size="is-small"
                                                  @click="setActiveItem(props.row)"
                                                  icon-left="trash-alt">
                                        </b-button>
                                    </b-tooltip>

                                    <b-tooltip label="View" type="is-dark">
                                        <b-button size="is-small"
                                                  @click="setActiveItem(props.row)"
                                                  icon-left="chevron-right">
                                        </b-button>
                                    </b-tooltip>


                                </b-table-column>

                        </b-table>
                        </div>



                    </div>
                    <!--/content-->

                </div>
                <!--/card-->


            </div>
            <!--/left-->


            <router-view></router-view>


        </div>


    </div>
</template>


