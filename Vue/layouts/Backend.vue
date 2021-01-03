<template>

    <div class="">

        <Sidebar />


        <div v-bind:style="{ paddingLeft: root.has_padding_left }">

        <TopMenu :assets="assets"/>



        <!--sections-->
        <section class="section ">
            <Notices></Notices>
            <router-view></router-view>
        </section>
        <!--sections-->


        <Footer/>


        </div>

    </div>

</template>

<script src="./BackendJs.js"></script>
