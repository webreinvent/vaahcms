require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'moment';

Vue.prototype.moment = moment;

Vue.use(VueResource);
Vue.use(VueRouter);


Vue.config.delimiters = ['@{{', '}}'];

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

Vue.config.async = false;


import TopMenu from './../vue-comp/TopMenu';
import List from './../vue-comp/List';

const router = new VueRouter({
    base: '/apps',
    routes: [
        {   path: '/',
            //component: Dashboard
            component: List
        },
    ]
});

var base_url = $('base').attr('href');

console.log('base_url', base_url);


const app = new Vue({
    el: '#app',
    components:{
        'top-menu': TopMenu
    },
    router,
    data: {
        url: "testing url"
    },
    mounted() {

    },
    methods:{

        //-----------------------------------------------------------

        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});