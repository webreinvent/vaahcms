import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/registrations";

console.log('--->ajax_url', ajax_url);

export default {
    namespaced: true,
    //=========================================================================
    state: {
        ajax_url: ajax_url,
        assets: null,
        assets_is_fetching: false,
        list: null,
        list_is_empty: false,
        active_item: null,
        filters: {
            q: null,
        },
        is_list_loading: false,
        is_item_loading: false,
        new_item:{
            email: null,
            username: null,
            password: null,
            display_name: null,
            title: null,
            first_name: null,
            middle_name: null,
            last_name: null,
            gender: null,
            country_calling_code: null,
            phone: null,
        }
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

            if(state.assets_is_fetching === false && !state.assets)
            {
                let payload = {
                    key: 'assets_is_fetching',
                    value: true
                };
                commit('updateState', payload);

                let url = state.ajax_url+'/assets';
                let params = {};
                let data = await Vaah.ajax(url, params);
                payload = {
                    key: 'assets',
                    value: data.data.data
                };

                commit('updateState', payload);
            }
        },
        //-----------------------------------------------------------------
    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        ajax_url(state) {return state.ajax_url;},
        assets(state) {return state.assets;},
        new_item(state) {return state.new_item;},
    }

}
