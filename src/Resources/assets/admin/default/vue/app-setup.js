require('./../lib/vue/bootstrap');

window.Vue = require('vue');


//---------Package imports
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'moment'
import VueHelpers from './helpers/VueHelpers';
//---------/Package imports

//---------Configs
Vue.config.delimiters = ['@{{', '}}'];
//Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
Vue.config.async = false;
//---------Configs

//---------Helpers
Vue.prototype.moment = moment;
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueHelpers);
//---------/Helpers

//---------Comp Imports
import ModulesInstalled from './components/ModulesInstalled';
import ModulesAdd from './components/ModulesAdd';
//---------/Comp Imports



//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

const app = new Vue({
    el: '#vh-app-setup',
    data: {
        urls: {
            base: base_url,
            current: current_url,
        },
        list: {},
        active_step: null,
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

    mounted() {


        //---------------------------------------------------------------
        this.checkStatus();
        //---------------------------------------------------------------
    },
    methods:{

        //-----------------------------------------------------------

        //-----------------------------------------------------------
        checkStatus: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/check/status";
            var params = {};
            this.$helpers.ajax(url, params, this.checkStatusAfter);
        },
        //---------------------------------------------------------------------
        checkStatusAfter: function (data) {

            this.active_step = data.active_step;
            this.flash_message = data.flash_message;

            this.$helpers.stopNprogress();
        },
        //---------------------------------------------------------------------
        storeAppInfo: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/store/app/info";
            var params = this.app_info;

            this.$helpers.ajax(url, params, this.storeAppInfoAfter);
        },
        //---------------------------------------------------------------------
        storeAppInfoAfter: function (data) {

            this.active_step = 'run_migrations';


            this.$helpers.stopNprogress();
        },

        //---------------------------------------------------------------------
        runMigrations: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/run/migrations";
            var params = {};
            this.$helpers.ajax(url, params, this.runMigrationsAfter);
        },
        //---------------------------------------------------------------------
        runMigrationsAfter: function (data) {

            this.active_step = 'create_admin_account';

            this.consoleLog(this.active_step);

            this.$helpers.stopNprogress();
        },
        //---------------------------------------------------------------------
        storeAdminUser: function (e) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.urls.current+"/store/admin";
            var params = this.admin_info;
            this.$helpers.ajax(url, params, this.storeAdminUserAfter);
        },
        //---------------------------------------------------------------------
        storeAdminUserAfter: function (data) {

            this.flash_message = data.flash_message;
            window.location = data.redirect_url;

            this.$helpers.stopNprogress();
        },
        //-----------------------------------------------------------

        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});