import GlobalComponents from '../../vaahvue/helpers/GlobalComponents';
import Tags from './partials/Tags';

let namespace = 'modules';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        page() {return this.$store.getters[namespace+'/state']},
        modules() {return this.$store.getters[namespace+'/state'].modules},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        Tags,
    },
    data()
    {
        return {
            is_content_loading: false,
            namespace: namespace,
            search_delay: null,
            search_delay_time: 800,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.updateActiveItem();
        }
    },
    created()
    {

    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------

        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateModules: function()
        {
            let update = {
                state_name: 'modules',
                state_value: this.modules,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateView: function()
        {
            this.update('list_view_class', 'is-6');
            this.$store.dispatch(this.namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.updateView();
            this.updateActiveItem();
            this.modules.list_is_loading = true;
            this.getAssets()
        },
        //---------------------------------------------------------------------
        updateActiveItem: function()
        {
            this.update('active_item', null);
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            let url = this.assets.vaahcms_api_route+'modules';
            this.$vaah.ajaxGet(url, this.modules.query_string, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.modules.list_is_loading = false;
            this.$Progress.finish();
            if(data)
            {
                this.modules.list = data.list;
                this.updateModules();
            }
        },
        //---------------------------------------------------------------------
        delayedSearch: function()
        {
            let self = this;
            clearTimeout(this.search_delay);
            this.search_delay = setTimeout(function() {
                self.getList();
            }, this.search_delay_time);

            this.modules.query_string.page = 1;
            this.updateModules();

        },
        //---------------------------------------------------------------------
        clearSearch: function () {
            this.modules.query_string.q = null;
            this.updateModules();
            this.getList();
        },
        //---------------------------------------------------------------------
        resetPage: function()
        {


            //reset bulk actions
            this.resetBulkAction();

            //reload page list
            this.getList();

        },
        //---------------------------------------------------------------------
        resetQueryString: function()
        {
            for(let key in this.modules.query_string)
            {
                if(key == 'page')
                {
                    this.modules.query_string[key] = 1;
                } else
                {
                    this.modules.query_string[key] = null;
                }
            }

            this.updateModules();
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
            this.modules.query_string.page = page;
            this.updateModules()
            this.getList();
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        reset: function () {

            this.update('list_view_class', '');

            this.resetPage();

            this.$router.push({name: 'modules.list'});

        },
        //---------------------------------------------------------------------
        isInstalled: function (item) {
            return this.$vaah.existInArray(this.assets.installed, item.slug);
        },
        //---------------------------------------------------------------------
        install: function (module) {
            this.$Progress.start();
            this.modules.active_download = module;
            this.updateModules();
            let params = module;
            let url = this.ajax_url+'/download';
            this.$vaah.ajax(url, params, this.installAfter);
        },
        //---------------------------------------------------------------------
        installAfter: function (data, res) {

            if(data)
            {
                this.modules.active_download = null;
                this.updateModules();
                this.update('assets_is_fetching', false);
                this.getAssets();
                this.$emit('eReloadList');
            }

        },

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
