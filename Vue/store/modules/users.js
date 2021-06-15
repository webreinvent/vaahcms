import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/users";


export default {
    namespaced: true,
    //=========================================================================
    state: {
        ajax_url: ajax_url,
        assets: null,
        assets_is_fetching: false,
        list: null,
        total_roles: null,
        list_is_empty: false,
        active_item: null,
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
            roles: [],
            status: null,
        },
        bulk_action:{
            selected_items: [],
            data: {},
            action: null,
        },
        new_item:{
            email: null,
            username: null,
            password: null,
            display_name: null,
            title: null,
            designation: null,
            first_name: null,
            middle_name: null,
            last_name: null,
            gender: null,
            country_calling_code: null,
            phone: null,
            bio: null,
            website: null,
            timezone: null,
            alternate_email: null,
            avatar_url: null,
            birth: null,
            country: null,
            country_code: null,
            status: null,
            is_active: null,
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

            if(state.assets_is_fetching === false && !state.assets)
            {
                let payload = {
                    key: 'assets_is_fetching',
                    value: true
                };
                commit('updateState', payload);

                let url = state.ajax_url+'/assets';
                let params = {};
                let data = await Vaah.ajaxGet(url, params);
                payload = {
                    key: 'assets',
                    value: data.data.data
                };

                commit('updateState', payload);
            }
        },
        //-----------------------------------------------------------------
        updateView({ state, commit, dispatch, getters }, payload) {
            let list_view = false;
            if(payload && payload.name && payload.name == 'user.list')
            {
                list_view = true;
            }
            let view = {
                key: 'list_view',
                value: list_view
            }
            commit('updateState', view);
        },
        //-----------------------------------------------------------------
    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        ajax_url(state) {return state.ajax_url;},
        assets(state) {return state.assets;},
        new_item(state) {return state.new_item;},
        query_string(state) {return state.query_string;},
        split_view(state) {return state.split_view;},
    }

}
