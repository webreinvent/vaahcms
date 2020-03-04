import Vue from 'vue';
import { ToastProgrammatic as Toast } from 'buefy'

//---------Variables
var base_url = document.getElementsByTagName('base')[0].getAttribute("href");
var current_url = document.getElementById('current_url').getAttribute('content');
var debug = document.getElementById('debug').getAttribute('content');
var ajax_url = base_url+'/app/ajax';
var json_url = base_url+'/app/ajax/json';
//---------/Variables

var assets_url = json_url+"/assets";
var image_url = base_url+"/vaahcms/themes/themerxconnect/assets/images/";

export default {
    namespaced: true,
    //=========================================================================
    state: {
        debug: debug,
        route: null,
        base_url: base_url,
        image_url: image_url,
        current_url: current_url,
        redirect_full_url: null,
        assets_url: assets_url,
        ajax_url: ajax_url,
        json_url: json_url,
        assets: null,
        check_logged_in: null,
        is_logged_in: null,
        auth_user: null,
        active_app: null,
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

            let data = await dispatch('ajax', payload);

            module_payload = {
                key: 'assets',
                value: data
            };

            commit('updateState', module_payload);

        },
        //-----------------------------------------------------------------

        //-----------------------------------------------------------------
        async ajax({ state, commit, dispatch }, payload) {
            let url = payload.url;
            let params = {};
            let query = {};
            if(payload.params)
            {
                params = payload.params;
            }

            if(payload.query)
            {
                query = {params:payload.query};
            }

            let data = false;
            let self = this;

            console.log('-->url', url);

            data = await Vue.axios.post(url, params, query)
                .then(response => {

                    if(response.data.status)
                    {
                        if(response.data.status == 'failed')
                        {
                            if(response.data.errors)
                            {
                                dispatch('toastErrors', {errors: response.data.errors});
                            }
                            return false;
                        }
                        if(response.data.status == 'success')
                        {
                            if(response.data.messages)
                            {
                                dispatch('toastSuccess', {messages: response.data.messages});
                            }
                            return response.data.data;
                        }
                    }
                })
                .catch(error => {
                    if(state.debug == true)
                    {
                        dispatch('toastErrors', {errors: [error]});
                    } else
                    {
                        dispatch('toastErrors', {errors: ['Something went wrong']});
                    }

                    return false;
                });

            return data;

        },
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
        toastSuccess(context, payload){
            console.log('payload-->', payload);
            payload.messages.forEach(function (message) {
                Toast.open({
                    message: message,
                    type: 'is-success'
                });
            });
        },
        //-----------------------------------------------------------------
        toastErrors(context, payload){
            payload.errors.forEach(function (error) {
                Toast.open({
                    message: error,
                    type: 'is-danger'
                });
            });
        }
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
