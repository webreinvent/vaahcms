import {VaahHelper as Vaah} from "../../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/settings/general";


export default {
    namespaced: true,
    //=========================================================================
    state: {
        base_url: base_url,
        ajax_url: ajax_url,
        assets: null,
        assets_is_fetching: false,
        list: null,
        settings:{
            list: null,
            links: [],
            scripts: null,
            meta_tags: [],
        },

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
        async getAssets({ state, commit, dispatch, getters }) {

                let url = state.ajax_url+'/assets';
                let params = {};
                console.log(url);
                let data = await Vaah.ajax(url, params);
                let payload = {
                    key: 'assets',
                    value: data.data.data
                };

                commit('updateState', payload);
        },
        //-----------------------------------------------------------------
        updateView({ state, commit, dispatch, getters }, payload) {
            let list_view = false;
            if(payload && payload.name && payload.name == 'role.list')
            {
                list_view = true;
            }
            let view = {
                key: 'list_view',
                value: list_view
            };
            commit('updateState', view);
        },
        //-----------------------------------------------------------------
    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        base_url(state) {return state.base_url;},
        ajax_url(state) {return state.ajax_url;},
        assets(state) {return state.assets;},
        query_string(state) {return state.query_string;},
        list(state) {return state.list;},
        settings(state) {return state.settings;},
    }

}
