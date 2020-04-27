<template>

    <div v-if="assets.vue_notices">

        <div v-for="notice in assets.vue_notices">

            <b-notification type="is-danger"
                            class="has-margin-bottom-5"
                            v-if="notice.meta.is_error"
                            @close="markAsRead(notice)"
                            aria-close-label="Close notification">
                {{notice.meta.message}}
            </b-notification>

            <b-notification type="is-info"
                            class="has-margin-bottom-5"
                            v-else
                            @close="markAsRead(notice)"
                            aria-close-label="Close notification">
                {{notice.meta.message}}
            </b-notification>

        </div>


    </div>


</template>
<script>

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
            ajax_url() {return this.$store.getters['root/state'].ajax_url},
        },
        methods: {
            //---------------------------------------------------------------------
            markAsRead: function () {

            },
            //---------------------------------------------------------------------
            markAsRead: function (item) {
                this.$Progress.start();
                let params = item;
                let url = this.ajax_url+'/notices/mark-as-read';
                this.$vaah.ajax(url, params, this.markAsReadAfter);
            },
            //---------------------------------------------------------------------
            markAsReadAfter: function (data, res) {
                this.$Progress.finish();
                if(data){
                    this.update('list', data.list);
                }

            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }

</script>

