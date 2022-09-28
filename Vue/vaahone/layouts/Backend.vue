<template>

    <div class="container-backend">

        <Sidebar :root="root" />

        <div id="container-main" v-bind:style="{ paddingLeft: root.has_padding_left }">

        <TopMenu :root="root"  />

        <!--sections-->
        <section class="section has-padding-top-25 has-padding-left-25">
            <Notices></Notices>
            <router-view></router-view>
        </section>
        <!--sections-->


        <Footer/>


        </div>

    </div>

</template>

<script src="./BackendJs.js"></script>
