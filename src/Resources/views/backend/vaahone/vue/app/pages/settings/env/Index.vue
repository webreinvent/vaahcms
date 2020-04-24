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
                                <small class="subtitle has-margin-left-5" v-if="env_file"> / {{env_file}}</small>
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  icon-left="redo-alt">
                                        </b-button>
                                    </p>
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

                                            <div class="block" v-if="list.length > 0" v-for="item in list">


                                                <b-field :label-position="labelPosition">

                                                    <b-field>
                                                        <b-input v-model="item.key"
                                                                 :disabled="isDisable(item)"
                                                        ></b-input>

                                                        <b-input expanded
                                                                 :type="inputType(item)"
                                                                 :disabled="isDisable(item)"
                                                                 :password-reveal="showRevealButton(item)"
                                                                 v-model="item.value"></b-input>

                                                        <p class="control">
                                                            <b-tooltip label="Copy" type="is-dark">
                                                                <b-button icon-left="copy"></b-button>
                                                            </b-tooltip>
                                                        </p>
                                                        <p class="control" v-if="!isDisable(item)">
                                                            <b-tooltip label="Delete" type="is-dark">
                                                                <b-button @click="removeVariable(item)"
                                                                          icon-left="trash"></b-button>
                                                            </b-tooltip>
                                                        </p>
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
                                    <div class="column is-half">
                                        <div class="block has-padding-10">


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


