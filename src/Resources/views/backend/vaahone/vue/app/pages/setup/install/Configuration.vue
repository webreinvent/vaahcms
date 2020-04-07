<script src="./ConfigurationJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">


                <b-field label="App URL" :label-position="labelPosition">
                    <b-input v-model="config.env.app_url"
                             disabled
                             name="config-app_url"
                             dusk="config-app_url"
                    ></b-input>
                </b-field>

                <b-field grouped>
                    <b-field label="Env"
                             expanded
                             :label-position="labelPosition">
                        <b-select placeholder="- Select an environment -"
                                  expanded
                                  name="config-app_env"
                                  dusk="config-app_env"
                                  v-model="config.env.app_env">
                            <option value="">- Select an environment -</option>
                            <option v-for="item in page.assets.environments"
                                    :value="item.slug"
                            >{{item.name}}</option>
                        </b-select>
                    </b-field>

                    <b-field label="Timezone"
                             expanded
                             :label-position="labelPosition">
                        <AutoCompleteTimeZone
                            :options="page.assets.timezones"
                            :open_on_focus="true"
                            @onSelect="setTimeZone"
                        />
                    </b-field>
                </b-field>

                <b-field label="App/Website Name" :label-position="labelPosition">
                    <b-input v-model="config.env.app_name"
                             name="config-app_name"
                             dusk="config-app_name"
                    ></b-input>
                </b-field>







                <hr>

                <b-field grouped>

                    <b-field label="Database Type" expanded
                             :label-position="labelPosition">
                        <b-select placeholder="- Select Database Type -"
                                  expanded
                                  name="config-db_connection"
                                  dusk="config-db_connection"
                                  v-model="config.env.db_connection">
                            <option value="">- Select Database Type -</option>
                            <option v-for="item in page.assets.database_types"
                                    :value="item.slug"
                            >{{item.name}}</option>
                        </b-select>
                    </b-field>

                    <b-field label="Database Host" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.db_host"
                                 expanded
                                 name="config-db_host"
                                 dusk="config-db_host"
                        ></b-input>
                    </b-field>



                    <b-field label="Database Port" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.db_port"
                                 expanded
                                 name="config-db_port"
                                 dusk="config-db_port"
                        ></b-input>
                    </b-field>
                </b-field>


                <b-field grouped>
                    <b-field label="Database Name"
                             expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.db_database"
                                 expanded
                                 name="config-db_database"
                                 dusk="config-db_database"
                        ></b-input>
                    </b-field>

                    <b-field label="Database Username"
                             expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.db_username"
                                 expanded
                                 name="config-db_username"
                                 dusk="config-db_username"
                        ></b-input>
                    </b-field>

                    <b-field label="Database Username Password"
                             expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.db_password"
                                 expanded
                                 password-reveal
                                 name="config-db_password"
                                 dusk="config-db_password"
                        ></b-input>
                    </b-field>
                </b-field>

                <b-button type="is-info"
                          size="is-small"
                          icon-left="database"
                          @click="testDatabaseConnection()">
                    Test Database Connection
                </b-button>


                <hr>
                <b-field grouped>
                    <b-field label="Mail Driver" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.mail_driver"
                                 expanded
                                 name="config-mail_driver"
                                 dusk="config-mail_driver"
                        ></b-input>
                    </b-field>

                    <b-field label="Mail Host" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.mail_host"
                                 expanded
                                 name="config-mail_host"
                                 dusk="config-mail_host"
                        ></b-input>
                    </b-field>

                    <b-field label="Mail Port" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.mail_port"
                                 expanded
                                 name="config-mail_port"
                                 dusk="config-mail_port"
                        ></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="Mail Username" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.mail_username"
                                 expanded
                                 name="config-mail_username"
                                 dusk="config-mail_username"
                        ></b-input>
                    </b-field>

                    <b-field label="Mail Username Password" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.env.mail_password"
                                 expanded
                                 type="password"
                                 password-reveal
                                 name="config-mail_password"
                                 dusk="config-mail_password"
                        ></b-input>
                    </b-field>

                    <b-field label="Mail Encryption" expanded
                             :label-position="labelPosition">
                        <b-select placeholder="- Select an mail encryption -"
                                  expanded
                                  name="config-mail_encryption"
                                  dusk="config-mail_encryption"
                                  v-model="config.env.mail_encryption">
                            <option value="">- Select an mail encryption -</option>
                            <option v-for="item in page.assets.mail_encryption_types"
                                    :value="item.slug"
                            >{{item.name}}</option>
                        </b-select>
                    </b-field>
                </b-field>

                <b-button type="is-info"
                          size="is-small"
                          icon-left="envelope"
                          @click="testDatabaseConnection()">
                    Test Mail Configuration
                </b-button>

                <hr>

                <div class="level">
                    <div class="level-left">

                    </div>

                    <div class="level-right">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      size="small"
                                      @click="testDatabaseConnection()">
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

