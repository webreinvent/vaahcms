<script src="./MigrateJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns is-centered ">
            <div class="column is-8">

                <b-notification type="is-info" aria-close-label="Close notification">
                    This step will run database migration and seeds.
                </b-notification>

                <b-button type="is-success"
                          v-if="config.is_migrated"
                          icon-left="check"
                          :loading="btn_is_migration"
                          @click="confirmDelete()">
                    Migrate & Run Seeds
                </b-button>

                <b-button type="is-info"
                          v-else
                          icon-left="database"
                          :loading="btn_is_migration"
                          @click="confirmDelete()">
                    Migrate & Run Seeds
                </b-button>

                <hr>

                <div class="level">
                    <div class="level-left">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      size="small"
                                      tag="router-link"
                                      :to="{name: 'setup.install.configuration'}">
                                Back
                            </b-button>
                        </div>

                    </div>

                    <div class="level-right">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      @click="validateMigration()"
                                      size="small">
                                Save & Next
                            </b-button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!--/columns-->


    </div>


</template>

