
window.Vue = require('vue');


//---------Package imports
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import Vuex from 'vuex'
import moment from 'moment'
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
import VaahCms from 'vaahcms-vue-helpers';
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
Vue.use(Vuex);
Vue.use(PerfectScrollbar);
Vue.use(VaahCms);
//---------/Helpers

//---------Import Partials
import TopMenu from './partials/TopMenu';
//---------/Import Partials

//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

let urls = {
    base: base_url,
    current: current_url,
};

//---------Store
import {store} from './app-store';
//---------/Store

//---------Routes
import routes from './app-routes';

const router = new VueRouter({
    base: '/',
    linkActiveClass: "",
    routes: routes
});

//---------/Routes



const app = new Vue({
    el: '#vh-app-vaah',
    components:{
        'top-menu': TopMenu
    },
    store: store,
    router,
    data: {
        assets: null,
        debug: debug,
        urls: urls
    },

    mounted() {

    },
    methods:{

        //-----------------------------------------------------------

        //-----------------------------------------------------------

        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});