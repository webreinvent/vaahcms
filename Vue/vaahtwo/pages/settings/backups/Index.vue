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
                                        <Button size="small"
                                                severity="secondary"
                                                outlined
                                                icon="pi pi-plus"
                                                label="New Backup" />
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">

                            <div class="block" v-if="show_backup_form">
                                <div class="field">

                                    <div class="control">
                                        <Checkbox binary
                                                  v-model="include.database"
                                                  inputId="include-database" />
                                        <label for="include-database">Database</label>
                                    </div>

                                    <div class="control ml-3">
                                        <Checkbox binary
                                                  v-model="include.media"
                                                  inputId="include-media" />
                                        <label for="include-media">Media Files</label>
                                    </div>

                                </div>
                                <Button @click="takeBackup" label="Create" />
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


