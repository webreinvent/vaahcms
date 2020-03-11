import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
var token = $('#_token').attr('content');
//---------/Variables

export const store = new Vuex.Store({
    state: {
        debug: debug,
        csrf_token: token,
        urls: {
            base: base_url,
            current: current_url,
            registrations: current_url+'/registrations',
            users: current_url+'/users',
            roles: current_url+'/roles',
            permissions: current_url+'/permissions',
            modules: current_url+'/modules',
            themes: current_url+'/themes',
        },
        registrations: {
            assets: null,
            table_collapsed: false,
        },
        users: {
            assets: null,
            table_collapsed: false,
        },
        roles: {
            assets: null,
            table_collapsed: false,
        },
        permissions: {
            assets: null,
            table_collapsed: false,
        },
        modules: {
            assets: null,
            table_collapsed: false,
        },
        themes: {
            assets: null,
            table_collapsed: false,
        }
    },
    mutations:{
        updateAssets: function (state, payload) {
            state[payload.type].assets = payload;
        }
    },
    actions:{

    },
    getters:{
        state(state) {return state;},
    }
});
