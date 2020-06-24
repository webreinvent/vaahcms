<script src="./AccountJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                <b-notification type="is-info" aria-close-label="Close notification">
                    Create first account, this account will have administrator role and will have all the permissions.
                </b-notification>

                <b-field grouped>

                    <b-field label="First name" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.first_name"
                                 expanded
                                 name="config-first_name"
                                 dusk="config-first_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Middle name" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.middle_name"
                                 expanded
                                 name="config-middle_name"
                                 dusk="config-middle_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Last name" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.last_name"
                                 expanded
                                 name="config-last_name"
                                 dusk="config-last_name"
                        ></b-input>
                    </b-field>


                </b-field>

                <b-field grouped>

                    <b-field label="Email" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.email"
                                 expanded
                                 type="email"
                                 @blur="generateUsername()"
                                 name="config-email"
                                 dusk="config-email"
                        ></b-input>
                    </b-field>

                    <b-field label="Username" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.username"
                                 expanded
                                 name="config-username"
                                 dusk="config-username"
                        ></b-input>
                    </b-field>

                    <b-field label="Password" expanded
                             :label-position="labelPosition">
                        <b-input v-model="config.account.password"
                                 expanded
                                 type="password"
                                 password-reveal
                                 autocomplete="new-password"
                                 name="config-password"
                                 dusk="config-password"
                        ></b-input>
                    </b-field>


                </b-field>

                <b-field grouped>



                    <b-field label="Country Code" :label-position="labelPosition">
                        <AutoCompleteCallingCode
                            :options="assets.country_calling_codes"
                            :open_on_focus="true"
                            @onSelect="setCallingCode"
                        />
                    </b-field>


                    <b-field label="Phone" :label-position="labelPosition" expanded>
                        <b-input v-model="config.account.phone"
                                 expanded
                                 name="config-phone"
                                 dusk="config-phone"
                        ></b-input>
                    </b-field>

                    <b-field label="" :label-position="labelPosition" expanded>

                    </b-field>

                </b-field>

                <b-button type="is-success"
                          v-if="config.is_account_created"
                          icon-left="check"
                          :loading="btn_is_account_creating">
                    Create Account
                </b-button>

                <b-button type="is-info"
                          v-else
                          icon-left="user-plus"
                          :loading="btn_is_account_creating"
                          @click="createAccount()">
                    Create Account
                </b-button>


                <hr>

                <div class="level">
                    <div class="level-left">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      size="small"
                                      tag="router-link"
                                      :to="{name: 'setup.install.dependencies'}">
                                Back
                            </b-button>
                        </div>

                    </div>

                    <div class="level-right">

                        <div class="level-item">
                            <b-button type="is-success"
                                      v-if="config.is_account_created"
                                      @click="validateAccountCreation()"
                                      icon-left="sign-in-alt"
                                      size="small">
                                Go to Backend Sign In.
                            </b-button>

                            <b-button type="is-primary"
                                      v-else
                                      @click="validateAccountCreation()"
                                      icon-left="sign-in-alt"
                                      size="small">
                                Go to Backend Sign In.
                            </b-button>

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!--/columns-->


    </div>


</template>

