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
                                Backups
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  icon-left="plus">
                                            New Backup
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">

                            <div class="block" v-if="show_backup_form">
                                <b-field >

                                    <p class="control">
                                        <b-checkbox v-model="include.database">
                                            Database
                                        </b-checkbox>
                                    </p>

                                    <p class="control has-margin-left-10">
                                        <b-checkbox v-model="include.media">
                                            Media Files
                                        </b-checkbox>
                                    </p>

                                </b-field>
                                <b-button type="is-primary" @click="takeBackup">Create</b-button>
                            </div>


                            <div class="block">


                                Testing


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


