<script src="./IndexJs.js"></script>
<template>

    <div v-if="assets">
        <!--sections-->
        <section class="hero">
            <div class="hero-body">

                <!--container-->
                <div class="container  has-text-centered">

                    <Logo/>

                    <VueErrors/>

                    <VueMessages/>




                </div>
                <!--/container-->

            </div>
        </section>
        <!--sections-->

        <!--sections-->
        <section class="section">
            <div class="container">

                <!--columns-->
                <div class="columns">
                    <div class="column is-half is-offset-one-quarter has-text-centered">
                        <b-notification type="is-success"
                                        v-if="assets.is_installed">
                            VaahCMS is successfully Setup
                        </b-notification>
                    </div>
                </div>
                <!--/columns-->

            </div>
        </section>
        <!--sections-->

        <!--sections-->
        <section class="section" >
            <div class="container has-text-centered">


                <b-button v-if="!assets.is_installed"
                          icon-left="server"
                          tag="router-link"
                          :to="{name:'setup.install.configuration'}"
                          type="is-primary" >
                    Install
                </b-button>
                <b-button icon-left="redo" type="is-danger">
                    Reset
                </b-button>
                <b-button icon-left="sync-alt" type="is-warning">
                    Reconfigure
                </b-button>
            </div>
        </section>
        <!--sections-->



    </div>


</template>

