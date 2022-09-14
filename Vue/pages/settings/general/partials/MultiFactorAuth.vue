<script src="./MultiFactorAuthJs.js"></script>
<template>

    <div class="block is-marginless scripts" >

        <b-collapse :open="false" aria-id="scripts">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="scripts">

                <div class="label-left">
                    <h4 class="title is-5">Multi-Factor Authentication</h4>
                    <h2 class="subtitle is-6">Enable and choose multiple methods of Authentication.</h2>
                </div>
                <div class="label-right is-hidden-mobile">
                    <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                    </b-button>
                </div>

            </div>


            <div class="block has-margin-top-10 has-padding-10"  v-if="list">

                <div class="columns has-background-white-bis  columns-settings">
                    <div class="column is-half">
                        <div class="block has-padding-10">

                            <b-field>
                                <b-checkbox v-model="list.is_mfa_enabled"
                                            true-value=1
                                            false-value=0>
                                    Enable Multi-Factor Authentication
                                </b-checkbox>
                            </b-field>

                            <template v-if="list.is_mfa_enabled == 1">

                                <hr/>

                                <b-field>
                                    <b-radio v-model="list.mfa_enable_type"
                                             native-value="all-users">
                                        Enable for all users
                                    </b-radio>
                                </b-field>
                                <b-field>
                                    <b-radio v-model="list.mfa_enable_type"
                                             native-value="user-will-have-option">
                                        User will have option to enable it
                                    </b-radio>
                                </b-field>

                                <hr/>

                              <!--<b-field>
                                    <b-radio v-model="list.multi_factor_auth_type"
                                             native-value="sms-phone">
                                        SMS & Phone Callback
                                    </b-radio>
                                </b-field>
                                <b-field>
                                    <b-radio v-model="list.multi_factor_auth_type"
                                             native-value="authenticator-app">
                                        Authenticator App
                                    </b-radio>
                                </b-field>-->

                                <b-field label="MFA Type">
                                    <b-radio v-model="list.mfa_type"
                                             native-value="email-otp-verification">
                                        Email OTP Verification
                                    </b-radio>
                                </b-field>
                            </template>

                            <b-field>
                                <p class="control">
                                    <b-button @click="storeSiteSettings"
                                              type="is-primary">Save</b-button>
                                </p>
                            </b-field>




                        </div>

                    </div>
                </div>



            </div>
        </b-collapse>

        <hr class="is-marginless"/>
    </div>

</template>
