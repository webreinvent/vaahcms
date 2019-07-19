import pagination from 'laravel-vue-pagination';

    export default {

        computed:{
            ajax_url(){
                let ajax_url = this.$store.state.urls.registrations;
                return ajax_url;
            }
        },
        components:{
            'pagination': pagination
        },
        data()
        {
            let obj = {
                q: null,
                assets: null,
                page: 1,
                list: null,
                show_filters: false,
                table_collapsed: false,
                select_all: false,
                selected_items: [],
                bulk_action: "",
                bulk_action_data: "",
                filters: {
                    q: null,
                    sort_by: "",
                    sort_type: 'desc',
                    status: 'all',
                    recount: false
                },

            };

            return obj;
        },
        watch: {

            '$route' (to, from) {
                this.setTableCollapseStatus();
            },


        },
        mounted() {

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            this.getAssets();
            this.getList();
            this.setTableCollapseStatus();
            //---------------------------------------------------------------------
            this.$root.$on('reloadList', () => {
                this.getList();
            })
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            reloadList: function()
            {
                this.filters.recount = true;
                this.getList();
            },
            //---------------------------------------------------------------------
            getAssets: function () {
                let assets = this.$store.state.registrations.assets;
                if(assets)
                {
                    this.assets = assets;
                }else{
                    var url = this.ajax_url+"/assets";
                    var params = {};
                    this.$vaahcms.ajax(url, params, this.getAssetsAfter);
                }
            },
            //---------------------------------------------------------------------
            getAssetsAfter: function (data) {
                this.assets = data;
                this.$store.commit('updateRegistrationsAssets', data);
                this.$vaahcms.stopNprogress();
            },
            //---------------------------------------------------------------------

            getList: function (page) {


                this.$vaahcms.console(this.ajax_url, 'this.urls');

                var url = this.ajax_url+"/list";

                this.$vaahcms.console(url, 'url');

                if(!page || isObject(page))
                {
                    page = this.page;
                }

                this.$vaahcms.console(page, 'page');

                url = url+"?page="+page;


                if(this.filters.q)
                {
                    url = url+"&q="+this.filters.q;
                }

                var params = this.filters;
                this.$vaahcms.ajax(url, params, this.getListAfter);

            },
            //---------------------------------------------------------------------
            getListAfter: function (data) {

                this.list = data.list;
                this.page = data.list.current_page;

                this.$vaahcms.console(this.list);

                this.$vaahcms.stopNprogress();

            },

            //---------------------------------------------------------------------
            toggleShowFilters: function () {

                if(this.show_filters == true)
                {
                    this.show_filters = false;
                } else
                {
                    this.show_filters = true;
                }
            },
            //---------------------------------------------------------------------

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
                this.getList();
            },
            //---------------------------------------------------------------------
            bulkAction: function () {

                var inputs = this.selected_items;
                var data = this.bulk_action_data;
                this.actions(false, this.bulk_action, inputs, data)

            },
            //---------------------------------------------------------------------
            setSorting: function (column_name) {

                if(column_name === this.filters.sort_by)
                {
                    if(this.filters.sort_type === 'desc')
                    {
                        this.filters.sort_type = 'asc';
                    } else
                    {
                        this.filters.sort_type = 'desc';
                    }
                } else
                {
                    this.filters.sort_by = column_name;
                    this.filters.sort_type = 'desc';
                }

                this.getList(this.page);

            },
            //---------------------------------------------------------------------
            setTableCollapseStatus: function () {

                this.$vaahcms.console(this.$route, 'route params-->');

                if(this.$route.path == '/registrations/create' || this.$route.params){
                    this.table_collapsed = true;
                } else
                {
                    this.table_collapsed = false;
                }


            },
            //---------------------------------------------------------------------
            toggleSelectAll: function () {

                var self = this;

                this.$vaahcms.console("test");

                if(this.select_all ===true)
                {
                    this.select_all = false;
                    this.selected_items = [];

                } else
                {
                    this.select_all = true;

                    if(this.list.data)
                    {

                        this.$vaahcms.console(this.list.data);

                        this.list.data.map(function (item) {


                            self.selected_items.push(item.id);

                        })
                    }

                }
            },
            //---------------------------------------------------------------------
            toggleSelectedItem: function (id) {

                this.select_all = false;

                if(this.$vaahcms.existInArray(this.selected_items, id))
                {
                    this.$vaahcms.removeFromArray(this.selected_items, id);
                } else
                {
                    this.selected_items.push(id);
                }
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }