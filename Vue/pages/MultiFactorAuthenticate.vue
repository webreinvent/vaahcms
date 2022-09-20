<script src="./MultiFactorAuthenticateJs.js"></script>
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
                                    <h3 class="title">Multi-Factor Authentication</h3>
                                    <p class="subtitle">You have received an email which contains two factor code.</p>
                                </div>

                                <!--form-->
                                <form class="is-full-width" @submit.prevent="verify()">
                                    <hr class="has-margin-bottom-10"/>


                                    <b-field class="is-full-width has-margin-top-20">
                                        <b-input type="text"
                                                 v-model="verify_item.code"
                                                 placeholder="Enter code"
                                                 dusk="verify-code">
                                        </b-input>
                                    </b-field>



                                    <div class="buttons is-full-width has-margin-top-20">
                                        <div class="columns is-full-width">

                                            <div class="column">
                                                <div class="buttons">
                                                    <b-button native-type="submit"
                                                            :loading="is_btn_loading"
                                                            dusk="signin-signin"
                                                            type="is-primary">Verify
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
                                <!--/form-->

                                <Footer/>

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>


</template>

