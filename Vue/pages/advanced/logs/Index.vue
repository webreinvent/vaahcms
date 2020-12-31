<script src="./IndexJs.js"></script>
<template>
    <div class="columns">

        <!--left-->
        <div class="column is-5">

            <!--card-->
            <div class="card" >

                <!--header-->
                <header class="card-header">

                    <div class="card-header-title">
                        Logs
                    </div>

                    <b-tooltip label="Reload" type="is-dark">
                    <b-button type="is-text"
                              class="card-header-icon has-margin-top-5 has-margin-right-5"
                              icon-left="redo-alt"></b-button>
                    </b-tooltip>


                    <b-tooltip label="Delete All Logs" type="is-danger">
                    <b-button class="card-header-icon has-margin-top-5  has-margin-right-5"
                              type="is-text"
                              icon-left="trash"></b-button>
                    </b-tooltip>

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


                    <div v-if="page && page.list &&  is_list_fetched ">
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
</template>


