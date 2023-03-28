<template>
    <div class="columns">
        <div class="column is-2">
            <AsideMenu :store="store"/>
        </div>

        <div class="column is-10">
            <div class="container">

                <router-view></router-view>

            </div>
        </div>
    </div>

</template>

<script>
    import AsideMenu from "./partials/AsideMenu.vue";

    export default {

        props: [],
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
        components:{

            AsideMenu

        },
        data()
        {
            let obj = {
                q: null,
            };

            return obj;
        },
        watch: {

        },
        mounted() {

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }
</script>
