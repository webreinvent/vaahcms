import {VaahHelper as Vaah} from "../../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/advanced/logs";


export default {
    namespaced: true,
    //=========================================================================
    state: {
        ajax_url: ajax_url,
        list: null,
        list_is_empty: true,
        active_item: null,
        filters: {
            q: null,
        },
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

        //-----------------------------------------------------------------
    },
    //=========================================================================
    getters:{
        state(state) {return state;},
        ajax_url(state) {return state.ajax_url;},
        assets(state) {return state.assets;},
        filters(state) {return state.filters;},
        query_string(state) {return state.query_string;},
    }

}
