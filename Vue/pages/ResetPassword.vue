<script src="./ResetPasswordJs.js"></script>
<template>

    <section class="section">
        <div class="login-form-layout">

            <div class="container">
                <div class="columns is-flex align-items-center justify-center">
                    <div class="column is-4">
                        <div class="login-box box is-flex flex-column
                        align-items-center has-text-centered justify-center">

                            <Logo height="35"/>

                            <div class="content has-text-centered has-margin-top-20">
                                <h3 class="title">Reset Password?</h3>
                                <p class="subtitle">You can reset your password from here.</p>
                            </div>

                            <form class="is-full-width" @submit.prevent="onResetPassword">
                                <b-field class="is-full-width has-margin-top-20">
                                    <b-input type="password"
                                             v-model="credentials.password"
                                             placeholder="New Password">
                                    </b-input>
                                </b-field>

                                <b-field class="is-full-width has-margin-top-20">
                                    <b-input type="password"
                                             v-model="credentials.password_confirmation"
                                             placeholder="Confirm Password">
                                    </b-input>
                                </b-field>

                                <div class="buttons is-full-width has-margin-top-20">
                                    <div class="columns is-full-width">
                                        <div class="column">
                                            <div class="buttons">
                                                <b-button native-type="submit"
                                                          :loading="is_btn_loading"
                                                          dusk="signin-signin"
                                                          type="is-primary">
                                                    Recover</b-button>
                                            </div>
                                        </div>
                                        <div class="column has-text-right-desktop">
                                            <router-link :to="{name:'sign.in'}">Sign In</router-link>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </section>


</template>
