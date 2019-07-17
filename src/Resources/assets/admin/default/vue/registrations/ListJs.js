import pagination from 'laravel-vue-pagination';
import {isObject} from "vue-resource/src/util";

//https://github.com/euvl/vue-js-toggle-button
import { ToggleButton } from 'vue-js-toggle-button'

    export default {

        props: ['assets'],
        components:{
            'pagination': pagination,
            'ToggleButton': ToggleButton,
        },
        computed:{
            urls(){

                let urls = this.$store.state.urls;
                urls.request = urls.current+"/registrations";
                return urls;
            }
        },
        data()
        {
            let obj = {
                q: null,
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
            this.getList();
            this.setTableCollapseStatus();
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------

            getList: function (page) {


                this.$vaahcms.console(this.urls, 'this.urls');

                var url = this.urls.request+"/list";

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



                if(this.$route.path == '/registrations/create'
                    || (this.$route.path == '/registrations/view' && this.$route.params.id )
                    || (this.$route.path == '/registrations/edit' && this.$route.params.id )
                )
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

                var url = this.urls.request+"/actions";
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

                this.$vaahcms.console(this.$route.params);

                if(this.$route.params.id)
                {
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