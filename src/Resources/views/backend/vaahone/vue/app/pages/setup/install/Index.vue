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
            <div class="container ">



                <!--columns-->
                <div class="columns">
                    <div class="column is-half is-offset-one-quarter has-text-centered">

                        <h3 class="title is-3">Install VaahCMS</h3>

                        <b-steps size="is-small" :has-navigation="false">
                            <b-step-item label="Configuration" icon="cogs"></b-step-item>
                            <b-step-item label="Database" icon="database"></b-step-item>
                            <b-step-item label="Dependencies" icon="cubes"></b-step-item>
                            <b-step-item label="Account" icon="user-plus"></b-step-item>
                        </b-steps>
                    </div>
                </div>
                <!--/columns-->

                <router-view></router-view>

            </div>
        </section>
        <!--sections-->






    </div>


</template>

