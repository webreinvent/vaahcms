import pagination from 'laravel-vue-pagination';
import TableLoader from './../reusable/TableLoader';

export default {

    props: ['urls'],
    computed:{
        ajax_url(){
            let ajax_url = this.$store.state.urls.modules;
            return ajax_url;
        }
    },
    components:{
        't-loader': TableLoader,
        'pagination': pagination,
    },
    data()
    {
        let obj = {

            assets: null,
            q: null,
            page: 1,
            list: null,
            active_item: null,
            active_el: null,
            filters: {
                q: null
            }
        };

        return obj;
    },
    mounted() {

        //---------------------------------------------------------------------
        this.getAssets();
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------
        getAssets: function (e) {
            if(e)
            {
                e.preventDefault();
            }


            console.log(this.urls);

            var url = this.ajax_url+"/assets";
            var params = {};
            this.$vaahcms.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data) {

            this.assets = data;

            this.$vaahcms.console(this.assets, 'from app->');

            this.getModules();

        },
        //---------------------------------------------------------------------

        getModules: function (page) {


            var url = this.assets.vaahcms_api_route+"/modules";

            if(!page)
            {
                page = this.page;
            }

            if(this.page)
            {
                url = url+"?page="+page;
            }

            if(this.filters.q)
            {
                url = url+"&q="+this.filters.q;
            }

            var params = {};

            this.$vaahcms.console(url, 'url');
            this.$vaahcms.console(params, 'params');

            this.$vaahcms.ajax(url, params, this.getModulesAfter);
        },
        //---------------------------------------------------------------------
        getModulesAfter: function (data) {

            this.list = data.list;
            this.page = data.list.current_page;

            this.$vaahcms.console(this.list);

            this.$vaahcms.stopNprogress();
        },

        //---------------------------------------------------------------------
        download: function (e, item) {
            if(e)
            {
                e.preventDefault();
            }

            this.active_el = e.target;

            $(this.active_el).closest('.card').find('.progress').removeClass('hide');

            this.active_item = item;
            var url = this.ajax_url+"/download";
            var params = this.active_item;
            this.$vaahcms.ajax(url, params, this.downloadAfter);
        },
        //---------------------------------------------------------------------
        downloadAfter: function (data) {

            $(this.active_el).closest('.card').find('.progress').addClass('hide');
            this.$vaahcms.stopNprogress();

        },

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}