<script src="./ConfigurationJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter has-text-centered">

                <b-field label="Env" :label-position="labelPosition">
                    <b-select placeholder="- Select an environment -"
                              name="register-title" dusk="register-title"
                              v-model="config.env">
                        <option value="">- Select an environment -</option>
                        <option v-for="item in page.assets.environments"
                                :value="item.slug"
                        >{{item.name}}</option>
                    </b-select>
                </b-field>



            </div>
        </div>
        <!--/columns-->


    </div>


</template>

