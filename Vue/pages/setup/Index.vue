<script src="./IndexJs.js"></script>
<template>

    <div v-if="root && root.assets && assets">

        <!--sections-->
        <section class="section has-margin-top-40 " >
            <div class="container">

                <div class="columns">
                    <div class="column has-text-centered">
                        <div class="">
                            <Logo :assets="root.assets" height="40"/>
                        </div>

                        <VueErrors/>
                        <VueMessages/>
                    </div>
                </div>

                <!--columns-->
                <div v-if="assets.is_installed" class="columns" >
                    <div class="column is-half is-offset-one-quarter has-text-centered">
                        <b-notification type="is-success">
                            VaahCMS is successfully setup.
                        </b-notification>
                    </div>
                </div>
                <!--/columns-->

                <!--columns-->
                <div class="columns is-centered has-margin-top-40 has-margin-bottom-40 " >
                    <div class="column is-8">



                        <div class="columns">
                            <div class="column">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="media">

                                            <div class="media-content">
                                                <div class="level">

                                                    <div class="level-left">
                                                        <h3 class="title is-4">Install</h3>
                                                    </div>

                                                    <div class="level-right">
                                                        <b-tooltip label="Documentation">
                                                        <b-button size="is-small"
                                                                  type="is-light"
                                                                  tag="a"
                                                                  href="https://docs.vaah.dev/vaahcms/installation.html"
                                                                  target="_blank"
                                                                  rounded
                                                                  class="pull-right"
                                                                  icon-left="book">
                                                        </b-button>
                                                        </b-tooltip>
                                                    </div>

                                                </div>

                                                <p>
                                                    <a href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
                                                    is a web application development platform shipped
                                                    with headless content management system.
                                                </p>



                                                <div class="level">
                                                    <!-- Left side -->
                                                    <div class="level-left">
                                                        <div class="level-item">
                                                            <p class="has-margin-top-20">

                                                                <b-button v-if="status.stage=='installed'"
                                                                          icon-left="server"
                                                                          disabled>
                                                                    Install
                                                                </b-button>
                                                                <b-button v-else
                                                                          icon-left="server"
                                                                          tag="router-link"
                                                                          :to="{name:'setup.install.configuration'}"
                                                                          type="is-primary" >
                                                                    Install
                                                                </b-button>

                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Right side -->
                                                    <div class="level-right">
                                                        <div class="level-item">
                                                            <p class="has-margin-top-20">

                                                                <b-dropdown :triggers="['hover']" aria-role="list">
                                                                    <template #trigger>
                                                                        <b-button
                                                                                label="Advanced Options"
                                                                                type="is-info"
                                                                                icon-right="chevron-down" />
                                                                    </template>


                                                                    <b-dropdown-item aria-role="listitem"
                                                                                     @click="publishAssets">
                                                                        Publish Assets
                                                                    </b-dropdown-item>
                                                                    <b-dropdown-item aria-role="listitem"
                                                                                     @click="clearCache">
                                                                        Clear Cache
                                                                    </b-dropdown-item>
                                                                </b-dropdown>

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="column">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="media">

                                            <div class="media-content">
                                                <div class="level">

                                                    <div class="level-left">
                                                        <h3 class="title is-4">Reset</h3>
                                                    </div>

                                                    <div class="level-right">

                                                        <b-button size="is-small"
                                                                  type="is-light"
                                                                  rounded
                                                                  class="pull-right"
                                                                  icon-left="redo">
                                                        </b-button>


                                                    </div>

                                                </div>

                                                <p>You can reset/re-install the application if you're logged in from "Administrator" account.</p>

                                                <p class="has-margin-top-20">

                                                    <b-button icon-left="redo"
                                                              v-if="status.is_user_administrator"
                                                              @click="show_reset_modal = true"
                                                              type="is-danger">
                                                        Reset
                                                    </b-button>

                                                    <b-button icon-left="redo"
                                                              v-else
                                                              disabled>
                                                        Reset
                                                    </b-button>

                                                </p>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--modal-->
                                <b-modal :active.sync="show_reset_modal">
                                    <form action="">
                                        <div class="modal-card" style="width: 550px">
                                            <header class="modal-card-head">
                                                <p class="modal-card-title">
                                                    Reset
                                                </p>
                                            </header>
                                            <div class="modal-notification">
                                                <b-notification
                                                    :closable="false"
                                                    class="is-light is-small"
                                                    type="is-danger">
                                                    <p>You are going to <b>RESET</b> the application. This will remove all the data of the application.</p>
                                                    <p>After reset you <b>CANNOT</b> be restored data! Are you <b>ABSOLUTELY</b> sure?</p>
                                                </b-notification>
                                            </div>
                                            <section class="modal-card-body">

                                                <div class="content">
                                                    <p>This action can lead to data loss. To prevent accidental actions we ask you to confirm your intention.</p>


                                                    <p class="has-margin-bottom-5">
                                                        Please type <b>RESET</b> to proceed and click Confirm button or close this modal to cancel.
                                                    </p>
                                                </div>


                                                <b-field label="">
                                                    <b-input
                                                        v-model="reset_inputs.confirm"
                                                        placeholder="Type RESET to confirm"
                                                        required>
                                                    </b-input>
                                                </b-field>

                                                <div v-if="reset_inputs.confirm=='RESET'">
                                                    <b-field label="">
                                                        <b-checkbox v-model="reset_inputs.delete_media">
                                                            Delete Files From Storage (storage/app/public)
                                                        </b-checkbox>
                                                    </b-field>
                                                    <b-field label="">
                                                        <b-checkbox v-model="reset_inputs.delete_dependencies">
                                                            Delete Dependencies (Modules & Themes)
                                                        </b-checkbox>
                                                    </b-field>
                                                </div>

                                            </section>

                                            <footer class="modal-card-foot">
                                                <b-button type="is-danger"
                                                          :loading="is_btn_loading"
                                                          @click="confirmReset()">
                                                    Confirm
                                                </b-button>
                                            </footer>

                                        </div>
                                    </form>
                                </b-modal>
                                <!--/modal-->

                            </div>
                        </div>

                    </div>
                </div>
                <!--/columns-->

                <div class="columns">
                    <div class="column has-text-centered">
                        <Footer/>
                    </div>
                </div>

            </div>
        </section>
        <!--sections-->


    </div>


</template>

