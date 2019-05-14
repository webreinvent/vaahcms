//#########################Vue#################################################
const app = new VueCommon({
    el: '#app',
    data: {

        urls: [],
        list: {},
        active_step: 'database',
        active_el: null,
        app_info: {
            app_name: null,
            db_host: null,
            db_port: null,
            db_database: null,
            db_username: null,
            db_password: null,
        },


    },
    mounted: function () {
        //---------------------------------------------------------------
        this.urls.current = window.location.href;
        //---------------------------------------------------------------

        //---------------------------------------------------------------

        //---------------------------------------------------------------
        //---------------------------------------------------------------
    },
    methods:{
        //---------------------------------------------------------------------
        storeAppInfo: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/store/app/info";
            var params = this.app_info;

            this.consoleLog(params, 'test');

            this.processHttpRequest(url, params, this.storeAppInfoAfter);
        },
        //---------------------------------------------------------------------
        storeAppInfoAfter: function (data) {

            this.stopNprogress();
        },

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
});


//#########################jQuery##############################################

(function (document, window, $) {



})(document, window, jQuery);