<template>

    <div class="container-backend">

        <Sidebar />

        <div v-bind:style="{ paddingLeft: root.has_padding_left }">

        <TopMenu />

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
