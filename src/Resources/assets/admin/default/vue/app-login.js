import Vue from 'vue';


//---------Package imports
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'moment';
import VaahCms from 'vaahcms-vue-helpers';
import vueJquery from 'vue-jquery'
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
Vue.use(vueJquery);
Vue.use(VaahCms);
//---------/Helpers

//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

const app = new Vue({
    el: '#vh-app-login',
    data: {
        assets: null,
        debug: debug,
        urls: {
            base: base_url,
            current: current_url,
        },
        credentials: {
            email: null,
            password: null,
        }
    },

    mounted() {

    },
    methods:{

        //-----------------------------------------------------------
        postLogin: function (e) {
            e.preventDefault();
            var url = this.urls.current+"/post";
            var params = this.credentials;
            this.$vaahcms.ajax(url, params, this.postLoginAfter);
        },
        //---------------------------------------------------------------------
        postLoginAfter: function (data) {

            window.location = data.redirect_url;
            this.$vaahcms.stopNprogress();
        },
        //-----------------------------------------------------------
        //-----------------------------------------------------------

        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});