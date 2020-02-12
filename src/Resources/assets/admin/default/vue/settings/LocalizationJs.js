

export default {

    props: [],
    computed:{
        ajax_url(){
            let ajax_url = this.$store.state.urls.roles;
            return ajax_url;
        }
    },
    components:{

    },
    data()
    {
        let obj = {
            q: null,
            assets:{
                categories:[
                    {
                        name: "General"
                    },
                    {
                        name: "Login"
                    }
                ]
            },
            bulk_action: "",
            bulk_action_data: "",
            filters: {
                q: null,
                sort_by: "",
                sort_type: 'desc',
                status: 'all',
                recount: false
            },
            list: null
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

        getList: function () {

        },

        //---------------------------------------------------------------------
        bulkAction: function () {

            var inputs = this.selected_items;
            var data = this.bulk_action_data;
            this.actions(false, this.bulk_action, inputs, data)

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
