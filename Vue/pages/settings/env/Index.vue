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
                                Environment Variable
                                <b-tag class="has-margin-left-5"
                                       type="is-dark"
                                       v-if="env_file"> {{env_file}}</b-tag>
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <b-tooltip label="Reload" type="is-dark">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="getList"
                                                  icon-left="redo-alt">
                                        </b-button>
                                    </p>
                                    </b-tooltip>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">



                            <div class="block">


                                <div class="columns">
                                    <div class="column is-8">
                                        <div class="block has-padding-10">

                                            <div class="block" v-if="list.length > 0"
                                                 v-for="item in list">

                                                <b-field :label-position="labelPosition">

                                                    <b-field>
                                                        <b-input v-model="item.key"></b-input>

                                                        <b-input expanded
                                                                 :type="inputType(item)"
                                                                 :disabled="isDisable(item)"
                                                                 :password-reveal="showRevealButton(item)"
                                                                 v-model="item.value"></b-input>
                                                        <b-tooltip label="Copy" type="is-dark">
                                                        <p class="control">
                                                                <b-button icon-left="copy"
                                                                          @click="copy(item.value)"
                                                                ></b-button>
                                                        </p>
                                                        </b-tooltip>
                                                        <b-tooltip label="Delete" type="is-danger">
                                                        <p class="control">
                                                                <b-button @click="removeVariable(item)"
                                                                          icon-left="trash"></b-button>
                                                        </p>
                                                        </b-tooltip>
                                                    </b-field>

                                                </b-field>

                                            </div>




                                            <b-field>

                                                <b-field>
                                                    <p class="control">
                                                        <b-button type="is-success"
                                                                  @click="addVariable()"
                                                                  icon-left="plus">Add Variable</b-button>
                                                    </p>
                                                    <p class="control">
                                                        <b-button @click="confirmChanges()"
                                                                  type="is-primary">Save</b-button>
                                                    </p>

                                                </b-field>



                                            </b-field>



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


