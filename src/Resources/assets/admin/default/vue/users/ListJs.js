import pagination from 'laravel-vue-pagination';
import {isObject} from "vue-resource/src/util";

//https://github.com/euvl/vue-js-toggle-button
import { ToggleButton } from 'vue-js-toggle-button'

//https://github.com/voerro/vue-tagsinput

    export default {

        props: ['urls', 'assets', 'reload_counter'],
        components:{
            'pagination': pagination,
            'ToggleButton': ToggleButton,
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
                }
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
            this.getList();
            this.setTableCollapseStatus();
            //---------------------------------------------------------------------
            this.$root.$on('reloadList', () => {
                this.getList();
            })
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------

            getList: function (page) {


                var url = this.urls.current+"/list";

                if(!page || isObject(page))
                {
                    page = this.page;
                }

                this.$helpers.console(page, 'page');

                url = url+"?page="+page;


                if(this.filters.q)
                {
                    url = url+"&q="+this.filters.q;
                }

                var params = this.filters;
                this.$helpers.ajax(url, params, this.getListAfter);

            },
            //---------------------------------------------------------------------
            getListAfter: function (data) {

                this.list = data.list;
                this.page = data.list.current_page;

                this.$helpers.console(this.list);

                this.$helpers.stopNprogress();

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

                var url = this.urls.current+"/actions";
                var params = {
                    action: action,
                    inputs: inputs,
                    data: data,
                };

                this.$helpers.ajax(url, params, this.actionsAfter);
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
            changeActiveStatus: function(item)
            {
                var inputs = {id: item.id};
                var data = {};

                if(item.is_active)
                {
                    data.is_active = 0;
                } else
                {
                    data.is_active = 1;
                }

                this.actions(false, 'change_active_status', inputs, data)
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

                this.$helpers.console(this.$route.path);

                if(this.$route.params.id || this.$route.path == '/create' )
                {
                    this.table_collapsed = true;
                } else
                {
                    this.table_collapsed = false;
                }

                this.$helpers.console(this.table_collapsed);

            },
            //---------------------------------------------------------------------
            toggleSelectAll: function () {

                var self = this;

                this.$helpers.console("test");

                if(this.select_all ===true)
                {
                    this.select_all = false;
                    this.selected_items = [];

                } else
                {
                    this.select_all = true;

                    if(this.list.data)
                    {

                        this.$helpers.console(this.list.data);

                        this.list.data.map(function (item) {


                            self.selected_items.push(item.id);

                        })
                    }

                }
            },
            //---------------------------------------------------------------------
            toggleSelectedItem: function (id) {

                this.select_all = false;

                if(this.$helpers.existInArray(this.selected_items, id))
                {
                    this.$helpers.removeFromArray(this.selected_items, id);
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