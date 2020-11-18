<template>

    <div class="container-backend">

        <TopMenu :assets="assets"/>

        <Aside :assets="assets"/>
        <!--sections-->
        <section class="section">

            <div class="container">

                <Notices></Notices>

                <router-view></router-view>

            </div>
        </section>
        <!--sections-->

        <Footer/>

    </div>

</template>

<script src="./BackendJs.js"></script>
