import Vue from 'vue';
import { ToastProgrammatic as Toast } from 'buefy'
import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let current_url = document.getElementById('current_url').getAttribute('content');
let debug = document.getElementById('debug').getAttribute('content');
//---------/Variables

let assets_path = base_url+"/vaahcms/backend/themes/vaahone/assets";
let assets_image_path = assets_path+"/images";

let json_url = base_url+"/backend/json";
let ajax_url = base_url+"/backend";

export default {
    namespaced: true,
    //=========================================================================
    state: {
        debug: debug,
        route: null,
        base_url: base_url,
        assets_path: assets_path,
        assets_image_path: assets_image_path,
        current_url: current_url,
        ajax_url: ajax_url,
        json_url: json_url,
        assets: null,
        assets_is_fetching: null,
        permissions: null,
        check_logged_in: null,
        is_logged_in: null,
    },
    //=========================================================================
    mutations:{
        updateState: function (state, payload) {
            state[payload.key] = payload.value;
        },
        //-----------------------------------------------------------------
    },
    //=========================================================================
    actions:{
        //-----------------------------------------------------------------
        async getPermissions({ state, commit, dispatch, getters }) {


            let url = state.ajax_url+'/json/permissions';
            let params = {};
            let data = await Vaah.ajax(url, params);

            let payload = {
                key: 'permissions',
                value: data.data.data.list


            };

            commit('updateState', payload);



        },
        //-----------------------------------------------------------------
        //-----------------------------------------------------------------
    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        assets(state) {return state.assets;},
        permissions(state) {return state.permissions;},
        is_logged_in(state) {return state.is_logged_in;},
    }

}
