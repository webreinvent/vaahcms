require('./../../lib/vue/bootstrap');

window.Vue = require('vue');


//---------Package imports
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'moment'

import VueHelpers from './../helpers/VueHelpers';
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
import List from './List';
import Create from './Create';
import ViewEdit from './ViewEdit';
import Users from './Users';
import Permissions from './Permissions';
//---------/Comp Imports

//---------Routes
const router = new VueRouter({
    base: '/',
    linkActiveClass: "active",
    routes: [
        {
            path: '/create',
            component: Create
        },
        {
            path: '/view/:id',
            component: ViewEdit,
            props: true
        },
        {
            path: '/users/:id',
            component: Users,
            props: true
        },
        {
            path: '/permissions/:id',
            component: Permissions,
            props: true
        },
    ]
});
//---------/Routes

//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

const app = new Vue({
    el: '#vh-app-roles',
    components:{
        'list': List
    },
    router,
    data: {
        assets: null,
        debug: debug,
        reload_counter: 0,
        urls: {
            base: base_url,
            current: current_url,
        }
    },

    mounted() {
        this.getAssets();
    },
    methods:{

        //-----------------------------------------------------------
        getAssets: function () {
            var url = this.urls.current+"/assets";
            var params = {};
            this.$helpers.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data) {

            this.assets = data;

            this.$helpers.stopNprogress();

        },
        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});