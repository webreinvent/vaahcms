import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../../vaahvue/pinia/vaah'
import { useRootStore } from "./../root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/general";

let empty_states = {
    query: [],
    list: null,
    action: []
};

export const useGeneralStore = defineStore({
    id: 'general',
    state: () => ({
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        assets: null,
        rows_per_page: [10,20,30,50,100,500],
        list: null,
        item: null,
        fillable:null,
        empty_query:empty_states.query,
        empty_action:empty_states.action,
        query: vaah().clone(empty_states.query),
        action: vaah().clone(empty_states.action),
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
        route: null,
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        form: {
            type: 'Create',
            action: null,
            is_button_loading: null
        },
        is_list_loading: null,
        count_filters: 0,
        list_selected_menu: [],
        list_bulk_menu: [],
        item_menu_list: [],
        item_menu_state: null,
        form_menu_list: [],
        field:{
            name:null,
            type:null
        },
        field_type: null,
        custom_field_list:null,
        activeIndex:[],
        selectedFieldType:null,
        fieldTypes:[
            {name:"Text",value:"text"},
            {name:"Email",value:"email"},
            {name:"TextArea",value:"textarea"},
            {name:"Number",value:"number"},
            {name:"Password",value:"password"}
        ],
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;
            }
        },
        //---------------------------------------------------------------------
        async getList() {
            let options = {
                query: vaah().clone(this.query)
            };

            await vaah().ajax(
                this.ajax_url+'/list',
                this.afterGetList,
                options
            );
        },
        //---------------------------------------------------------------------
        afterGetList(data, res)
        {
            this.is_btn_loading = false;
            this.query.recount = null;

            if (data) {
                this.field_list = data.list.fields;

                if(data.list.custom_fields){
                    this.custom_field_list = data.list.custom_fields;
                }else{
                    this.custom_field_list = this.getNewItem();
                }
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useGeneralStore, import.meta.hot))
}
