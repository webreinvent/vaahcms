<template>

    <div class="container-backend">

        <TopMenu :assets="assets"/>

        <Aside :assets="assets"/>
        <!--sections-->
        <section class="section">
                <Notices></Notices>
                <router-view></router-view>
        </section>
        <!--sections-->

        <Footer/>

    </div>

</template>

<script src="./BackendJs.js"></script>
