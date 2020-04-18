import GlobalComponents from '../../vaahvue/helpers/GlobalComponents';
import ListLargeView from './partials/ListLargeView';
import ListSmallView from './partials/ListSmallView';

let namespace = 'modules';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        ...GlobalComponents,
        ListLargeView,
        ListSmallView,

    },
    data()
    {
        return {
            is_content_loading: false,
            is_btn_loading: false,
            assets: null,
            search_delay: null,
            search_delay_time: 800,
            ids: [],
            moduleSection: null,
            list_view_class: '',
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.updateQueryString();
            this.updateActiveItem();
        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        //----------------------------------------------------
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
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.is_content_loading = true;
            this.updateView();
            this.updateQueryString();
            this.getAssets();
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
            this.update('query_string', this.query_string);
            this.$vaah.updateCurrentURL(this.query_string, this.$router);
        },
        //---------------------------------------------------------------------
        async getAssets() {
            this.$Progress.start();
            await this.$store.dispatch(namespace+'/getAssets');
            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {

            this.$vaah.updateCurrentURL(this.query_string, this.$router);
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, this.query_string, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.$Progress.finish();
            this.is_content_loading = false;

            if(data){
                this.update('list', data.list);
                if(data.list.total === 0)
                {
                    this.update('list_is_empty', true);
                }else{
                    this.update('list_is_empty', false);
                }
                this.update('query_string', this.page.query_string);
                this.$vaah.updateCurrentURL(this.page.query_string, this.$router);
            }

        },
        //---------------------------------------------------------------------
        toggleFilters: function()
        {
            if(this.page.show_filters == false)
            {
                this.page.show_filters = true;
            } else
            {
                this.page.show_filters = false;
            }

            this.update('show_filters', this.page.show_filters);

        },
        //---------------------------------------------------------------------
        clearSearch: function () {
            this.query_string.q = null;
            this.update('query_string', this.query_string);
            this.getList();
        },
        //---------------------------------------------------------------------
        resetPage: function()
        {

            //reset query strings
            this.resetQueryString();

            //reset bulk actions
            this.resetBulkAction();

            //reload page list
            this.getList();

        },
        //---------------------------------------------------------------------
        resetQueryString: function()
        {
            for(let key in this.query_string)
            {
                if(key == 'page')
                {
                    this.query_string[key] = 1;
                } else
                {
                    this.query_string[key] = null;
                }
            }

            this.update('query_string', this.query_string);
        },
        //---------------------------------------------------------------------
        resetBulkAction: function()
        {
            this.page.bulk_action = {
                selected_items: [],
                data: {},
                action: null,
            };
            this.update('bulk_action', this.page.bulk_action);
        },
        //---------------------------------------------------------------------
        paginate: function(page=1)
        {
            this.query_string.page = page;
            this.update('query_string', this.query_string);
            this.getList();
        },
        //---------------------------------------------------------------------
        delayedSearch: function()
        {
            let self = this;
            clearTimeout(this.search_delay);
            this.search_delay = setTimeout(function() {
                self.getList();
            }, this.search_delay_time);

            this.query_string.page = 1;
            this.update('query_string', this.query_string);

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        setSixColumns: function () {
            this.update('list_view_class', 'is-6');
        },
        //---------------------------------------------------------------------
        setEightColumns: function () {
            this.update('list_view_class', 'is-8');
        },
        //---------------------------------------------------------------------
        actions: function () {

            this.page.bulk_action.action = 'bulk-change-status';

            if(!this.page.bulk_action.data.status){
                this.$vaah.toastErrors(['Select an action']);
                return false;
            }

            if(this.page.bulk_action.selected_items.length < 1)
            {
                this.$vaah.toastErrors(['Select a record']);
                return false;
            }

            this.$Progress.start();
            this.update('bulk_action', this.page.bulk_action);
            let ids = this.$vaah.pluckFromObject(this.page.bulk_action.selected_items, 'id');

            let params = {
                inputs: ids,
                data: this.page.bulk_action.data
            };

            console.log('--->params', params);

            let url = this.ajax_url+'/actions/'+this.page.bulk_action.action;

            this.$vaah.ajax(url, params, this.actionsAfter);

        },
        //---------------------------------------------------------------------
        actionsAfter: function (data, res) {
            if(data)
            {
                this.$root.$emit('eReloadItem');
                this.resetBulkAction();
                this.getList();
                this.$store.dispatch('root/getPermissions');
            } else
            {
                this.$Progress.finish();
            }
        }, //---------------------------------------------------------------------
        sync: function () {

            this.page.query_string.recount = true;

            this.is_btn_loading = true;

            this.update('query_string', this.page.query_string);
            this.getList();
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        setFilter: function () {

            this.query_string.section = '';

            this.getModuleSection();

            this.getList();

            this.query_string.page = 1;
            this.update('query_string', this.query_string);

            console.log('check-status',this.page.assets.module.some(item => item.module === this.query_string.filter));
        },
        //---------------------------------------------------------------------
        updateActiveItem: function () {

            if(this.$route.fullPath.includes('permissions/?')){
                this.update('active_item', null);
            }
        },

        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
