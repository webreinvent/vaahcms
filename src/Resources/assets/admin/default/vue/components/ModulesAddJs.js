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
            list: null,
            active_item: null,
            active_el: null,
            filters: {
                q: null
            }
        };

        return obj;
    },
    mounted() {

        //---------------------------------------------------------------------
        this.getAssets();
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

            this.getModules();

        },
        //---------------------------------------------------------------------

        getModules: function (page) {


            var url = this.assets.vaahcms_api_route;

            if(!page)
            {
                page = this.page;
            }

            if(this.page)
            {
                url = url+"?page="+page;
            }

            if(this.filters.q)
            {
                url = url+"&q="+this.filters.q;
            }

            var params = {};

            this.$helpers.console(url, 'url');
            this.$helpers.console(params, 'params');

            this.$helpers.ajax(url, params, this.getModulesAfter);
        },
        //---------------------------------------------------------------------
        getModulesAfter: function (data) {

            this.list = data.list;
            this.page = data.list.current_page;

            this.$helpers.console(this.list);

            this.$helpers.stopNprogress();
        },

        //---------------------------------------------------------------------
        download: function (e, item) {
            if(e)
            {
                e.preventDefault();
            }

            this.active_el = e.target;

            $(this.active_el).closest('.card').find('.progress').removeClass('hide');

            this.active_item = item;
            var url = this.urls.current+"/download";
            var params = this.active_item;
            this.$helpers.ajax(url, params, this.downloadAfter);
        },
        //---------------------------------------------------------------------
        downloadAfter: function (data) {

            $(this.active_el).closest('.card').find('.progress').addClass('hide');
            this.$helpers.stopNprogress();

        },

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}