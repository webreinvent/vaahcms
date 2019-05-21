require('./../lib/vue/bootstrap');

window.Vue = require('vue');


//---Remark Theme Requirement
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


import PageTitle from './components/PageTitle';
import Dashboard from './components/Dashboard';

const router = new VueRouter({
    base: '/',
    linkActiveClass: "active",
    routes: [
        {   path: '/',
            component: Dashboard
        },
        { path: '*', redirect: '/' }
    ]
});


var base_url = $('base').attr('href');

console.log('base_url', base_url);


const app = new Vue({
    el: '#vh-app-dashboard',
    components:{
        'page-title': PageTitle
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