import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import qs from 'qs'
import { vaah } from '../../vaahvue/pinia/vaah'
let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/localization";

export const useLocalizationStore = defineStore({
    id: 'localization',
    state: () => ({
        title: 'Localizations - Settings',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        filters: {
            page: null,
            rows: null,
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
        categories:[],
        filterOptions:null,
        show_add_language:false,
        show_add_category:false,
        selected_category:null,
        selected_language:null,
        new_variable:null,
        btn_is_loading: false,
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
                        if(key === 'filter'){
                            this.query_string[key] = route.query[key];
                        }else{
                            this.query_string[key] = parseInt(route.query[key]);
                        }

                    }
                }
            }
        },
        //---------------------------------------------------------------------
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
                this.categories = this.categories.concat(data.categories.list);
                this.filters.rows = data.rows;
                if(!this.query_string.lang_id){
                    this.query_string.lang_id = data.languages.default.id;
                }

                this.getList(this.query_string.page);

            }
        },
        //---------------------------------------------------------------------
        async getList(page = 1,sync = false) {

            this.filters.vh_lang_language_id = this.query_string.lang_id;
            this.filters.vh_lang_category_id = this.query_string.cat_id;

            this.updateUrlQueryString(this.query_string);
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
            this.btn_is_loading = false;
            if(data)
            {
                this.list = data.list;
                this.filters.rows = data.list.per_page;
            }
        },
        //---------------------------------------------------------------------
        getCopy(value)
        {
            let copyText = '{!! trans(vaahcms-'+value.language_category.slug+'.'+value.slug+') !!}';
            navigator.clipboard.writeText(copyText);
            vaah().toastSuccess(['Copied']);
        },
        //---------------------------------------------------------------------
        deleteString(item)
        {
            if(item.id)
            {
                this.list.data = vaah().removeInArrayByKey(this.list.data, item, 'id');
                let options = {
                    method: 'POST',
                    params: item
                };
                vaah().ajax(
                    this.ajax_url+'/actions/delete-language-string',
                    this.deleteStringAfter,
                    options
                );
            } else
            {
                this.list.data = vaah().removeInArrayByKey(this.list.data, item, 'index');
                this.deleteStringAfter();
            }
        },
        //---------------------------------------------------------------------
        deleteStringAfter()
        {
            this.assets_is_fetching = true;
            this.getAssets();
            vaah().toastErrors(['Removed']);

        },
        //---------------------------------------------------------------------
        addVariable() {
            let item = {
                index: this.list.data.length,
                id: null,
                vh_lang_language_id: this.query_string.lang_id,
                vh_lang_category_id: this.query_string.cat_id,
                name: null,
                slug: this.new_variable,
                content: null,
            };
            this.list.data.push(item);
            this.new_variable=null
        },
        //---------------------------------------------------------------------
        checkDuplicatedSlugs()
        {
            let exist = null;
            let count = null;
            let text = "";
            let self = this;

            if(this.list && this.list.data && this.list.data.length > 0)
            {
                this.list.data.forEach(function (item) {
                    count = 0;
                    self.list.data.forEach(function (match) {
                        if(item.slug && match.slug && item.slug == match.slug)
                        {
                            count++;
                        }
                    });
                    if(count > 1)
                    {
                        exist = true;
                        text = item.slug+", ";
                        return false;
                    }
                })
            }
            if(exist)
            {
                vaah().toastErrors([text+" are duplicate slugs"]);
                return false;
            } else
            {
                return true;
            }
        },
        //---------------------------------------------------------------------
        storeData() {
            let check = this.checkDuplicatedSlugs();
            if(!check)
            {
                return false;
            }
            let options = {
                method: 'post',
            };
            options.params = {
                list:this.list.data,
                vh_lang_language_id: this.assets.languages.default.id
            };
            let count = 0;
            if(!this.query_string.cat_id && this.list && this.list.data && this.list.data.length > 0)
            {
                this.list.data.forEach(function (item) {

                    if(!item.id && item.slug){
                        count++;
                    }
                })
            }
            if(count > 0){
                vaah().confirm.require({
                    message: 'Are you sure you want to <b>Add</b> the Language String?, ' +
                        'This new string will added to general category.',
                    header: 'Add new Language String',
                    acceptClass:"yellow",
                    rejectLabel: 'Cancel',
                    icon: 'pi pi-exclamation-triangle',
                    accept: () => {
                        let ajax_url = this.ajax_url+'/store';
                        vaah().ajax(ajax_url, this.storeAfter, options);
                    },
                });
            }else{
                let ajax_url = this.ajax_url+'/store';
                vaah().ajax(ajax_url, this.storeAfter, options);
            }
        },
        //---------------------------------------------------------------------
        storeAfter(data, res) {
            this.assets_is_fetching = true;
            this.getAssets(false);
        },
        //---------------------------------------------------------------------
        async updateUrlQueryString(query)
        {
            //remove reactivity from source object
            query = vaah().clone(query);

            //create query string
            let query_string = qs.stringify(query, {
                skipNulls: true,
            });
            let query_object = qs.parse(query_string);

            if(query_object.filter){
                query_object.filter = vaah().cleanObject(query_object.filter);
            }

            //reset url query string
            await this.$router.replace({query: null});

            //replace url query string
            await this.$router.replace({query: query_object});

            //update applied filters

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
        async sync() {
            this.btn_is_loading = true;
            await this.getList(this.query_string.page,true);
        },
        //---------------------------------------------------------------------
        removeQueryString()
        {
            this.query_string.filter = null;
            this.query_string.lang_id = this.assets.languages.default.id;
            this.query_string.cat_id = null;
            this.query_string.page = null;
            this.assets_is_fetching = true;
            this.getAssets();
        },
        //---------------------------------------------------------------------
        storeLanguage() {
            let options = {
                params:this.new_language,
                method:'POST'
            };

            let ajax_url = this.ajax_url+'/store/language';
            vaah().ajax(ajax_url, this.storeLanguageAfter, options);
        },
        //---------------------------------------------------------------------
        storeLanguageAfter(data) {
            if(data){
                this.assets_is_fetching = true;
                this.getAssets();
                this.new_language = {
                    name: null,
                    locale_code_iso_639: null,
                };
            }
        },
        //---------------------------------------------------------------------
        storeCategory() {
            let options = {
                params:this.new_category,
                method:'POST'
            };

            let ajax_url = this.ajax_url+'/store/category';
            vaah().ajax(ajax_url, this.storeLanguageAfter, options);
            this.new_category.name = null;
        },
        //---------------------------------------------------------------------
        storeCategoryAfter(data) {
            this.assets_is_fetching = true;
            this.getAssets();
        },
        //---------------------------------------------------------------------
        generateLanguage() {

            let url = this.ajax_url+'/generateLanguage';
            let options = {
                method:'post'
            };

            let ajax_url = this.ajax_url+'/generateLanguage';
            vaah().ajax(ajax_url, null, options);

        },
        //---------------------------------------------------------------------
        async paginate(event) {
            await this.getList(event.page+1);
        },
        //---------------------------------------------------------------------
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
    import.meta.hot.accept(acceptHMRUpdate(useLocalizationStore, import.meta.hot))
}
