<script src="./SignInJs.js"></script>
<template>

    <section class="section ">
        <div class="login-form-layout">
            <div class="container">
                <div class="columns is-flex align-items-center justify-center">
                <div class="column is-4">
                    <div class="login-box box is-flex flex-column align-items-center justify-center">

                        <Logo height="35"/>

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

                            <b-field class="is-full-width has-margin-top-20">
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
                                        <div class="buttons">
                                            <b-button
                                                native-type="submit"
                                                :loading="is_btn_loading"
                                                dusk="signin-signin"
                                                type="is-primary">Sign In</b-button>
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

                        <!--<div class="or  has-margin-top-10 is-full-width">
                            <div class="columns">
                                <div class="column">
                                    <hr>
                                </div>
                                <div class="column is-1">
                                    <p class="has-margin-top-10">or</p>
                                </div>
                                <div class="column">
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="social-links">
                            <ul>
                                <li class="is-inline-block has-background-primary has-padding-10 is-rounded has-margin-right-20">
                                    <a href="#">
                                        <b-icon
                                            pack="fab"
                                            icon="facebook"
                                            size="is-medium" class="has-text-white">
                                        </b-icon>
                                    </a>
                                </li>
                                <li class="is-inline-block has-background-info has-padding-10 is-rounded has-margin-right-20">
                                    <a href="#">
                                        <b-icon
                                            pack="fab"
                                            icon="twitter"
                                            size="is-medium" class="has-text-white">
                                        </b-icon>
                                    </a>
                                </li>
                                <li class="is-inline-block has-background-danger has-padding-10 is-rounded">
                                    <a href="#">
                                        <b-icon
                                            pack="fab"
                                            icon="instagram"
                                            size="is-medium" class="has-text-white">
                                        </b-icon>
                                    </a>
                                </li>
                            </ul>
                        </div>-->


                        <Footer/>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>


</template>

