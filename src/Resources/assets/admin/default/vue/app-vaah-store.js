import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

export const store = new Vuex.Store({
    state: {
        debug: debug,
        urls: {
            base: base_url,
            current: current_url,
            registrations: current_url+'/registrations',
        },
        registrations: {
            assets: null,
            table_collapsed: false,
        }
    },
    mutations:{
        updateRegistrationsAssets: function (state, payload) {
            state.registrations.assets = payload;
        }
    },
    actions:{

    },
    getters:{

    }
});
