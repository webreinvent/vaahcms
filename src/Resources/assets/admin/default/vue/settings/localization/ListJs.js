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
            active_language: null,
            active_category: null,
            list: null,
            icon_copy: "<i class='fas fa-copy'></i>"

        };

        return obj;
    },
    watch: {



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
            this.active_category = data.categories.default;
            this.getList();
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
        store: function () {
            let url = this.ajax_url+'/store';
            let params = this.list;
            this.$vaahcms.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data) {
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        setActiveLanguage: function (e, language) {
            e.preventDefault();
            this.active_language = language;
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
            }


        },
        //---------------------------------------------------------------------
        bulkAction: function () {

            var inputs = this.selected_items;
            var data = this.bulk_action_data;
            this.actions(false, this.bulk_action, inputs, data)

        },
        //---------------------------------------------------------------------
        dataToCopy: function (item) {
            let text = "@lang('"+this.active_category.slug+'.'+item.slug+"')";
            return text;
        },
        //---------------------------------------------------------------------
        copiedData: function (data) {
            alertify.success('copied');
            this.$vaahcms.console(data, 'copied data');
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
