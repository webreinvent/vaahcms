import pagination from 'laravel-vue-pagination';
import {isObject} from "vue-resource/src/util";
import { ToggleButton } from 'vue-js-toggle-button'

    export default {

        props: ['urls', 'assets'],
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
                filters: {
                    q: null,
                    sort_by: null,
                    sort_type: 'desc',
                    status: 'all',
                }
            };

            return obj;
        },
        watch: {

            '$route' (to, from) {
                this.setTableCollapseStatus();
            }

        },
        mounted() {

            //---------------------------------------------------------------------
            this.getList();
            this.setTableCollapseStatus();
            //---------------------------------------------------------------------
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

                this.$helpers.console(this.$route.params);

                if(this.$route.params.id)
                {
                    this.table_collapsed = true;
                } else
                {
                    this.table_collapsed = false;
                }


            }
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }