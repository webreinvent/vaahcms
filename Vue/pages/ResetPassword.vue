<script src="./ResetPasswordJs.js"></script>
<template>

    <section class="section">
        <div class="login-form-layout">

            <div class="container" v-if="is_form_visible">
                <div class="columns is-flex align-items-center justify-center">
                    <div class="column is-4">
                        <div class="login-box box is-flex flex-column
                        align-items-center has-text-centered justify-center">

                            <Logo :assets="root.assets" height="35"/>

                            <div class="content has-text-centered has-margin-top-20">
                                <h3 class="title">Reset Password?</h3>
                                <p class="subtitle">You can reset your password from here.</p>
                            </div>

                            <form class="is-full-width" @submit.prevent="onResetPassword">
                                <b-field class="is-full-width has-margin-top-20">
                                    <b-input type="text"
                                             v-model="credentials.reset_password_code"
                                             dusk="reset-code"
                                             placeholder="Enter code to reset the password">
                                    </b-input>
                                </b-field>
                                <b-field class="is-full-width has-margin-top-20">
                                    <b-input type="password"
                                             autocomplete="new-password"
                                             v-model="credentials.password"
                                             dusk="reset-password"
                                             placeholder="New Password">
                                    </b-input>
                                </b-field>

                                <b-field class="is-full-width has-margin-top-20">
                                    <b-input type="password"
                                             v-model="credentials.password_confirmation"
                                             dusk="reset-confirm_password"
                                             placeholder="Confirm Password">
                                    </b-input>
                                </b-field>

                                <div class="buttons is-full-width has-margin-top-20">
                                    <div class="columns is-full-width">
                                        <div class="column">
                                            <div class="buttons" v-if="assets && assets.settings">
                                                <b-tooltip v-if="assets.settings.max_attempts_of_forgot_password
                                                    && assets.settings.max_attempts_of_forgot_password > 0
                                                    && assets.settings.max_attempts_of_forgot_password <= root.no_of_reset_password_attempt"
                                                           label="You have tried maximum attempts" type="is-danger">
                                                    <b-button native-type="submit"
                                                              :disabled="true"
                                                              :loading="is_btn_loading"
                                                              dusk="reset-recover"
                                                              type="is-primary">
                                                        Recover
                                                    </b-button>

                                                </b-tooltip>

                                                <b-button v-else
                                                          native-type="submit"
                                                          :loading="is_btn_loading"
                                                          dusk="reset-recover"
                                                          type="is-primary">
                                                    Recover
                                                </b-button>

                                            </div>
                                        </div>
                                        <div class="column has-text-right-desktop">
                                            <router-link :to="{name:'sign.in'}">Sign In</router-link>
                                        </div>
                                    </div>
                                </div>
                                <hr class="has-margin-bottom-10"/>
                            </form>

                            <Footer/>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </section>


</template>
