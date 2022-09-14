<script src="./IndexJs.js"></script>
<template>
    <div class="form-setting" v-if="assets && list">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                General
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="expandAll()"
                                                  icon-left="angle-double-down">
                                            Expand All
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="collapseAll()"
                                                  icon-left="angle-double-up">
                                            Collapse All
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content is-paddingless">


                            <!--site_settings-->
                            <SiteSettings/>
                            <!--/site_settings-->

                            <!--repeatable-->
                            <DateTime/>
                            <!--/repeatable-->


                            <!--repeatable-->
                            <SocialMediaLinks/>
                            <!--/repeatable-->

                            <!--repeatable-->
                            <Scripts/>
                            <!--/repeatable-->

                            <!--repeatable-->
                            <MetaTags/>
                            <!--/repeatable-->

                            <!--repeatable-->
                            <MultiFactorAuth/>
                            <!--/repeatable-->


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


