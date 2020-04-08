<script src="./MigrateJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                <h1>Migrate</h1>


                <hr>

                <div class="level">
                    <div class="level-left">

                    </div>

                    <div class="level-right">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      size="small"
                                      :loading="is_btn_loading_config"
                                      @click="validateConfigurations()">
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

