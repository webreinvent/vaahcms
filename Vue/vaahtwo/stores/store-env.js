import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";
import qs from 'qs'
// import copy from "copy-to-clipboard";

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/env";

let empty_states = {
    query: {
        page: null,
        rows: null,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
        },
        recount: null,
    },

    sidebar_menu_items:[],

    list: null,
    settings:{
        list: null,
        links: [],
        scripts: null,
        meta_tags: [],
    },

    role_permissions_query: {
        q: null,
        module: null,
        section: null,
        page: null,
        rows: null,
    },
    role_users_query: {
        q: null,
        page: null,
        rows: null,
    },

    action: {
        type: null,
        items: [],
    }
};

export const useEnvStore = defineStore({
    id: 'env',
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
        env_file: null,
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
        afterGetList: function (data, res)
        {
            this.is_btn_loading = false;
            this.query.recount = null;

            if (data) {
                this.list = data.list;
                this.env_file = data.env_file;
            }
        },
        //---------------------------------------------------------------------
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
            let item = this.emptyItem();
            this.list.push(item);
        },
        //---------------------------------------------------------------------
        emptyItem() {

            let count = this.list.length;

            let item = {
                uid: count,
                key: 'VARIABLE_NAME_'+count,
                value: null,
            };

            return item;

        },
        //---------------------------------------------------------------------
        confirmChanges()
        {
            vaah().confirm.require({
                message: 'Invalid value(s) can break the application, are you sure to proceed?. You will be <b>logout</b> and redirected to login page.',
                header: 'Updating environment variables',
                class:'danger',
                acceptLabel: 'Proceed',
                acceptClass:"red",
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
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useEnvStore, import.meta.hot))
}
