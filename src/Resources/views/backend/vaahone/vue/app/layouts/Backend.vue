<template>

    <div>

        <TopMenu/>

        <!--sections-->
        <section class="section">
            <div class="container">

                <!--columns-->
                <div class="columns">
                    <div class="column is-1">
                        <Aside/>
                    </div>
                    <div class="column is-11">
                        <router-view></router-view>
                    </div>
                </div>
                <!--/columns-->

            </div>
        </section>
        <!--sections-->

        <Footer/>

    </div>

</template>

<script src="./BackendJs.js"></script>
