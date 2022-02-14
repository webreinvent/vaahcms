import ListLargeView from './partials/ListLargeView';
import ListSmallView from './partials/ListSmallView';
import ModalTreeView from './partials/ModalTreeView'

import TreeSelect from '@riophae/vue-treeselect'
// import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

let namespace = 'taxonomies';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        ListLargeView,
        ListSmallView,
        ModalTreeView,
        TreeSelect,
    },
    data()
    {
        return {
            namespace: namespace,
            is_content_loading: false,
            is_btn_loading: false,
            assets: null,
            selected_date: null,
            search_delay: null,
            search_delay_time: 800,
            ids: [],
            moduleSection: null,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.updateQueryString();
            this.updateActiveItem();
        }
    },
    created()
    {

    },
    mounted() {
        document.title = "Taxonomies";
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
            this.updateView();
            this.updateQueryString();
            this.getAssets();
            this.setDateFilter();
        },
        //---------------------------------------------------------------------
        updateQueryString: function()
        {
            let query = this.$vaah.removeEmpty(this.$route.query);
            if(Object.keys(query).length)
            {
                for(let key in query)
                {
                    if(key === 'types'){
                        if(typeof query[key] === 'string'){
                            this.query_string[key] = [query[key]];
                        }else{
                            this.query_string[key] = query[key];
                        }
                    }else{
                        this.query_string[key] = query[key];
                    }

                }
            }
            this.update('query_string', this.query_string);
            this.$vaah.updateCurrentURL(this.query_string, this.$router);
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
            this.getList();
        },
        //---------------------------------------------------------------------

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
        setDateFilter: function()
        {
            if(this.query_string.from){
                let from = new Date(this.query_string.from);

                this.selected_date=[
                    from
                ];
            }

            if(this.query_string.to){
                let to = new Date(this.query_string.to);

                this.selected_date[1] = to;
            }
        },
        //---------------------------------------------------------------------
        resetPage: function()
        {

            //reset query strings
            this.resetQueryString();

            this.resetSelectedDate();

            //reset bulk actions
            this.resetBulkAction();

            //reload page list
            this.getList();

        },
        //---------------------------------------------------------------------
        resetSelectedDate: function()
        {
            this.selected_date = null;
        },
        //---------------------------------------------------------------------
        resetQueryString: function()
        {
            for(let key in this.query_string)
            {
                if(key === 'page')
                {
                    this.query_string[key] = 1;
                }else if(key === 'types')
                {
                    this.query_string[key] = [];
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
        setTypes: function () {
            this.update('query_string',this.query_string);

            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            this.$vaah.updateCurrentURL(this.query_string, this.$router);



            this.$nextTick(function () {
                let url = this.ajax_url+'/list';
                this.$vaah.ajaxGet(url, this.query_string, this.getListAfter);
            });


        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {

            this.update('is_list_loading', false);
            this.update('list', data.list);

            this.update('total_permissions', data.totalPermission);
            this.update('total_users', data.totalUser);

            if(data.list.total === 0)
            {
                this.update('list_is_empty', true);
            }else{
                this.update('list_is_empty', false);
            }

            this.page.query_string.recount = null;

            this.update('query_string', this.page.query_string);
            this.$vaah.updateCurrentURL(this.page.query_string, this.$router);

            this.is_btn_loading = false;
            this.$Progress.finish();

        },
        //---------------------------------------------------------------------
        actions: function () {

            if(!this.page.bulk_action.action)
            {
                this.$vaah.toastErrors(['Select an action']);
                return false;
            }

            if(this.page.bulk_action.action == 'bulk-change-status'){
                if(!this.page.bulk_action.data.status){
                    this.$vaah.toastErrors(['Select a status']);
                    return false;
                }
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
                this.$root.$emit('eReloadTaxonomyItem');
                this.resetBulkAction();
                this.getList();
            } else
            {
                this.$Progress.finish();
            }
        },
        //---------------------------------------------------------------------
        sync: function () {

            this.page.query_string.recount = true;

            this.is_btn_loading = true;

            this.update('query_string', this.page.query_string);
            this.getList();
        },
        //---------------------------------------------------------------------
        updateActiveItem: function () {

            if(this.$route.fullPath.includes('taxonomies/?')){
                this.update('active_item', null);
            }
        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        setDateRange: function()
        {

            if(this.selected_date.length > 0){
                let current_datetime = new Date(this.selected_date[0]);
                this.query_string.from = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate();

                current_datetime = new Date(this.selected_date[1]);
                this.query_string.to = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate();

                this.getList();
            }



        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        onSelectType: function(type)
        {
            /*console.log(type);

            if(type.parent_id){
                this.type_parent_id = type.parent_id;
            }else{
                this.type_parent_id = null;
                this.new_item.parent = null;
            }*/
        },
        //---------------------------------------------------------------------


        //---------------------------------------------------------------------
        normalizer: function (node) {

            let data = {
                label: node.name,
                id: node.id.toString(),
            };

            if(node.children && node.children.length === 0){
                delete node.children;
            }

            return data;
        },
        //---------------------------------------------------------------------
    }
}
