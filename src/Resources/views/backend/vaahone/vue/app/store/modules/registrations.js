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
        list: null,
        list_is_empty: false,
        active_item: null,
        filters: {
            q: null,
        },
        is_list_loading: false,
        is_item_loading: false,
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
    }

}
