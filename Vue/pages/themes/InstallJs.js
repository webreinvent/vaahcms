import GlobalComponents from '../../vaahvue/helpers/GlobalComponents';
import Tags from './partials/Tags.vue';

let namespace = 'themes';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        page() {return this.$store.getters[namespace+'/state']},
        themes() {return this.$store.getters[namespace+'/state'].themes},
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
        updateThemes: function()
        {
            let update = {
                state_name: 'themes',
                state_value: this.themes,
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
            this.themes.list_is_loading = true;
            this.getAssets()
        },
        //---------------------------------------------------------------------
        updateActiveItem: function()
        {
            this.update('active_item', null);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            let url = this.assets.vaahcms_api_route+'themes';
            this.$vaah.ajaxGet(url, this.themes.query_string, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.themes.list_is_loading = false;
            this.$Progress.finish();
            if(data)
            {
                this.themes.list = data.list;
                this.updateThemes();
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

            this.themes.query_string.page = 1;
            this.updateThemes();

        },
        //---------------------------------------------------------------------
        clearSearch: function () {
            this.themes.query_string.q = null;
            this.updateThemes();
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
            for(let key in this.themes.query_string)
            {
                if(key == 'page')
                {
                    this.themes.query_string[key] = 1;
                } else
                {
                    this.themes.query_string[key] = null;
                }
            }

            this.updateThemes();
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
            this.themes.query_string.page = page;
            this.updateThemes()
            this.getList();
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        reset: function () {

            this.update('list_view_class', '');

            this.resetPage();

            this.$router.push({name: 'themes.list'});

        },
        //---------------------------------------------------------------------
        isInstalled: function (item) {
            return this.$vaah.existInArray(this.assets.installed, item.slug);
        },
        //---------------------------------------------------------------------
        install: function (module) {
            this.$Progress.start();
            this.themes.active_download = module;
            this.updateThemes();
            let params = module;
            let url = this.ajax_url+'/download';
            this.$vaah.ajax(url, params, this.installAfter);
        },
        //---------------------------------------------------------------------
        installAfter: function (data, res) {

            if(data)
            {
                this.themes.active_download = null;
                this.updateThemes();
                this.update('assets_is_fetching', false);
                this.getAssets();
                this.$emit('eReloadList');
            }

        },

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
