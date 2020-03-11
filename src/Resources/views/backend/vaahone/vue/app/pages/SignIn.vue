<script src="./SignInJs.js"></script>
<template>

    <section class="section ">
        <div class="login-form-layout">
            <div class="container">
                <div class="columns is-flex align-items-center justify-center">
                <div class="column is-4">
                    <div class="login-box box is-flex flex-column align-items-center has-text-centered justify-center">

                        <Logo/>

                        <div class="content has-text-centered has-margin-top-20">
                            <h3 class="title">Sign In</h3>
                            <p class="subtitle">Please Sign In to continue</p>
                        </div>

                        <!--form-->
                        <form class="is-full-width" @submit.prevent="signIn()">
                            <b-field class="is-full-width has-margin-top-20">
                                <b-input type="email"
                                         v-model="credentials.email"
                                         placeholder="Enter Email Address"
                                         dusk="signin-username_or_email"
                                         maxlength="30">
                                </b-input>
                            </b-field>
                            <b-field class="is-full-width">
                                <b-input type="password"
                                         v-model="credentials.password"
                                         placeholder="Enter Password"
                                         dusk="signin-password"
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
                        </form>
                        <!--/form-->

                        <div class="or  has-margin-top-10 is-full-width">
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
                        </div>


                        <Footer/>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>


</template>

