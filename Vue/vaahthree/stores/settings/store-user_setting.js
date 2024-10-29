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
        title: 'User Settings - Settings',
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
        active_index:[],
        selected_field_type:null,
        content_settings_status:true,
        field_types:[
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
        getNewItem() {
            return {
                "id": null,
                "key": null,
                "category": "user_setting",
                "label": "custom_fields",
                "excerpt": null,
                "type": "json",
                "value": []
            };
        },
        //---------------------------------------------------------------------
        addCustomField() {
            if(!this.selected_field_type){
                vaah().toastErrors(['Select field Type first.']);
                return false;
            }
            let new_item = {
                "name": null,
                "slug": null,
                "type": this.selected_field_type,
                "excerpt": null,
                "is_hidden": false,
                "to_registration": false,
            };
            if(this.selected_field_type === 'textarea'
                || this.selected_field_type === 'text'
                || this.selected_field_type === 'email'){
                new_item.maxlength = null;
                new_item.minlength = null;
            }

            if(this.selected_field_type === 'password'){
                new_item.is_password_reveal = null;
            }

            if(this.selected_field_type === 'number'){
                new_item.min = null;
                new_item.max = null;
            }

            this.custom_field_list.value.push(new_item);
        },
        //---------------------------------------------------------------------
        deleteGroupField(index) {
            this.custom_field_list.value.splice(index, 1);
        },
        //---------------------------------------------------------------------
        toggleFieldOptions(event){
            let element = event.target;
            // let target = element.closest('.draggable-menu').find('.p-panel-content');
            let check = element.closest('.content-div').children[1].classList;
            if(check.length == 0){
                element.closest('.content-div').children[1].classList.add('inactive');
            } else {
                element.closest('.content-div').children[1].classList.remove('inactive');
            }

        },
        //---------------------------------------------------------------------
        onInputFieldName(element) {
            element.slug = vaah().strToSlug(element.name,'_');
        },
        //---------------------------------------------------------------------
        storeField(item) {
            let options = {
                method: 'post',
            };

            options.params = {
                item:item
            };
            let ajax_url = this.ajax_url+'/field/store';
            vaah().ajax(ajax_url, this.storeCustomFieldAfter, options);
        },
        //---------------------------------------------------------------------
        storeFieldAfter(data, res) {
            this.getList();
        },
        //---------------------------------------------------------------------
        storeCustomField() {
            let options = {
                method: 'post',
            };

            options.params= {
                item : this.custom_field_list
            };
            let ajax_url = this.ajax_url+'/custom-field/store';
            vaah().ajax(ajax_url, this.storeCustomFieldAfter, options);
        },
        //---------------------------------------------------------------------
        storeCustomFieldAfter(data, res) {

            if(res.data.status === 'success'){
                this.getList();
            }

        },
        //---------------------------------------------------------------------
        expandAll() {
            this.active_index = [0,1];
        },
        collapseAll() {
            this.active_index = [];
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserSettingStore, import.meta.hot))
}
