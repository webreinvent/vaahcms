window.Vue = require('vue');

window.$ = require('jquery');
window.JQuery = require('jquery');



//---------Package imports
import axios from 'axios';
import VueAxios from 'vue-axios';
//---------/Package imports


//---------Configs
Vue.config.delimiters = ['@{{', '}}'];
Vue.config.async = false;
//---------Configs

import vaah from './vaahvue/helpers/VaahHelper';

//---------Helpers
Vue.use(VueAxios, axios);
Vue.use(vaah);
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
    "css": false,
    defaultIconPack: 'fas',
    defaultIconComponent: 'vue-fontawesome',
});
//---------/Buefy

//---------Variables
var base_url = $('base').attr("href");
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables


import TopMenu from "./components/App/TopMenu.vue";
import Sidebar from "./components/App/Sidebar.vue";

Vue.component('Sidebar', Sidebar);

Vue.component('TopMenu', TopMenu);

const appExtended = new Vue({
    el: '#appExtended',
    components: {
    },
    data: {
        assets: null,
        base_url: base_url,
    },
    mounted() {
        this.getAssets();
    },
    methods:{
        //---------------------------------------------------------------------
        getAssets: function () {
            let params = {};
            let url = this.base_url+'/backend/json/assets';
            this.$vaah.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data, res) {
            if(data){
                this.assets = data;
            }
        },
        //---------------------------------------------------------------------
    }
});
