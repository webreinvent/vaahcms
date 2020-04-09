let namespace = 'users';
export default {
    computed: {
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
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
    mounted(){

    },

    watch: {

    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        setRowClass: function(row, index)
        {

            if(this.page.active_item && row.id == this.page.active_item.id)
            {
                return 'is-selected';
            }

            if(row.deleted_at != null)
            {
                return 'is-danger';
            }

        },
        //---------------------------------------------------------------------
        setActiveItem: function (item) {
            this.update('active_item', item);
            this.$router.push({name: 'user.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        getRole: function (item) {
            this.update('active_item', item);
            this.$router.push({name: 'user.role', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        changeStatus: function (id) {
            this.$Progress.start();
            let url = this.ajax_url+'/actions/bulk-change-status';
            let params = {
                inputs: [id],
                data: null
            };
            this.$vaah.ajax(url, params, this.changeStatusAfter);
        },
        //---------------------------------------------------------------------
        changeStatusAfter: function (data,res) {
            this.$root.$emit('eReloadList');
            this.update('is_list_loading', false);

        }, copiedData: function (data) {

            this.$vaah.toastSuccess(['copied']);

            // alertify.success('copied');

            this.$vaah.console(data, 'copied data');

        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
