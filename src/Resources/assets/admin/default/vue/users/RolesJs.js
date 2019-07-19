import pagination from 'laravel-vue-pagination';
import TableLoader from "./../reusable/TableLoader";


    export default {

        props: ['urls', 'id'],
        computed:{
            ajax_url(){
                let ajax_url = this.$store.state.urls.users;
                return ajax_url;
            }
        },
        components:{
            't-loader': TableLoader,
            'pagination': pagination,
        },
        data()
        {
            let obj = {
                list: null,
                item: null,
                page: 1,
                filters: {
                    q: null,
                },
                permission: null,
            };
            return obj;
        },
        watch: {

            id: function (newVal, oldVal) {
                this.getList();
            }

        },
        mounted() {

            //---------------------------------------------------------------------
            this.getList();
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            getList: function (page) {
                this.list = null;

                var url = this.ajax_url+"/roles/"+this.id;

                if(!page)
                {
                    page = this.page;
                }

                this.$vaahcms.console(page, 'page');
                url = url+"?page="+page;
                if(this.filters.q)
                {
                    url = url+"&q="+this.filters.q;
                }
                var params = {};
                this.$vaahcms.ajax(url, params, this.getListAfter);
            },
            //---------------------------------------------------------------------
            getListAfter: function (data) {

                this.$vaahcms.console(data);

                this.list = data.list;
                this.page = data.list.current_page;
                this.item = data.item;

                this.$vaahcms.stopNprogress();
            },

            //---------------------------------------------------------------------
            actions: function (e, action, inputs, data) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.ajax_url+"/actions";
                var params = {
                    action: action,
                    inputs: inputs,
                    data: data,
                };

                this.$vaahcms.ajax(url, params, this.actionsAfter);
            },
            //---------------------------------------------------------------------
            actionsAfter: function (data) {
                this.getList(this.page);
                this.emitListReload();
            },
            //---------------------------------------------------------------------
            toggleActiveStatus: function (item) {
                var inputs = {id: this.id, user_id: item.id};
                var data = {};

                if(item.pivot.is_active)
                {
                    data.is_active = 0;
                } else
                {
                    data.is_active = 1;
                }

                this.actions(false, 'toggle_role_active_status', inputs, data)

            },
            //---------------------------------------------------------------------
            emitListReload: function () {
                this.$root.$emit('eListReload');
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }