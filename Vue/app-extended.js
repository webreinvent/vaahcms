//window.Vue = require('vue');
import Vue from 'vue';

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


let assets_path = base_url+"/vaahcms/backend/themes/vaahone/assets";
let assets_image_path = assets_path+"/images";

let json_url = base_url+"/backend/json";
let ajax_url = base_url+"/backend";

const appExtended = new Vue({
    el: '#appExtended',
    components: {
        'sidebar': Sidebar,
        'top-menu': TopMenu,
    },
    data: {
        root:{

            assets: null,
            base_url: base_url,
            assets_path: assets_path,
            assets_image_path: assets_image_path,
            current_url: current_url,
            ajax_url: ajax_url,
            json_url: json_url,
            is_sidebar_reduced: true,
            has_padding_left: '55px',
            default_padding_left: '55px',
            expanded_padding_left: '200px',
            assets_is_fetching: null,
            assets_reload: false,
            permissions: null,
            permissions_reload: false,
            check_logged_in: null,
            is_logged_in: null,
        }
    },
    mounted() {
        this.getAssets();

    },
    methods:{
        //---------------------------------------------------------------------
        getAssets: function () {
            let params = {};
            let url = this.root.base_url+'/backend/json/assets';
            this.$vaah.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data, res) {
            if(data){
                this.root.assets = data;
            }
        },
        //---------------------------------------------------------------------
        sidebarAction: function (payload)
        {

            console.log('--->payload', payload);

            for (let key in payload)
            {
                this.root[key] = payload[key];
            }

            //this.$root.$emit('root-updated', payload)

        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
});
