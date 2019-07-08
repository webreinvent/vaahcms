import pagination from 'laravel-vue-pagination';

    export default {

        props: ['urls', 'id'],
        components:{
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
                var url = this.urls.current+"/users/"+this.id;

                if(!page)
                {
                    page = this.page;
                }

                this.$helpers.console(page, 'page');

                url = url+"?page="+page;

                if(this.filters.q)
                {
                    url = url+"&q="+this.filters.q;
                }

                var params = {};
                this.$helpers.ajax(url, params, this.getListAfter);
            },
            //---------------------------------------------------------------------
            getListAfter: function (data) {

                this.$helpers.console(data);

                this.list = data.list;
                this.page = data.list.current_page;
                this.item = data.item;

                this.$helpers.stopNprogress();
            },

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
                this.getList(this.page);
                this.emitReloadList();
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

                this.actions(false, 'toggle_user_active_status', inputs, data)

            },
            //---------------------------------------------------------------------
            emitReloadList: function () {
                this.$root.$emit('reloadList');
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }