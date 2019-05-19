export default {

    props: ['urls'],

    data()
    {
        let obj = {

            assets: null
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

        getModules: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.assets.vaahcms_api_route;

            this.$helpers.console(url, 'url');

            var params = {};
            this.$helpers.ajax(url, params, this.getModulesAfter);
        },
        //---------------------------------------------------------------------
        getModulesAfter: function (data) {

            this.$helpers.console(data);

            this.$helpers.stopNprogress();
        },

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}