require('./../../lib/vue/bootstrap');

window.Vue = require('vue');


//---Remark Theme Requirement
window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;
require('bootstrap');
require('nprogress');
//---End Remark Theme Requirement

import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'moment'

Vue.prototype.moment = moment;

Vue.use(VueResource);
Vue.use(VueRouter);


Vue.config.delimiters = ['@{{', '}}'];

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

Vue.config.async = false;





import List from './components/List';
import ListView from './components/ListView';


const router = new VueRouter({
    base: '/',
    linkActiveClass: "active",
    routes: [
        {   path: '/',
            //component: Dashboard
            component: List
        },
        {
            path: '/view',
            component: ListView,
        },
        { path: '*', redirect: '/' }
    ]
});


var base_url = $('base').attr('href');

console.log('base_url', base_url);


const app = new Vue({
    el: '#app',
    components:{

    },
    router,
    data: {
        searched: 'searched',
        base_url: base_url,
    },
    mounted() {

    },
    methods:{

        //-----------------------------------------------------------

        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});