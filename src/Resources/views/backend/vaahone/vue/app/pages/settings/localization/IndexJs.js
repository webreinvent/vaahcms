import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import VaahVueClickToCopy from 'vaah-vue-clicktocopy'

let namespace = 'localizations';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        'vh-copy': VaahVueClickToCopy
    },
    data()
    {
        let obj = {
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

        };

        return obj;
    },
    watch: {


    },
    mounted() {


        //---------------------------------------------------------------------
        this.updateQueryString();
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
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



            this.getList(this.query_string.page);

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        getList: function (page = 1,sync = false) {
            this.$Progress.start();
            this.$vaah.updateCurrentURL(this.query_string, this.$router);
            let url = this.ajax_url+'/list';
            this.filters.vh_lang_language_id = this.page.assets.languages.default.id;
            this.filters.vh_lang_category_id = this.page.assets.categories.default.id;
            this.filters.sync = sync;
            this.filters.page = page;
            this.filters.filter = this.query_string.filter;
            let params = this.filters;
            this.$vaah.ajax(url, params, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data) {
            this.list = data.list;

            this.is_btn_loading = false;
            this.is_top_btn_loading = false;
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        sync: function () {

            this.is_btn_loading = true;

            this.getList(true);

        },
        //---------------------------------------------------------------------
        topSync: function () {

            this.is_top_btn_loading = true;

            this.getList(true);

        },
        //---------------------------------------------------------------------
        checkDuplicatedSlugs: function()
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
                this.$vaah.toastErrors([text+" are duplicate slugs"]);
                return false;
            } else
            {
                return true;
            }

        },
        //---------------------------------------------------------------------
        store: function (lang_id) {

            // this.$Progress.start();

            let check = this.checkDuplicatedSlugs();

            if(!check)
            {
                this.$Progress.finish();
                return false;
            }


            let url = this.ajax_url+'/store';
            let params = {
                list: this.list.data,
                vh_lang_language_id: lang_id,
            };


            let count = 0;

            if(!this.page.assets.categories.default.id && this.list && this.list.data && this.list.data.length > 0)
            {

                this.list.data.forEach(function (item) {

                   if(!item.id && item.slug){
                       count++;
                   }

                })
            }

            if(count > 0){

                let self = this;
                this.$buefy.dialog.confirm({
                    title: 'Add new Language String',
                    message: 'Are you sure you want to <b>Add</b> the Language String? This new string will added to general category.',
                    confirmText: 'Add',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: function () {
                        self.$Progress.start();
                        self.$vaah.ajax(url, params, self.storeAfter);
                    }
                })

            }else{
                this.$Progress.start();
                this.$vaah.ajax(url, params, this.storeAfter);
            }

        },
        //---------------------------------------------------------------------
        storeAfter: function (data) {

            this.$Progress.finish();
            this.getAssets(false);

        },
        //---------------------------------------------------------------------
        storeLanguage: function () {
            this.$Progress.start();
            let url = this.ajax_url+'/store/language';
            let params = this.new_language;
            this.$vaah.ajax(url, params, this.storeLanguageAfter);
        },
        //---------------------------------------------------------------------
        storeLanguageAfter: function (data) {
            this.$Progress.finish();
            this.getAssets();
            this.new_language = {
                name: null,
                locale_code_iso_639: null,
            };
        },
        //---------------------------------------------------------------------
        storeCategory: function () {

            this.$Progress.start();
            let url = this.ajax_url+'/store/category';
            let params = this.new_category;
            this.$vaah.ajax(url, params, this.storeCategoryAfter);

        },
        //---------------------------------------------------------------------
        storeCategoryAfter: function (data) {
            this.$Progress.finish();
            this.getAssets();
            this.new_category = {
                name: null,
            };
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        toggleLanguageForm: function()
        {

            this.show_add_category = false;

            if(this.show_add_language)
            {
                this.show_add_language = false;
            } else
            {
                this.show_add_language = true;
            }



            console.log('--->', this.show_add_language);

        },
        //---------------------------------------------------------------------
        toggleCategoryForm: function()
        {

            this.show_add_language = false;

            if(this.show_add_category)
            {
                this.show_add_category = false;
            } else
            {
                this.show_add_category = true;
            }

            console.log('--->', this.show_add_category);

        },
        //---------------------------------------------------------------------
        setActiveLanguage: function (e, language) {
            e.preventDefault();
            this.active_language = language;
            this.getList();
        },
        //---------------------------------------------------------------------
        setItemSlug: function(item)
        {
            item.slug = this.strToSlug(item.slug);
        },
        //---------------------------------------------------------------------
        strToSlug: function (title) {

            if(!title)
            {
                return null;
            }

            var slug = "";
            // Change to lower case
            var titleLower = title.toLowerCase();
            // Letter "e"
            slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
            // Letter "a"
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
            // Letter "o"
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
            // Letter "u"
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
            // Letter "d"
            slug = slug.replace(/đ/gi, 'd');
            // Trim the last whitespace
            slug = slug.replace(/\s*$/g, '');
            // Change whitespace to "-"
            slug = slug.replace(/\s+/g, '_');

            return slug;
        },
        //---------------------------------------------------------------------
        addString: function(lang_id,cat_id)
        {

            let item = {
                index: this.list.data.length,
                id: null,
                vh_lang_language_id: lang_id,
                vh_lang_category_id: cat_id,
                name: null,
                slug: null,
                content: null,
            };


            this.list.data.push(item);


        },
        //---------------------------------------------------------------------
        deleteString: function(item)
        {

            console.log(item);

            if(item.id)
            {
                this.$Progress.start();
                this.$vaah.removeInArrayByKey(this.list.data, item, 'id');

                let url = this.ajax_url+'/actions/delete-language-string';
                let params = item;
                this.$vaah.ajax(url, params, this.deleteStringAfter);

            } else
            {
                this.$vaah.removeInArrayByKey(this.list.data, item, 'index');

            }


        },
        //---------------------------------------------------------------------
        deleteStringAfter: function()
        {
            this.getAssets(false);
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        dataToCopy: function (item) {

            console.log('--->this.active_category dataCopy', this.active_category);

            let text = "@lang('"+this.active_category.slug+'.'+item.slug+"')";
            return text;
        },
        //---------------------------------------------------------------------
        copiedData: function (data) {
            this.$vaah.toastSuccess(['copied']);

            // alertify.success('copied');

            this.$vaah.console(data, 'copied data');
        },
        //-
        //---------------------------------------------------------------------
        showCategoryData: function () {

            this.filters.vh_lang_category_id = this.page.assets.categories.default.id;
            this.query_string.cat_id = this.page.assets.categories.default.id;

            let cat = this.$vaah.findInArrayByKey(this.page.assets.categories.list, 'id', this.query_string.cat_id);
            this.active_category = cat;

            this.query_string.page = 1;
            this.getList(this.query_string.page);
        },
        //-
        //---------------------------------------------------------------------
        selectTab: function (index) {

            this.page.assets.languages.default = this.page.assets.languages.list[index];
            this.query_string.lang_id = this.page.assets.languages.list[index].id;

            this.update('assets',this.page.assets);

            this.query_string.page = 1;

            this.getList(this.query_string.page);
        },
        //---------------------------------------------------------------------
        check: function () {

            console.log('check');
        },
        //---------------------------------------------------------------------
        updateQueryString: function()
        {
            let query = this.$vaah.removeEmpty(this.$route.query);
            if(Object.keys(query).length)
            {
                for(let key in query)
                {
                    this.query_string[key] = query[key];
                }
            }
            this.$vaah.updateCurrentURL(this.query_string, this.$router);

            this.getAssets();
        },
        //---------------------------------------------------------------------
        resetQueryString: function()
        {
            for(let key in this.query_string)
            {
                this.query_string[key] = null;
            }

            this.getAssets();

        },
        //---------------------------------------------------------------------
        paginate: function(page)
        {

            this.query_string.page = page;
            this.getList(page);

        },
        //---------------------------------------------------------------------
        toggleFilters: function()
        {
            if(this.show_filters == false)
            {
                this.show_filters = true;
            } else
            {
                this.show_filters = false;
            }


        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
