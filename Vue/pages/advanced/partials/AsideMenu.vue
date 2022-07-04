<template>
<b-menu class="is-light">
    <b-menu-list label="Advanced">
        <b-menu-item :label="setlabel('Logs',assets.advance.count_log_files)"
                     icon="clipboard-list"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/logs')"
                     :to="{name: 'logs.list'}">
        </b-menu-item>
        <b-menu-item :label="setlabel('Jobs',assets.advance.job_count)"
                     icon="hourglass-half"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/jobs')"
                     :to="{name: 'jobs.list'}">
        </b-menu-item>

        <b-menu-item :label="setlabel('Failed Jobs',assets.advance.failed_jobs_count)"
                     icon="times-circle"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/jobs-failed')"
                     :to="{name: 'jobs.failed.list'}">
        </b-menu-item>

        <b-menu-item :label="setlabel('Batches',assets.advance.job_batches_count)"
                     icon="layer-group"
                     tag="router-link"
                     :active="!!($route.path == '/vaah/advanced/batches')"
                     :to="{name: 'batches.list'}">
        </b-menu-item>

    </b-menu-list>

</b-menu>
</template>
<script>
    import jobs from "../../../store/modules/advanced/jobs";
let namespace="AsideMenu";
    export default {
        name: "AsideMenu",
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
            permissions() {return this.$store.getters['root/state'].permissions},
            page() {return this.$store.getters[namespace+'/state']},
            item() {return this.$store.getters[namespace+'/state'].active_item},
            ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
            query_string() {return this.$store.getters[namespace+'/state'].query_string},
        },
        methods:{
            setlabel:function (value,count){
                return value+' ('+count+')'

            }
        }
    }
</script>

<style scoped>

</style>
