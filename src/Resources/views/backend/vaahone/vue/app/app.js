window.Vue = require('vue');

window.$ = require('jquery');
window.JQuery = require('jquery');



//---------Package imports
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueFuse from 'vue-fuse'
import VueProgressBar from 'vue-progressbar'

import vueFilePond, {setOptions} from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
import FilePondPluginFileRename from 'filepond-plugin-file-rename';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

import VaahVuePagination from 'vaah-vue-pagination'
import VaahVueClickToCopy from 'vaah-vue-clicktocopy'
//---------/Package imports

//---File Uploader
setOptions({
    allowDrop: true,
    allowReplace: false,
    instantUpload: false,
});
const FilePond = vueFilePond( FilePondPluginFileValidateType, FilePondPluginImagePreview,
    FilePondPluginImageEdit, FilePondPluginImageCrop, FilePondPluginFileRename,
    FilePondPluginFileValidateSize  );
//---/File Uploader

//---------Configs
Vue.config.delimiters = ['@{{', '}}'];
Vue.config.async = false;
//---------Configs



import vaah from './vaahvue/helpers/VaahHelper';

//---------Helpers
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuex);
Vue.use(VueFuse);
Vue.use(vaah);
//---------/Helpers


Vue.component('file-pond', FilePond);

//--------Progress
const options = {
    color: '#7a58d5',
    failedColor: '#7a58d5',
    thickness: '2px',
    transition: {
        speed: '0.2s',
        opacity: '0.8s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueProgressBar, options);
//--------/Progress

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


Vue.component('vh-pagination', VaahVuePagination);
Vue.component('vh-copy', VaahVueClickToCopy)

//---------Variables
var base_url = $('base').attr("href");
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
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
    created () {
        this.$Progress.start();
        this.$router.beforeEach((to, from, next) => {
            // pass meta.hide_progress in route's to hide progress
            if (to.meta.hide_progress && to.meta.hide_progress === true) {
                next()
            } else
            {
                this.$Progress.start();
                next()
            }
        });

        this.$router.afterEach((to, from) => {
            this.$Progress.finish()
        });

    },
    mounted() {
        this.$Progress.finish()
    },
    methods:{
    }
});
