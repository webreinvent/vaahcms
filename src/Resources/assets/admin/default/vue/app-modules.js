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


import ModulesInstalled from './components/ModulesInstalled';
import ModulesAdd from './components/ModulesAdd';

const router = new VueRouter({
    base: '/',
    linkActiveClass: "active",
    routes: [
        {   path: '/',
            component: ModulesInstalled
        },
        {   path: '/add',
            component: ModulesAdd
        },
        { path: '*', redirect: '/' }
    ]
});


var base_url = $('base').attr('href');

console.log('base_url', base_url);


const app = new Vue({
    el: '#vh-app-modules',
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