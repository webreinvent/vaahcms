import VaahVueClickToCopy from 'vaah-vue-clicktocopy'

export default {

    props: [],
    computed:{
        ajax_url(){
            let ajax_url = this.$store.state.urls.current+'/settings/localization';
            return ajax_url;
        }
    },
    components:{
        'vh-copy': VaahVueClickToCopy
    },
    data()
    {
        let obj = {
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
            show_add_language: false,
            show_add_category: false,
            active_language: null,
            active_category_id: null,
            active_category: null,
            list: null,
            icon_copy: "<i class='fas fa-copy'></i>"

        };

        return obj;
    },
    watch: {

        active_category_id: function (newVal, oldVal) {

            if(newVal && this.assets && this.assets.categories)
            {
                let cat = this.$vaahcms.findInArrayByKey(this.assets.categories.list, 'id', newVal);
                this.active_category = cat;
                console.log('--->this.active_category', this.active_category);
                this.getList();
            }


        }


    },
    mounted() {


        //---------------------------------------------------------------------
        this.getAssets();
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------
        getAssets: function () {
            let url = this.ajax_url+'/assets';
            let params = {};
            this.$vaahcms.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data) {
            this.assets = data;
            this.active_language = data.languages.default;
            this.active_category_id = data.categories.default.id;
            this.active_category = data.categories.default;
            this.getList();
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        getList: function () {
            let url = this.ajax_url+'/list';
            this.filters.vh_lang_language_id = this.active_language.id;
            this.filters.vh_lang_category_id = this.active_category.id;
            let params = this.filters;
            this.$vaahcms.ajax(url, params, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data) {
            this.list = data.list;
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        sync: function () {

            let url = this.ajax_url+'/sync';
            this.filters.vh_lang_language_id = this.active_language.id;
            this.filters.vh_lang_category_id = this.active_category.id;
            let params = this.filters;
            this.$vaahcms.ajax(url, params, this.syncAfter);

        },
        //---------------------------------------------------------------------
        syncAfter: function (data) {
            this.list = data.list;
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        checkDuplicatedSlugs: function()
        {

            let exist = null;
            let count = null;
            let text = "";
            let self = this;




            if(this.list)
            {

                this.list.forEach(function (item) {

                    count = 0;

                    self.list.forEach(function (match) {

                        if(item.slug == match.slug)
                        {
                            count++;
                        }

                    });

                    console.log('--->', count);

                    if(count > 1)
                    {
                        exist = true;
                        text += item.slug+", ";
                        return false;
                    }

                })
            }

            if(exist)
            {
                alertify.error(text+" are duplicate slugs");
                return false;
            } else
            {
                return true;
            }

        },
        //---------------------------------------------------------------------
        store: function () {


            let check = this.checkDuplicatedSlugs();

            if(!check)
            {
                return false;
            }

            let url = this.ajax_url+'/store';
            let params = {
                list: this.list,
                vh_lang_language_id: this.active_language.id,
            };
            this.$vaahcms.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data) {
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        storeLanguage: function () {

            let url = this.ajax_url+'/store/language';
            let params = this.new_language;
            this.$vaahcms.ajax(url, params, this.storeLanguageAfter);
        },
        //---------------------------------------------------------------------
        storeLanguageAfter: function (data) {
            this.getAssets();
            this.new_language = {
                name: null,
                locale_code_iso_639: null,
            };
        },
        //---------------------------------------------------------------------
        storeCategory: function () {

            let url = this.ajax_url+'/store/category';
            let params = this.new_category;
            this.$vaahcms.ajax(url, params, this.storeCategoryAfter);

        },
        //---------------------------------------------------------------------
        storeCategoryAfter: function (data) {
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
        addString: function()
        {
            let item = {
                index: this.list.length,
                id: null,
                vh_lang_language_id: this.active_language.id,
                vh_lang_category_id: this.active_category.id,
                name: null,
                slug: null,
                content: null,
            };

            this.list.push(item);

        },
        //---------------------------------------------------------------------
        deleteString: function(item)
        {

            console.log('--->item', item);

            if(item.index)
            {
                this.$vaahcms.removeInArrayByKey(this.list, item, 'index');
            } else
            {
                this.$vaahcms.removeInArrayByKey(this.list, item, 'id');

                let url = this.ajax_url+'/delete';
                let params = item;
                this.$vaahcms.ajax(url, params, this.deleteStringAfter);


            }


        },
        //---------------------------------------------------------------------
        deleteStringAfter: function()
        {

        },
        //---------------------------------------------------------------------
        bulkAction: function () {

            var inputs = this.selected_items;
            var data = this.bulk_action_data;
            this.actions(false, this.bulk_action, inputs, data)

        },
        //---------------------------------------------------------------------
        dataToCopy: function (item) {

            console.log('--->this.active_category dataCopy', this.active_category);

            let text = "@lang('"+this.active_category.slug+'.'+item.slug+"')";
            return text;
        },
        //---------------------------------------------------------------------
        copiedData: function (data) {
            alertify.success('copied');
            console.log('--->this.active_category dataCopy', this.active_category);
            this.$vaahcms.console(data, 'copied data');
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
