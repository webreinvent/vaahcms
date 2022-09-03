<template>

<b-menu class="is-light">
    <b-menu-list label="Advanced">
        <b-menu-item :label="'Logs ('+advanced_count.logs+')'"
                     icon="clipboard-list"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/logs')"
                     :to="{name: 'logs.list'}">
        </b-menu-item>
        <b-menu-item :label="'Jobs ('+advanced_count.jobs+')'"
                     icon="hourglass-half"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/jobs')"
                     :to="{name: 'jobs.list'}">
        </b-menu-item>

        <b-menu-item :label="'Failed Jobs ('+advanced_count.failed_jobs+')'"
                     icon="times-circle"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/jobs-failed')"
                     :to="{name: 'jobs.failed.list'}">
        </b-menu-item>

        <b-menu-item :label="'Batches ('+advanced_count.batches+')'"
                     icon="layer-group"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/batches')"
                     :to="{name: 'batches.list'}">
        </b-menu-item>

    </b-menu-list>
</b-menu>

</template>

<script>


    export default {
        name: "AsideMenu",
        computed:{
            root() {return this.$store.getters['root/state']},

        },

        data()
        {
            return {
                advanced_count:[],
                reload_list_time: 60000, // reload in 60 seconds
            }
        },
        mounted() {

            this.onLoad();

            //---------------------------------------------------------------------
            let self = this;
            this.interval = setInterval(
                function() {
                    self.getCountList();
                }, self.reload_list_time);
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            onLoad: function()
            {
                this.getCountList();
            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            getCountList: function () {
                let url = this.root.ajax_url+'/vaah/advanced/getCountList';
                this.$vaah.ajaxGet(url, this.query_string, this.getCountListAfter);
            },
            //---------------------------------------------------------------------
            getCountListAfter: function (data, res) {

                if(data){
                    this.advanced_count = data;
                }

            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }
</script>

<style scoped>

</style>
