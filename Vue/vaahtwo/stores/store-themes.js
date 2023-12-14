import {watch} from 'vue'
import {acceptHMRUpdate, defineStore} from 'pinia'
import qs from 'qs'
import {vaah} from '../vaahvue/pinia/vaah'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Theme';

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/themes";
import { useRootStore } from "./root"

let empty_states = {
    query: {
        page: 1,
        rows: 20,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
            status: null
        },
        q: null
    },
    action: {
        type: null,
        items: [],
    }
};

export const useThemeStore = defineStore({
    id: 'themes',
    state: () => ({
        title: 'Themes - Extend',
        page: 1,
        rows: 20,
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        assets: null,
        rows_per_page: [10,20,30,50,100,500],
        list: null,
        item: null,
        fillable:null,
        empty_query:empty_states.query,
        empty_action:empty_states.action,
        query: vaah().clone(empty_states.query),
        action: vaah().clone(empty_states.action),
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
        route: null,
        watch_stopper: null,
        route_prefix: 'themes.',
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        form: {
            type: 'Create',
            action: null,
            is_button_loading: null
        },
        is_list_loading: null,
        count_filters: 0,
        item_menu_list: [],
        item_menu_state: null,
        is_fetching_updates: false,
        is_btn_loading: false,
        list_is_loading: false,
        themes: [],
        module: null,
        status_list: [],
        first_element: null,
        stats: null,
        themes_query: {
            page: null,
            query: null
        },
        active_action: [],
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
        //---------------------------------------------------------------------
        setViewAndWidth(route_name)
        {
            switch(route_name)
            {
                case 'themes.index':
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
        //---------------------------------------------------------------------
        watchRoutes(route)
        {
            //watch routes
            this.watch_stopper = watch(route, (newVal,oldVal) =>
                {
                    if(this.watch_stopper && !newVal.name.includes(this.route_prefix)){
                        this.watch_stopper();

                        return false;
                    }

                    this.route = newVal;
                    if(newVal.params.id){
                        this.getItem(newVal.params.id);
                    }
                    this.setViewAndWidth(newVal.name);
                }, { deep: true }
            )
        },
        //---------------------------------------------------------------------
        watchStates()
        {
            watch(this.query.filter, (newVal,oldVal) =>
                {
                    this.delayedSearch();
                },{deep: true}
            );
        },
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                await vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data)
        {
            if(data)
            {
                this.assets = data;
                if(data.rows)
                {
                    if (!this.query.rows) {
                        this.query.rows = parseInt(data.rows);
                    } else {
                        this.query.rows = parseInt(this.query.rows);
                    }
                }
            }
        },
        //---------------------------------------------------------------------
        async getList() {
            let options = {
                query: vaah().clone(this.query)
            };

            await this.updateUrlQueryString(this.query);

            await vaah().ajax(
                this.ajax_url,
                this.afterGetList,
                options
            );
        },
        //---------------------------------------------------------------------
        afterGetList: function (data, res)
        {
            this.is_btn_loading = false;
            if (data)
            {
                this.list = data.list.data;
                this.stats = data.stats;

                if (this.query.rows) {
                    this.query.rows = parseInt(this.query.rows);
                }

                this.first_element = ((this.query.page - 1) * this.query.rows);
            }
        },
        //---------------------------------------------------------------------

        async getItem(id) {
            if(id){
                await vaah().ajax(
                    ajax_url+'/'+id,
                    this.getItemAfter
                );
            }
        },
        //---------------------------------------------------------------------
        async getItemAfter(data, res)
        {
            if(data)
            {
                this.item = data;
            }else{
                this.$router.push({name: 'themes.index'});
            }
        },

        //---------------------------------------------------------------------
        itemAction(type, item=null)
        {
            if(!item)
            {
                item = this.item;
            }

            this.form.action = type;

            let ajax_url = this.ajax_url;

            let options = {
                method: 'post',
            };

            /**
             * Learn more about http request methods at
             * https://www.youtube.com/watch?v=tkfVQK6UxDI
             */
            switch (type)
            {

                /**
                 * Delete a record, hence method is `DELETE`
                 * and no need to send entire `item` object
                 * https://docs.vaah.dev/guide/laravel.html#delete-a-record-hard-deleted
                 */
                case 'delete':
                    options.method = 'DELETE';
                    ajax_url += '/'+item.id
                    break;
                /**
                 * Update a record's one column or very few columns,
                 * hence the method is `PATCH`
                 * https://docs.vaah.dev/guide/laravel.html#update-a-record-update-soft-delete-status-change-etc
                 */
                default:
                    options.method = 'PATCH';
                    ajax_url += '/'+item.id+'/action/'+type;
                    break;
            }

            vaah().ajax(
                ajax_url,
                this.itemActionAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async itemActionAfter(data, res)
        {
            if (data)
            {
                const root = useRootStore();
                this.assets_is_fetching = true;
                await this.getAssets();
                await this.getList();
                this.item = data;
                await root.reloadAssets();
                await this.formActionAfter();
                this.resetActivateBtnLoader(this.form.action,data.item)
            }
        },
        //---------------------------------------------------------------------
        async formActionAfter ()
        {
            switch (this.form.action)
            {
                case 'delete':
                case 'activate':
                case 'deactivate':
                    this.item = null;
                    this.toList()
                    break;
            }
        },
        //---------------------------------------------------------------------
        async toggleIsActive(item,index)
        {
            if(item.is_active) {
                this.active_action.push('deactivate_'+item.id);
                await this.itemAction('deactivate', item);
            } else {
                this.active_action.push('activate_'+item.id);
                await this.itemAction('activate', item);
            }
        },
        //---------------------------------------------------------------------
        async resetActivateBtnLoader(action,item) {
            let index = this.active_action.indexOf(action+'_'+item.id);
            this.active_action.splice(index,1);
        },
        //---------------------------------------------------------------------
        async runMigrations(item) {
            await this.itemAction('run_migrations', item);
        },
        //---------------------------------------------------------------------
        async runSeeds(item) {
            await this.itemAction('run_seeds', item);
        },
        //---------------------------------------------------------------------
        async refreshMigrations(item) {
            await this.itemAction('refresh_migrations', item);
        },
        //---------------------------------------------------------------------
        async paginate(event) {
            this.query.page = event.page+1;
            this.query.rows = event.rows;
            this.first_element = ((this.query.page - 1) * this.query.rows);
            await this.getList();
        },
        //---------------------------------------------------------------------
        async themesPaginate(event) {
            this.themes_query.page = event.page + 1;
            this.themes_query.rows = event.rows;
            await this.getThemes();
        },
        //---------------------------------------------------------------------
        async reload()
        {
            await this.getAssets();
            await this.getList();
        },
        //---------------------------------------------------------------------
        async delayedSearch()
        {
            let self = this;
            this.query.page = 1;
            this.action.items = [];
            clearTimeout(this.search.delay_timer);
            this.search.delay_timer = setTimeout(async function() {
                await self.updateUrlQueryString(self.query);

                if (self.query.q !== null && self.query.q !== undefined) {
                    await self.getThemes();
                }

                if ((self.query.filter.q !== null && self.query.filter.q !== undefined && self.query.filter.q !== '')
                    || (self.query.filter.status !== null && self.query.filter.status !== undefined && self.query.filter.status !== ''))
                {
                    await self.getList();
                }
            }, this.search.delay_time);
        },
        //---------------------------------------------------------------------
        async updateUrlQueryString(query)
        {
            //remove reactivity from source object
            query = vaah().clone(query)

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
            this.countFilters(query_object);

        },
        //---------------------------------------------------------------------
        countFilters: function (query)
        {
            this.count_filters = 0;
            if(query && query.filter)
            {
                let filter = vaah().cleanObject(query.filter);
                this.count_filters = Object.keys(filter).length;
            }
        },
        //---------------------------------------------------------------------
        async resetQuery()
        {
            //reset query strings
            await this.resetQueryString();

            //reload page list
            await this.getList();
        },
        //---------------------------------------------------------------------
        async resetQueryString()
        {
            for(let key in this.query.filter)
            {
                this.query.filter[key] = null;
            }
            for(let key in this.query)
            {
                if (key === 'filter') continue;
                this.query[key] = null;
            }

            this.query.page = this.page;
            this.query.rows = this.rows;

            await this.updateUrlQueryString(this.query);
        },
        //---------------------------------------------------------------------
        toList()
        {

            if (this.assets.empty_item !== undefined && this.assets.empty_item !== '') {
                this.item = vaah().clone(this.assets.empty_item);
            }

            this.$router.push({name: 'modules.index'})
        },
        //---------------------------------------------------------------------
        toView(item)
        {
            this.item = vaah().clone(item);
            this.$router.push({name: 'themes.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        isViewLarge()
        {
            return this.view === 'large';
        },
        //---------------------------------------------------------------------
        getIdWidth()
        {
            let width = 50;

            if(this.list && this.list.total)
            {
                let chrs = this.list.total.toString();
                chrs = chrs.length;
                width = chrs*40;
            }

            return width+'px';
        },
        //---------------------------------------------------------------------
        getActionWidth()
        {
            let width = 100;
            if(!this.isViewLarge())
            {
                width = 80;
            }
            return width+'px';
        },
        //---------------------------------------------------------------------
        getActionLabel()
        {
            let text = null;
            if(this.isViewLarge())
            {
                text = 'Actions';
            }

            return text;
        },

        //---------------------------------------------------------------------
        getFilterMenu()
        {
            const root = useRootStore();
            this.status_list = [

                {
                    label: root.assets.language_string.extend_themes.filter_all,
                    command: async () => {
                        this.query.filter.status = 'all';
                    }
                },
                {
                    label: root.assets.language_string.extend_themes.filter_active,
                    command: async () => {
                        this.query.filter.status = 'active';
                    }
                },
                {
                    label: root.assets.language_string.extend_themes.filter_inactive,
                    command: async () => {
                        this.query.filter.status = 'inactive';
                    }
                },
                {
                    label: root.assets.language_string.extend_themes.filter_update_available,
                    command: async () => {
                        this.query.filter.status = 'update_available';
                    }
                }
            ];
        },
        confirmDeleteItem(item)
        {
            this.item = item;
            this.form.type = 'delete';
            vaah().confirmDialogDelete(this.confirmDeleteItemAfter);
        },
        //---------------------------------------------------------------------
        confirmDeleteItemAfter()
        {
            this.itemAction('delete', this.item);
        },
        //---------------------------------------------------------------------
        checkUpdate() {
            this.is_fetching_updates = true;

            let options = {
                query: {
                    slugs: this.assets.installed
                }
            };
            let url = this.assets.vaahcms_api_route+'theme/updates';
            vaah().ajax(url, this.checkUpdateAfter, options);
        },
        //---------------------------------------------------------------------
        checkUpdateAfter(data, res) {
            this.is_fetching_updates = false;
            if(data)
            {
                this.update('updates_list', data);
                this.storeUpdates();
            }
        },
        //---------------------------------------------------------------------
        storeUpdates() {
            let params = {
                themes: this.page.updates_list
            };
            let url = this.ajax_url+'/store/updates';
            this.$vaah.ajax(url, params, this.storeUpdatesAfter);
        },
        //---------------------------------------------------------------------
        storeUpdatesAfter(data, res) {
            this.is_fetching_updates = false;
            if(data)
            {
                this.getList();
            }
        },
        //---------------------------------------------------------------------

        setSixColumns() {
            this.list_view_width = '6';
            this.$router.push({name: 'themes.install'});
        },
        getThemes() {
            let url = this.assets.vaahcms_api_route+'themes';
            let options = {
                query: {
                    page: 1,
                    q: this.query.q
                }
            };
            vaah().ajax(url, this.getThemesAfter,options);
        },
        getThemesAfter(data)
        {
            if (data)
            {
                this.themes = data.list;
                this.themes_query.rows = parseInt(this.themes.per_page);
            }
        },
        //---------------------------------------------------------------------
        isInstalled(item) {
            return vaah().existInArray(this.assets.installed,item.slug);
        },
        //---------------------------------------------------------------------
        install(module) {
            this.themes.active_download = module;

            let options = {
                params: module,
                method: 'post'
            };
            let url = this.ajax_url+'/download';
            vaah().ajax(url, this.installAfter, options);
        },
        //---------------------------------------------------------------------
        async installAfter(data) {
            if(data)
            {
                this.themes.active_download = null;
                this.assets_is_fetching = true;
                await this.getAssets();
                await this.getList();
            }
        },
        //---------------------------------------------------------------------
        async actions(action, theme) {
            let options = {
                params : {
                    action: action,
                    inputs: theme
                },
                method: 'post'
            };
            let url = this.ajax_url+'/actions';
            await vaah().ajax(url, this.actionsAfter, options);
        },
        //---------------------------------------------------------------------
        actionsAfter(data, res) {

            if(data)
            {
                this.getAssets();
            }

        },
        //---------------------------------------------------------------------
        closeInstallTheme() {
            this.list_view_width = '12';
            this.$router.push({name: 'themes.index'});
        },
        sync() {
            this.query.recount = true;
            this.is_btn_loading = true;
            this.getList();
        },
        hasPermission(slug) {
            const root = useRootStore();
            return vaah().hasPermission(root.permissions, slug);
        },
        //----------------------------------------------------------------------
        publishAssets(item) {
            this.active_action.push('publish_assets_'+item.id);

            let options = {
                method: 'POST',
                params: {
                    slug: item.slug
                }
            };

            let url = this.ajax_url+'/publish/assets';
            vaah().ajax(url, this.publishAssetsAfter, options);
        },
        //---------------------------------------------------------------------
        publishAssetsAfter(data) {
            this.getList();
            this.resetActivateBtnLoader('publish_assets',data.item);
        },
        //---------------------------------------------------------------------
        makeDefault(item) {
            this.active_action.push('make_default_'+item.id);
            this.itemAction('make_default',item);
        },
        //---------------------------------------------------------------------
        openWebsite(url) {
            window.open(url,'_target');
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        },
        //---------------------------------------------------------------------
        toLabel(text) {
            const root = useRootStore();
            switch (text) {
                case 'all':
                    return root.assets.language_string.extend_themes.filter_all;
                case 'active':
                    return root.assets.language_string.extend_themes.filter_active;
                case 'inactive':
                    return root.assets.language_string.extend_themes.filter_inactive;
                case 'update_available':
                    return root.assets.language_string.extend_themes.filter_update_available;
            }
        }
    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useThemeStore, import.meta.hot))
}
