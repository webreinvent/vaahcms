<script src="./ConfigurationJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter has-text-centered">

                <b-field label="Env" :label-position="labelPosition">
                    <b-select placeholder="- Select an environment -"
                              name="config-app_env"
                              dusk="config-app_env"
                              v-model="config.env.app_env">
                        <option value="">- Select an environment -</option>
                        <option v-for="item in page.assets.environments"
                                :value="item.slug"
                        >{{item.name}}</option>
                    </b-select>
                </b-field>

                <b-field label="App/Website Name" :label-position="labelPosition">
                    <b-input v-model="config.env.app_name"
                             name="config-app_name"
                             dusk="config-app_name"
                    ></b-input>
                </b-field>


                <b-field label="App URL" :label-position="labelPosition">
                    <b-input v-model="config.env.app_url"
                             name="config-app_url"
                             dusk="config-app_url"
                    ></b-input>
                </b-field>


                <b-field label="Timezone" :label-position="labelPosition">
                    <AutoCompleteTimeZone
                        :options="page.assets.timezones"
                        :open_on_focus="true"
                        @onSelect="setTimeZone"
                    />
                </b-field>


                <b-field label="Database Type" :label-position="labelPosition">
                    <b-select placeholder="- Select a Timezone -"
                              name="config-app_timezone"
                              dusk="config-app_timezone"
                              v-model="config.env.db_connection">
                        <option value="">- Select a Timezone -</option>
                        <option v-for="item in page.assets.database_types"
                                :value="item.slug"
                        >{{item.name}}</option>
                    </b-select>
                </b-field>

            </div>
        </div>
        <!--/columns-->


    </div>


</template>

