import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import qs from 'qs'
import { vaah } from '../vaahvue/pinia/vaah'
let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/localization";

export const useLocalizationStore = defineStore({
    id: 'localization',
    state: () => ({
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        filters: {
            q: null,
            vh_lang_language_id: null,
            vh_lang_category_id: null,
            sort_by: "",
            sort_type: 'desc',
            status: 'all',
            recount: false
        },
        query_string:{
            lang_id: null,
            cat_id: null,
            page: null,
            filter: null,
        },
        assets_is_fetching: true,
        rows_per_page: [10,20,30,50,100,500],
        app: null,
        activeSubTab:0,
        assets:null,
        fillable:null,
        list: null,
        item:null,
        route: null,
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
        form: {
            type: 'Create',
            action: null,
            is_button_loading: null
        },
        new_language:{
            name: null,
            locale_code_iso_639: null,
        },
        new_category:{
            name: null,
        },
        is_list_loading: null,
        count_filters: 0,
        list_selected_menu: [],
        list_bulk_menu: [],
        item_menu_list: [],
        item_menu_state: null,
        form_menu_list: [],
        payloadModal:false,
        payloadContent:null,
        name: null,
        icon_copy: "<b-icon icon='trash'></b-icon>",
        languages:null,
        categories:null,
        filterOptions:null,
        show_add_language:false,
        show_add_category:false
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
        async onLoad(route)
        {
            /**
             * Set initial routes
             */
            this.route = route;

            /**
             * Update with view and list css column number
             */
            this.setViewAndWidth(route.name);

            /**
             * Update query state with the query parameters of url
             */
            this.updateQueryFromUrl(route);
        },
        setViewAndWidth(route_name)
        {
            switch(route_name)
            {
                case 'jobs.index':
                    this.view = 'large';
                    this.list_view_width = 12;
                    break;
                default:
                    this.view = 'small';
                    this.list_view_width = 6;
                    break
            }
        },
        //---------------------------------------------------------------------
        async updateQueryFromUrl(route)
        {
            if(route.query)
            {
                if(Object.keys(route.query).length > 0)
                {
                    for(let key in route.query)
                    {
                        this.query[key] = route.query[key]
                    }
                    this.countFilters(route.query);
                }
            }
        },
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
                this.languages = data.languages.list;
                this.categories = data.categories.list;

                this.getList();

            }
        },
        //---------------------------------------------------------------------
        async getList(page = 1,sync = false) {

            this.filters.vh_lang_language_id = this.assets.languages.default.id;
            this.filters.vh_lang_category_id = this.assets.categories.default.id;
            this.filters.sync = sync;
            this.filters.page = page;
            this.filters.filter = this.query_string.filter;
            let options = {
                query: this.filters
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
            if(data)
            {
                this.list = data.list;
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
        toggleLanguageForm()
        {
            this.show_add_category = false;
            this.show_add_language = !this.show_add_language;
        },
        //---------------------------------------------------------------------
        toggleCategoryForm()
        {
            this.show_add_language = false;
            this.show_add_category = !this.show_add_category;
        },
        //---------------------------------------------------------------------
        sync: function () {
            this.getList(this.query_string.page,true);
        },
        //---------------------------------------------------------------------
        resetQueryString()
        {
            for(let key in this.query_string)
            {
                this.query_string[key] = null;
            }
            this.getAssets();
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useLocalizationStore, import.meta.hot))
}
