//#########################Vue#################################################
const app = new VueCommon({
    el: '#app',
    data: {

        urls: [],
        list: {},
        active_step: 'database',
        flash_message: null,
        active_el: null,
        app_info: {
            app_name: null,
            db_host: null,
            db_port: null,
            db_database: null,
            db_username: null,
            db_password: null,
        },
        admin_info: {
            first_name: null,
            last_name: null,
            email: null,
            country_calling_code: "",
            phone: null,
            username: null,
            password: null,
        },


    },
    mounted: function () {
        //---------------------------------------------------------------
        this.urls.current = window.location.href;
        //---------------------------------------------------------------
        this.checkStatus();
        //---------------------------------------------------------------
        //---------------------------------------------------------------
    },
    methods:{
        //---------------------------------------------------------------------
        checkStatus: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/check/status";
            var params = {};
            this.processHttpRequest(url, params, this.checkStatusAfter);
        },
        //---------------------------------------------------------------------
        checkStatusAfter: function (data) {

            this.active_step = data.active_step;
            this.flash_message = data.flash_message;

            this.stopNprogress();
        },
        //---------------------------------------------------------------------
        storeAppInfo: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/store/app/info";
            var params = this.app_info;



            this.processHttpRequest(url, params, this.storeAppInfoAfter);
        },
        //---------------------------------------------------------------------
        storeAppInfoAfter: function (data) {

            this.active_step = 'run_migrations';


            this.stopNprogress();
        },

        //---------------------------------------------------------------------
        runMigrations: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/run/migrations";
            var params = {};
            this.processHttpRequest(url, params, this.runMigrationsAfter);
        },
        //---------------------------------------------------------------------
        runMigrationsAfter: function (data) {

            this.active_step = 'create_admin_account';

            this.consoleLog(this.active_step);

            this.stopNprogress();
        },
        //---------------------------------------------------------------------
        storeAdminUser: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/store/admin";
            var params = this.admin_info;
            this.processHttpRequest(url, params, this.storeAdminUserAfter);
        },
        //---------------------------------------------------------------------
        storeAdminUserAfter: function (data) {

            this.flash_message = data.flash_message;
            window.location = data.redirect_url;

            this.stopNprogress();
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
});


//#########################jQuery##############################################

(function (document, window, $) {



})(document, window, jQuery);