import pagination from 'laravel-vue-pagination';

    export default {

        props: ['urls'],
        components:{
            'pagination': pagination,
        },
        data()
        {
            let obj = {
                assets: null,
                q: null,
                page: 1,
                list: null,
                page_reload_required: null,
                stats: null,
                active_tab: 'all',
                active_item: null,
                active_el: null,
                filters: {
                    q: null,
                    status: 'all',
                }
            };

            return obj;
        },
        watch: {



        },
        mounted() {

            //---------------------------------------------------------------------
            this.getAssets();
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            getAssets: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                console.log(this.urls);

                var url = this.urls.current+"/assets";
                var params = {};
                this.$helpers.ajax(url, params, this.getAssetsAfter);
            },
            //---------------------------------------------------------------------
            getAssetsAfter: function (data) {

                this.assets = data;

                this.$helpers.console(this.assets, 'from app->');

                this.getList();

            },
            //---------------------------------------------------------------------

            getList: function (page) {


                var url = this.urls.current+"/list";

                if(!page)
                {
                    page = this.page;
                }

                if(this.page)
                {
                    url = url+"?page="+page;
                }

                url = url+"&status="+this.filters.status;

                if(this.filters.q)
                {
                    url = url+"&q="+this.filters.q;
                }

                var params = {};
                this.$helpers.ajax(url, params, this.getListAfter);

            },
            //---------------------------------------------------------------------
            getListAfter: function (data) {

                this.list = data.list;
                this.stats = data.stats;
                this.page = data.list.current_page;

                this.$helpers.console(this.list);

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
                this.getList();
                this.page_reload_required = 1;
            },
            //---------------------------------------------------------------------
            getSettingValue: function (settings, key, value) {

                this.$helpers.console(settings, 'settings');
                this.$helpers.console(key, 'key');
                this.$helpers.console(value, 'value');

                var item = this.$helpers.findInArrayByKey(settings, key, value);

                return item;
            },
            //---------------------------------------------------------------------
            setFilter: function (e, status) {
                if(e)
                {
                    e.preventDefault();
                }

                this.filters.status = status;

                this.getList();
            },

            //---------------------------------------------------------------------
            getModulesSlugs: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.current+"/get/slugs";
                var params = {};
                this.$helpers.ajax(url, params, this.getModulesSlugsAfter);
            },
            //---------------------------------------------------------------------
            getModulesSlugsAfter: function (data) {
                this.getModulesUpdates(data);
            },
            //---------------------------------------------------------------------
            getModulesUpdates: function (comma_separated_slug) {

                var url = this.assets.vaahcms_api_route+"/module/updates";

                this.$helpers.console(url);

                var params = {slugs: comma_separated_slug};
                this.$helpers.ajax(url, params, this.getModulesUpdatesAfter);
            },
            //---------------------------------------------------------------------
            getModulesUpdatesAfter: function (data) {

                this.updateModuleVersion(data);

            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            updateModuleVersion: function (data) {

                var url = this.urls.current+"/update/versions";
                var params = {modules: data};
                this.$helpers.ajax(url, params, this.updateModuleVersionAfter);
            },
            //---------------------------------------------------------------------
            updateModuleVersionAfter: function (data) {
                this.getList();
            },
            //---------------------------------------------------------------------
            installUpdates: function (e, slug) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.current+"/install/updates";
                var params = {slug: slug};
                this.$helpers.ajax(url, params, this.installUpdatesAfter);
            },
            //---------------------------------------------------------------------
            installUpdatesAfter: function (data) {
                this.getList();
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }