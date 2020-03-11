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
        redirect_full_url: null,
        ajax_url: ajax_url,
        json_url: json_url,
        assets: null,
        check_logged_in: null,
        is_logged_in: null,
        auth_user: null,
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
        async getAssets({ state, commit, dispatch }, payload) {
            let module_payload;
            for( let item_key in payload.params)
            {
                module_payload = {
                    key: item_key,
                    value: payload.params[item_key]
                };
                commit('updateState', module_payload);
            }

            payload.url = state.json_url+'/assets';

            console.log('-->payload.url', payload.url);

            //let data = await dispatch('ajax', payload);
            let data = await Vaah.ajax(payload.url, payload.params);

            module_payload = {
                key: 'assets',
                value: data.data.data
            };

            commit('updateState', module_payload);

        },
        //-----------------------------------------------------------------
        //-----------------------------------------------------------------
        async checkIsLoggedIn({ state, commit, dispatch }, payload) {

            payload = {
                url: state.json_url+'/is-logged-in',
                params: {
                    redirect_full_url: state.full_url
                }
            };

            let data = await dispatch('ajax', payload);

            if(data.user)
            {
                this.commit('root/updateState', {key:'check_logged_in', value: true});
                this.commit('root/updateState', {key:'is_logged_in', value: true});

            } else
            {
                this.commit('root/updateState', {key:'is_logged_in', value: false});
            }

        },
        //-----------------------------------------------------------------
        //-----------------------------------------------------------------

    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        assets(state) {return state.assets;},
        is_logged_in(state) {return state.is_logged_in;},
        redirect_full_url(state) {return state.redirect_full_url;},
    }

}
