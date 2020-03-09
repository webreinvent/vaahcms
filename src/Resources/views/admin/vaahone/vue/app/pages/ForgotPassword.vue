<script src="./ForgotPasswordJs.js"></script>
<template>

    <section class="section">
        <div class="login-form-layout">

            <div class="container">
                <div class="columns is-flex align-items-center justify-center">
                    <div class="column is-4">
                        <div class="login-box box is-flex flex-column align-items-center has-text-centered justify-center">

                            <Logo/>

                            <div class="content has-text-centered has-margin-top-20">
                                <h3 class="title">Forgot Password?</h3>
                                <p class="subtitle">You can recover your password from here.</p>
                            </div>
                            <b-field class="is-full-width has-margin-top-20">
                                <b-input type="email"
                                         placeholder="Enter Email Address"
                                         maxlength="30">
                                </b-input>
                            </b-field>


                            <b-field class="is-full-width has-margin-top-20">
                                <b-input type="text"
                                         placeholder="Enter code to reset the password">
                                </b-input>
                            </b-field>

                            <b-field class="is-full-width has-margin-top-20">
                                <b-input type="password"
                                         placeholder="New Password">
                                </b-input>
                            </b-field>

                            <b-field class="is-full-width has-margin-top-20">
                                <b-input type="password"
                                         placeholder="Confirm Password">
                                </b-input>
                            </b-field>

                            <div class="buttons is-full-width has-margin-top-20">
                                <div class="columns is-full-width">
                                    <div class="column">
                                        <button class="button is-primary is-pulled-left is-full-width">Recover</button>
                                    </div>
                                    <div class="column has-text-right-desktop">
                                        <router-link :to="{name:'sign.in'}">Sign In</router-link>
                                    </div>
                                </div>
                            </div>

                            <Footer/>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


</template>

