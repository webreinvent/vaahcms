import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/localization";

let empty_states = {
    query: [],
    list: null,
    action: []
};

export const useLocalizationStore = defineStore({
    id: 'localization',
    state: () => ({
        base_url: base_url,
        ajax_url: ajax_url,
        activeSubTab:0,
        assets:null,
        bulk_action: "",
        bulk_action_data: "",
        filters: {
            q: null,
            vh_lang_language_id: null,
            vh_lang_category_id: null,
            sort_by: "",
            sort_type: 'desc',
            status: 'all',
            recount: false
        },
        new_language:{
            name: null,
            locale_code_iso_639: null,
        },
        new_category:{
            name: null,
        },
        query_string:{
            lang_id: null,
            cat_id: null,
            page: null,
            filter: null,
        },
        show_filters: false,
        is_btn_loading: false,
        is_top_btn_loading: false,
        expanded: false,
        atRight: false,
        size: null,
        type: 'is-boxed',
        show_add_language: false,
        show_add_category: false,
        show_import_form: false,
        active_language: null,
        active_category_id: null,
        active_category: null,
        list: null,
        form_data: [],
        name: null,
        icon_copy: "<b-icon icon='trash'></b-icon>"
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
        update(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        watchItem()
        {
            // if(this.newVariable){
            watch(() => this.newVariable, (newVal,oldVal) =>
                {
                    if(newVal && newVal !== "")
                    {
                        this.newVariable = this.newVariable.toUpperCase();
                    }
                },{deep: true}
            )
            // }
        },
        //---------------------------------------------------------------------
        async getAssets(refresh = true) {
            await this.$store.dispatch(namespace+'/getAssets');
            if(this.query_string.lang_id){
                this.page.assets.languages.default.id = this.query_string.lang_id;

                if(this.page.assets.languages.list){
                    this.activeSubTab = this.page.assets.languages.list.findIndex(p => p.id == this.query_string.lang_id);
                }
            }else{
                this.activeSubTab = 0;
            }
            if(this.query_string.cat_id){
                this.page.assets.categories.default.id = this.query_string.cat_id;
                if(refresh){
                    this.showCategoryData();
                }
            }
            // vaah().ajax(ajax_url+'/getAssets',this.getList(this.query_string.page));


        },
        //---------------------------------------------------------------------
        showCategoryData() {

            this.filters.vh_lang_category_id = this.page.assets.categories.default.id;
            this.query_string.cat_id = this.page.assets.categories.default.id;

            let cat = this.$vaah.findInArrayByKey(this.page.assets.categories.list, 'id', this.query_string.cat_id);
            this.active_category = cat;

            this.query_string.page = 1;
            this.getList(this.query_string.page);
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
            this.$Progress.start();
            this.$vaah.updateCurrentURL(this.query_string, this.$router);
            let ajax_url = this.ajax_url+'/list';
            this.filters.vh_lang_language_id = this.page.assets.languages.default.id;
            this.filters.vh_lang_category_id = this.page.assets.categories.default.id;
            this.filters.sync = sync;
            this.filters.page = page;
            this.filters.filter = this.query_string.filter;
            let params = this.filters;
            vaah().ajax(ajax_url, this.afterGetList, params);
        },
        //---------------------------------------------------------------------
        afterGetList(data, res)
        {
            this.list = data.list;

            this.is_btn_loading = false;
            this.is_top_btn_loading = false;
            this.$Progress.finish();

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
            let count = this.list.length;
            let item = {
                uid: count,
                key: this.newVariable,
                value: null,
            };
            this.list.push(item);
            this.newVariable=null
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
    import.meta.hot.accept(acceptHMRUpdate(useLocalizationStore, import.meta.hot))
}
