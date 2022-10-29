<script src="./IndexJs.js"></script>
<template>

    <div v-if="root && root.assets && assets">


        <!--sections-->
        <section class="section">
            <div class="container ">


                <div class="columns">
                    <div class="column has-text-centered">
                        <Logo :assets="root.assets" height="40"/>

                        <VueErrors/>

                        <VueMessages/>
                    </div>
                </div>


                <!--columns-->
                <div class="columns is-centered ">
                    <div class="column is-8 has-text-centered">

                        <h3 class="title is-3">Install VaahCMS</h3>

                        <b-steps size="is-small"
                                 v-model="config.active_step"
                                 :has-navigation="false">
                            <b-step-item label="Configuration" icon="cogs"></b-step-item>
                            <b-step-item label="Migrate" icon="database"></b-step-item>
                            <b-step-item label="Dependencies" icon="cubes"></b-step-item>
                            <b-step-item label="Account" icon="user-plus"></b-step-item>
                        </b-steps>

                        <b-tag type="is-dark" v-if="assets.env_file">
                            ACTIVE ENV FILE: <b>{{assets.env_file}}</b>
                        </b-tag>

                    </div>
                </div>
                <!--/columns-->

                <hr/><br/>

                <router-view></router-view>

                <div class="columns">
                    <div class="column has-text-centered">
                        <Footer/>
                    </div>
                </div>

            </div>
        </section>
        <!--sections-->






    </div>


</template>

