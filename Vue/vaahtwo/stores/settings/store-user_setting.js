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
<<<<<<< 2.x-develop
    id: 'user-settings',
=======
    id: 'user-setting',
>>>>>>> Update: user-settings modification list fetched
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
<<<<<<< 2.x-develop
        active_index:[],
        selected_field_type:null,
        field_types:[
            {name:"Text",value:"text"},
            {name:"Email",value:"email"},
            {name:"TextArea",value:"textarea"},
            {name:"Number",value:"number"},
            {name:"Password",value:"password"}
        ],
=======
        activeIndex:[],
        selectedFieldType:null,
        fieldTypes:null
>>>>>>> Update: user-settings modification list fetched
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
<<<<<<< 2.x-develop
=======
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
>>>>>>> Update: user-settings modification list fetched
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
<<<<<<< 2.x-develop
        afterGetList(data, res)
=======
        afterGetList: function (data, res)
>>>>>>> Update: user-settings modification list fetched
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
<<<<<<< 2.x-develop
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
            let check = element.closest('.draggable-menu').children[1].classList;
            if(check.length == 1){
                element.closest('.draggable-menu').children[1].classList.add('inactive');
            } else {
                element.closest('.draggable-menu').children[1].classList.remove('inactive');
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
=======
        isSecrete(item)
        {
            if(
                item.key == 'APP_KEY'
                || item.key.includes('SECRET')
                || item.key.includes('API_KEY')
                || item.key.includes('API')
                || item.key.includes('AUTH_KEY')
                || item.key.includes('PRIVATE_KEY')
                || item.key.includes('MERCHANT_KEY')
                || item.key.includes('SALT')
                || item.key.includes('AUTH_TOKEN')
                || item.key.includes('API_TOKEN')
            ){
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        inputType(item) {

            if(item.key.includes('PASSWORD'))
            {
                return 'password';
            }


            if(this.isSecrete(item))
            {
                return 'password';
            }


            return 'text';
        },
        //---------------------------------------------------------------------
        isDisable(item) {
            if(item.key == 'APP_KEY'
                || item.key == 'APP_ENV'
                || item.key == 'APP_URL'
            )
            {
                return true;
            }
        },
        //---------------------------------------------------------------------
        showRevealButton(item){

            if(item.key.includes('PASSWORD'))
            {
                return true;
            }

            if(this.isSecrete(item))
            {
                return true;
            }

            return false;
        },
        //---------------------------------------------------------------------
        getCopy(value)
        {
            navigator.clipboard.writeText(value);
            vaah().toastSuccess(['Copied']);
        },
        //---------------------------------------------------------------------
        removeVariable(item) {

            if(item.uid)
            {
                this.list = vaah().removeInArrayByKey(this.list, item, 'uid');
            } else
            {
                this.list = vaah().removeInArrayByKey(this.list, item, 'key');
            }
            vaah().toastErrors(['Removed']);
        },
        //---------------------------------------------------------------------
        addVariable() {
            let count = this.list.length;
            let item = {
                uid: count,
                key: this.new_variable,
                value: null,
            };
            this.list.push(item);
            this.new_variable=null
        },
        //---------------------------------------------------------------------
        confirmChanges()
        {
            vaah().confirm.require({
                message: 'Invalid value(s) can break the application, ' +
                    'are you sure to proceed?. ' +
                    'You will be <b>logout</b> and redirected to login page.',
                header: 'Updating environment variables',
                acceptClass:"yellow",
                rejectLabel: 'Cancel',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    this.store()
                },
            });
        },
        //---------------------------------------------------------------------
        store() {

            let valid = this.validate();
            let options = {
                method: 'post',
            };
            if(!valid)
            {
                return false;
            }


            options.params = this.list;

            let ajax_url = this.ajax_url+'/store';
            vaah().ajax(ajax_url, this.storeAfter, options);
        },
        //---------------------------------------------------------------------
        storeAfter(data, res) {
            if(data)
            {
                window.location.href = data.redirect_url;
            }
        },
        //---------------------------------------------------------------------
        validate()
        {
            let pair = this.generateKeyPair();

            let failed = false;
            let messages = [];

            if(!pair['APP_KEY']) {
                messages.push("APP_KEY is required");
                failed = true;
            }

            if(!pair['APP_ENV']) {
                messages.push("APP_ENV is required");
                failed = true;
            }

            if(!pair['APP_URL']) {
                messages.push("APP_URL is required");
                failed = true;
            }

            if(failed)
            {
                this.$vaah.toastErrors(messages);
                return false;
            }


            return true;
        },
        //---------------------------------------------------------------------
        generateKeyPair()
        {
            let pair = [];
            this.list.forEach(function (item) {

                pair[item.key] = item.value;

            });

            return pair;
        },
        //---------------------------------------------------------------------
        downloadFile(file_name)
        {
            window.location.href = this.ajax_url+"/download-file/"+file_name;
>>>>>>> Update: user-settings modification list fetched
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserSettingStore, import.meta.hot))
}
