<script src="./SignInJs.js"></script>
<template>

    <section class="section " >
        <div class="login-form-layout">
            <div class="container">

                <div class="columns is-flex align-items-center justify-center">

                    <div class="column is-4" >

                        <div v-if="!root || !root.assets"
                             class="login-box box is-flex flex-column align-items-center justify-center">
                            <Loader/>
                        </div>

                        <div v-else class="login-box box is-flex flex-column align-items-center justify-center">

                                <Logo :assets="root.assets" height="35"/>

                                <div v-if="is_verification_form_visible" class="content has-text-centered has-margin-top-20">
                                    <h3 class="title">Multi-Factor Authentication</h3>
                                    <p class="subtitle">You have received an email which contains two factor code.</p>
                                </div>

                                <div v-else class="content has-text-centered has-margin-top-20">
                                    <h3 class="title">Sign In</h3>
                                    <p class="subtitle">Please Sign In to continue</p>
                                </div>

                                <!--form-->
                                <form v-if="is_verification_form_visible" class="is-full-width"
                                      @submit.prevent="verifySecurityOtp()">
                                    <hr class="has-margin-bottom-10"/>

                                    <b-field label="Enter OTP" grouped>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_0"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_0"
                                                     class="has-text-centered"
                                                     @paste.native="onOtpPaste"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, 'otp_1', null)"
                                            ></b-input>
                                        </b-field>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_1"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_1"
                                                     class="has-text-centered"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, 'otp_2', 'otp_0')"
                                            ></b-input>
                                        </b-field>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_2"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_2"
                                                     class="has-text-centered"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, 'otp_3', 'otp_1')"
                                            ></b-input>
                                        </b-field>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_3"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_3"
                                                     class="has-text-centered"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, 'otp_4', 'otp_2')"
                                            ></b-input>
                                        </b-field>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_4"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_4"
                                                     class="has-text-centered"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, 'otp_5', 'otp_3')">
                                            </b-input>
                                        </b-field>
                                        <b-field>
                                            <b-input style="width:3em;"
                                                     id="otp_5"
                                                     maxlength="1"
                                                     :has-counter="false"
                                                     v-model="verification.otp_5"
                                                     class="has-text-centered"
                                                     @focus="$event.target.select()"
                                                     @keyup.native="moveToElement($event, null, 'otp_4')">
                                            </b-input>
                                        </b-field>

                                    </b-field>


                                    <div class="level has-margin-top-20">

                                        <!--left-->
                                        <div class="level-left" >
                                            <b-button
                                                    native-type="submit"
                                                    :loading="is_verification_btn_otp_loading"
                                                    dusk="signin-signin"
                                                    type="is-primary">Submit OTP</b-button>
                                        </div>

                                        <div class="level-right">
                                            <b-button
                                                    @click="resendSecurityOtp"
                                                    type="is-primary"
                                                    :disabled="security_timer > 0"
                                                    :loading="is_resend_otp_btn_loading">
                                                Resend OTP
                                                <span v-if="security_timer > 0">
                                            in {{ security_timer  }} Seconds..
                                        </span>
                                            </b-button>
                                        </div>

                                    </div>
                                    <hr class="has-margin-bottom-10"/>
                                </form>
                                <!--/form-->

                                <!--form-->
                                <form v-else class="is-full-width" @submit.prevent="signIn()">
                                    <hr class="has-margin-bottom-10"/>
                                    <div class="field">
                                        <b-radio v-model="signin.type"
                                                 native-value="password">
                                            Login via Password
                                        </b-radio>
                                    </div>

                                    <div class="field">
                                        <b-radio v-model="signin.type"
                                                 :disabled="assets.settings.is_mail_settings_not_set"
                                                 native-value="otp">
                                            Login via OTP
                                        </b-radio>
                                    </div>

                                    <b-field v-if="signin.type != 'otp'"
                                             class="is-full-width has-margin-top-20">
                                        <b-input type="text"
                                                 v-model="signin.email"
                                                 placeholder="Enter Email or Username"
                                                 dusk="signin-email_or_username">
                                        </b-input>
                                    </b-field>

                                    <b-field v-if="signin.type == 'otp'"
                                             class="is-full-width has-margin-top-20">
                                        <b-input type="text"
                                                 v-model="signin.email"
                                                 placeholder="Enter Email"
                                                 dusk="signin-email">
                                        </b-input>
                                    </b-field>

                                    <b-field v-if="signin.type == 'otp'">
                                        <b-button
                                            :loading="is_btn_otp_loading"
                                            @click="generateOTP"
                                            dusk="signin-otp_button"
                                            type="is-primary">Generate OTP</b-button>
                                    </b-field>


                                    <b-field class="is-full-width"
                                             v-if="signin.type == 'password'">
                                        <b-input type="password"
                                                 v-model="signin.password"
                                                 placeholder="Enter Password"
                                                 dusk="signin-password"
                                                 password-reveal>
                                        </b-input>
                                    </b-field>

                                    <b-field class="is-full-width"
                                             v-else>
                                        <b-input type="new-password"
                                                 v-model="signin.login_otp"
                                                 placeholder="Enter Login OTP"
                                                 dusk="signin-login_otp"
                                                 password-reveal>
                                        </b-input>
                                    </b-field>


                                    <div class="buttons is-full-width has-margin-top-20">
                                        <div class="columns is-full-width">

                                            <div class="column">
                                                <div class="buttons" v-if="assets && assets.settings">
                                                    <b-tooltip v-if="assets.settings.max_attempts_of_login
                                                    && assets.settings.max_attempts_of_login > 0
                                                    && assets.settings.max_attempts_of_login <= root.no_of_login_attempt"
                                                               label="You have tried maximum attempts" type="is-danger">
                                                        <b-button
                                                                native-type="submit"
                                                                :disabled="true"
                                                                :loading="is_btn_loading"
                                                                dusk="signin-signin"
                                                                type="is-primary">Sign In</b-button>
                                                    </b-tooltip>

                                                    <b-button v-else
                                                            native-type="submit"
                                                            :loading="is_btn_loading"
                                                            dusk="signin-signin"
                                                            type="is-primary">
                                                        Sign In
                                                    </b-button>


                                                </div>
                                            </div>

                                            <div class="column has-text-right-desktop">
                                                <router-link :to="{name:'forgot.password'}">Forgot Password?</router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="has-margin-bottom-10"/>
                                </form>
                                <!--/form-->

                                <Footer/>

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>


</template>

