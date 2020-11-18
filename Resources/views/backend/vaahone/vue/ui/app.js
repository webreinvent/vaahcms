window.Vue = require('vue');

//---------Package imports
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueHighlightJS from 'vue-highlightjs'
import VaahVueClickToCopy from 'vaah-vue-clicktocopy';
//---------/Package imports

//---------Configs
Vue.config.delimiters = ['@{{', '}}'];
Vue.config.async = false;
//---------Configs

import vaah from './vaahvue/helpers/VaahHelper';

//---------Helpers
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueHighlightJS);
Vue.use(vaah);
Vue.component('vh-copy', VaahVueClickToCopy);
//---------/Helpers

//--------FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(fas, far, fab);
Vue.component('font-awesome-icon', FontAwesomeIcon);
//--------/FontAwesome

//---------Buefy

Vue.component('vue-fontawesome', FontAwesomeIcon);
import Buefy from 'buefy';
Vue.use(Buefy, {
    "css": true,
    defaultIconPack: 'fas',
    defaultIconComponent: 'vue-fontawesome',
    defaultContainerElement: '#content',
});
//---------/Buefy

//---------Variables
var base_url = document.getElementsByTagName('base')[0]
    .getAttribute("href");
var current_url = document.getElementById('current_url').getAttribute('content');
var debug = document.getElementById('debug').getAttribute('content');
//---------/Variables

//---------Store
import {store} from './store/store';
//---------/Store

//---------Routes
import router from './routes/router';
//---------/Routes


const app = new Vue({
    el: '#app',
    components:{

    },
    store: store,
    router,
    data: {
    },
    mounted() {
    },
    methods:{
    }
});
