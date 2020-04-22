import {VaahHelper as Vaah} from "../../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/settings/backups";


export default {
    namespaced: true,
    //=========================================================================
    state: {
        ajax_url: ajax_url,
        assets: null,
        assets_is_fetching: false,
        list: null,
        list_is_empty: false,
        filters: {
            q: null,
        },
        is_list_loading: false,
        is_item_loading: false,
        list_view: true,
        show_filters: false,
        query_string: {
            page: 1,
            q: null,
            trashed: null,
            filter: null,
        },
        bulk_action:{
            selected_items: [],
            data: {},
            action: null,
        },
        new_item:{
            name: null,
            slug: null,
            is_active: null,
            details: null,
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
        ajax_url(state) {return state.ajax_url;},
        assets(state) {return state.assets;},
        query_string(state) {return state.query_string;},
    }

}
