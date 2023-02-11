
import {createApp, markRaw} from 'vue';
import { createPinia, PiniaVuePlugin  } from 'pinia'


//-------------PrimeVue Imports

//-------------/PrimeVue Imports

import VueHighlightJS from 'vue3-highlightjs'
import 'highlight.js/styles/solarized-light.css'

//-------------APP

import TopMenu from "./components/molecules/Topnav.vue";
import Sidebar from "./components/molecules/Sidebar.vue";

import { vaah } from './vaahvue/pinia/vaah'
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let assets_path = base_url+"/vaahcms/backend/themes/vaahtwo/assets";
let assets_image_path = assets_path+"/images";

let json_url = base_url+"/backend/json";
let ajax_url = base_url+"/backend";

const app = createApp({
    el: '#themeVaahTwoExtend',
    components: {
        'sidebar': Sidebar,
        'top-menu': TopMenu,
    },
    data() {
        return{
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
                expanded_padding_left: '260px',
                assets_is_fetching: null,
                assets_reload: false,
                permissions: null,
                permissions_reload: false,
                check_logged_in: null,
                is_logged_in: null,
            }
        }
    },
    mounted() {
        this.getAssets();
    },
    methods: {
        getAssets: function () {

            let url = this.root.base_url+'/json/assets';

            vaah().ajax(url,this.getAssetsAfter );
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data, res) {
            if(data){
                this.root.assets = data;

                console.log(data);
            }
        },
    }
});

const pinia = createPinia();
/*pinia.use(({ store }) => {
    // store.$router = markRaw(router)
});*/
app.use(pinia);
app.use(PiniaVuePlugin);
// app.use(router);
//-------------/APP


//-------------PrimeVue Use

app.use(VueHighlightJS);

//-------------/PrimeVue Use


app.mount('#themeVaahTwoExtend');


export { app }
