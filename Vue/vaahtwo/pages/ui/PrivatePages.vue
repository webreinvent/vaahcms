<template>
    <Topnav></Topnav>
    <Sidebar></Sidebar>
    <div class="grid main-container">
        <div class="col-12">
            <RouterView></RouterView>
        </div>
    </div>
</template>

<script>
import Topnav from "../../components/organisms/Topnav.vue";
import Sidebar from "../../components/organisms/Sidebar.vue";
export default {
    name: "PrivatePages",
    components:{Topnav,Sidebar}
}
</script>

<style scoped>

</style>
