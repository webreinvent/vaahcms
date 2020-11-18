<template>
    <div class="pk pagination-container">
        <b-pagination
                @change="paginate"
                :total="list.total"
                :current.sync="list.current_page"
                :range-before="3"
                :range-after="3"
                size="is-small"
                :simple="false"
                :rounded="false"
                :per-page="list.per_page"
                icon-prev="chevron-left"
                icon-next="chevron-right"
                aria-next-label="Next page"
                aria-previous-label="Previous page"
                aria-page-label="Page"
                aria-current-label="Current page">
        </b-pagination>
    </div>
</template>

<script>

    export default {
        name: "Pagination",
        props:['list'],
        components:{
        },
        data()
        {
            let obj = {

            };

            return obj;
        },

        created() {

        },
        watch: {

        },
        methods: {

            //---------------------------------------------------------------------
            paginate: function (next_page) {
                this.$emit('paginateEvent', next_page)
            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
        },
    }
</script>

