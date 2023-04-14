<script src="./SecuritiesJs.js"></script>
<template>

    <div class="block is-marginless scripts" >

        <b-collapse :open="false" aria-id="scripts">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="scripts">

                <div class="label-left">
                    <h4 class="title is-5">Securities</h4>
                    <h2 class="subtitle is-6">Enable and choose multiple methods of Authentication.</h2>
                </div>
                <div class="label-right is-hidden-mobile">
                    <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                    </b-button>
                </div>

            </div>


            <div class="block has-margin-top-10 has-padding-10"  v-if="list">

                <div class="columns has-background-white-bis  columns-settings">
                    <div class="column">
                        <div class="block has-padding-10">
                            <span class="is-size-5">
                                <span class="has-text-weight-bold">
                                    Multi-Factor Authentication
                                </span>
                                <p>
                                    Require a email otp, sms otp, or authenticator app verification when you log in with a password.
                                </p>
                            </span>

                            <template>

                                <hr/>
                                <b-field>
                                    <b-radio v-model="list.mfa_status"
                                             native-value="disable">
                                        Disable
                                    </b-radio>

                                </b-field>
                                <b-field>
                                    <b-radio v-model="list.mfa_status"
                                             native-value="all-users">
                                        Enable for all users
                                    </b-radio>

                                </b-field>
                                <b-field>
                                    <b-radio v-model="list.mfa_status"
                                             native-value="user-will-have-option">
                                        User will have option to enable it
                                    </b-radio>
                                </b-field>

                                <hr/>

                                <label class="label">MFA Methods</label>
                                <b-field>
                                    <b-checkbox :disabled="list.mfa_status === 'disable'"
                                                v-model="list.mfa_methods"
                                             native-value="email-otp-verification">
                                        Email OTP Verification
                                    </b-checkbox>
                                </b-field>
                                <b-field>
                                    <b-checkbox disabled
                                                v-model="list.mfa_methods"
                                             native-value="sms-otp-verification">
                                        Sms OTP Verification
                                    </b-checkbox>
                                </b-field>
                                <b-field>
                                    <b-checkbox disabled v-model="list.mfa_methods"
                                             native-value="authenticator-app">
                                        Authenticator App (Only user can enable this)
                                    </b-checkbox>
                                </b-field>
                            </template>

                            <hr/>

                            <b-switch size="is-medium" true-value="1"  v-model="list.is_new_device_verification_enabled">
                                <span class="has-text-weight-bold">
                                    New Device Verification
                                </span>
                                <p>
                                    We will prompt for additional verification when you log in from a new device or browser.
                                </p>
                            </b-switch>

                            <hr/>

                            <b-field>
                                <p class="control">
                                    <b-button @click="storeSecuritySettings"
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
