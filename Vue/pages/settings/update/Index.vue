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
                                Update VaahCMS
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="checkForUpdate()"
                                                  icon-left="sync">
                                            Check for Update
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <b-notification v-if="update_available" type="is-info is-light">
                            A newer version <b>{{remote_version}}</b> of VaahCMS is available.

                            <hr/>

                            <b>New Updates:</b>


                            <div v-html="release.body"></div>




                            <p>
                                <b-field>
                                    <b-checkbox>Have you taken the backup of your files & database?</b-checkbox>
                                </b-field>
                            </p>

                            <p><b-button>Update Now</b-button></p>

                            <ol>

                                <li> Download latest version

                                    <b-icon
                                        pack="fas"
                                        icon="check"
                                        >
                                    </b-icon>

                                </li>
                                <li> Publish assets
                                    <b-icon
                                        pack="fas"
                                        icon="sync-alt"
                                        custom-class="fa-spin">
                                    </b-icon>
                                </li>
                                <li> Clear Cache</li>
                                <li> Reload</li>

                            </ol>




                        </b-notification>

                        <div class="card-content">
                            Current version of VaahCMS is v1.4.5




                        </div>


                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>


