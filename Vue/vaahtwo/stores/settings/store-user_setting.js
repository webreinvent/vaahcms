import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../../vaahvue/pinia/vaah'
import { useRootStore } from "./../root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/user-setting";

let empty_states = {
    query: [],
    list: null,
    action: []
};

export const useUserSettingStore = defineStore({
    id: 'user-settings',
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
        watchItem()
        {
            // if(this.new_variable){
            watch(() => this.new_variable, (newVal,oldVal) =>
                {
                    if(newVal && newVal !== "")
                    {
                        this.new_variable = this.new_variable.toUpperCase();
                        // this.new_variable = this.new_variable.split('_ ').join('_');
                        this.new_variable = this.new_variable.split(' ').join('_');

                    }
                },{deep: true}
            )
            // }
        },
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
        afterGetList: function (data, res)
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
        addCustomField: function () {
            if(!this.field_type){
                this.$vaah.toastErrors(['Select field Type first.']);
                return false;
            }
            let new_item = {
                "name": null,
                "slug": null,
                "type": this.selectedFieldType,
                "excerpt": null,
                "is_hidden": false,
                "to_registration": false,
            };
            if(this.field_type === 'textarea'
                || this.field_type === 'text'
                || this.field_type === 'email'){
                new_item.maxlength = null;
                new_item.minlength = null;
            }

            if(this.field_type === 'password'){
                new_item.is_password_reveal = null;
            }

            if(this.field_type === 'number'){
                new_item.min = null;
                new_item.max = null;
            }

            this.custom_field_list.value.push(new_item);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserSettingStore, import.meta.hot))
}
