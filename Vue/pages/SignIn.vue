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

                                <div class="content has-text-centered has-margin-top-20">
                                    <h3 class="title">Sign In</h3>
                                    <p class="subtitle">Please Sign In to continue</p>
                                </div>

                                <!--form-->
                                <form class="is-full-width" @submit.prevent="signIn()">
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
                                        <b-input v-model="signin.username"
                                                 placeholder="Enter Email Address or Username"
                                                 dusk="signin-username_or_email">
                                        </b-input>
                                    </b-field>

                                    <b-field v-if="signin.type == 'otp'"
                                             class="is-full-width has-margin-top-20">
                                        <b-input type="email"
                                                 v-model="signin.email"
                                                 placeholder="Enter Email Address"
                                                 dusk="signin-username_or_email">
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

