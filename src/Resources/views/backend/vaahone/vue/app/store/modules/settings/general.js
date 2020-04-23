import {VaahHelper as Vaah} from "../../../vaahvue/helpers/VaahHelper";

//---------Variables
let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
//---------/Variables

let ajax_url = base_url+"/backend/vaah/settings/general";


export default {
    namespaced: true,
    //=========================================================================
    state: {
        ajax_url: ajax_url,
        assets: null,
        assets_is_fetching: false,
        settings:{
            general:{
                search_engine_visibility: true,
                maintenance_mode: false,
            },
            links:[
                {
                    name: 'Facebook',
                    slug: 'facebook',
                    url: '',
                },
                {
                    name: 'Twitter',
                    slug: 'twitter',
                    url: '',
                },
                {
                    name: 'Linkedin',
                    slug: 'linkedin',
                    url: '',
                },
                {
                    name: 'Youtube',
                    slug: 'youtube',
                    url: '',
                },
                {
                    name: 'Instagram',
                    slug: 'instagram',
                    url: '',
                },
                {
                    name: 'Github',
                    slug: 'github',
                    url: '',
                },
                {
                    name: 'Instagram',
                    slug: 'instagram',
                    url: '',
                }
            ],
            scripts:{
                after_head_start: null,
                before_head_close: null,
                after_body_start: null,
                before_body_close: null,
            },
            meta_tags:[
                {
                    label: "Open Graph - Title",
                    attribute: "property",
                    property_value:'og:title',
                    content:'',
                },
                {
                    label: "Open Graph - Description",
                    attribute: "property",
                    property_value:'og:description',
                    content:'',
                },
                {
                    label: "Meta Tag",
                    attribute: "",
                    property_value:'',
                    content:'',
                },
            ],
            formats:{
                date_type: null,
                date: 'Y-m-d',
                time_type: null,
                time: 'H:i:s',
                datetime_type: null,
                date_time: null,
            }
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
        settings(state) {return state.settings;},
    }

}
