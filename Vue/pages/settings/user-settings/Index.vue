<script src="./IndexJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                User Settings
                            </div>

                            <b-tooltip label="Download" type="is-dark">
                                <b-button type="is-text"
                                          class="card-header-icon has-margin-top-5 has-margin-right-5"
                                          icon-left="download" @click="downloadFile(env_file)"></b-button>
                            </b-tooltip>

                            <b-tooltip label="Reload" type="is-dark">
                                <b-button type="is-text"
                                          class="card-header-icon has-margin-top-5 has-margin-right-5"
                                          icon-left="redo-alt"  @click="getList"></b-button>
                            </b-tooltip>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">



                            <div class="block">


                                <div class="columns">
                                    <div class="column is-8">
                                        <div class="block has-padding-10">

                                            <b-table
                                                    :data="is_empty ? [] : list"
                                                    :mobile-cards="has_mobile_cards">

                                                <b-table-column field="for_permission" width="120"
                                                                label="For Permission" numeric
                                                                :td-attrs="columnTdAttrs" v-slot="props">
                                                    <b-checkbox v-model="props.row.for_permission">
                                                    </b-checkbox>
                                                </b-table-column>

                                                <b-table-column field="column_name" label="Column Name"
                                                                :td-attrs="columnTdAttrs" v-slot="props">
                                                    {{ $vaah.toLabel(props.row.name) }}
                                                </b-table-column>

                                                <b-table-column field="is_hidden" width="120"
                                                                label="Is Hidden" v-slot="props">
                                                    <b-field>
                                                    <b-radio-button name="user-is_hidden"
                                                                    dusk="user-is_hidden"
                                                                    v-model="props.row.is_hidden"
                                                                    :native-value=1>
                                                        <span>Yes</span>
                                                    </b-radio-button>

                                                    <b-radio-button type="is-danger"
                                                                    name="user-is_hidden" dusk="user-is_hidden"
                                                                    v-model="props.row.is_hidden"
                                                                    :native-value=0>
                                                        <span>No</span>
                                                    </b-radio-button>
                                                    </b-field>
                                                </b-table-column>


                                                <template #empty>
                                                    <div class="has-text-centered">No records</div>
                                                </template>

                                            </b-table>

                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>


