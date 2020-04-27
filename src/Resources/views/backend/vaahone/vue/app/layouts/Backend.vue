<template>

    <div class="container-backend">

        <TopMenu/>


        <Aside/>
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
