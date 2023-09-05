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
        list_selected_menu: [],
        list_bulk_menu: [],
        item_menu_list: [],
        item_menu_state: null,
        form_menu_list: [],
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
        watchItem()
        {
            if(this.item){
                    watch(() => this.item.name, (newVal,oldVal) =>
                        {
                            if(newVal && newVal !== "")
                            {
                                this.item.name = vaah().capitalising(newVal);
                                this.item.slug = vaah().strToSlug(newVal);
                            }
                        },{deep: true}
                    )
                }
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
            // await this.getItemMenu();
            await this.getFormMenu();
        },
        //---------------------------------------------------------------------
        isListActionValid()
        {

            if(!this.action.type)
            {
                vaah().toastErrors(['Select an action type']);
                return false;
            }

            if(this.action.items.length < 1)
            {
                vaah().toastErrors(['Select records']);
                return false;
            }

            return true;
        },
        //---------------------------------------------------------------------
        async updateList(type = null){

            if(!type && this.action.type)
            {
                type = this.action.type;
            } else{
                this.action.type = type;
            }

            if(!this.isListActionValid())
            {
                return false;
            }


            let method = 'PUT';

            switch (type)
            {
                case 'delete':
                    method = 'DELETE';
                    break;
            }

            let options = {
                params: this.action,
                method: method,
                show_success: false
            };
            await vaah().ajax(
                this.ajax_url,
                this.updateListAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async updateListAfter(data, res) {
            if(data)
            {
                this.action = vaah().clone(this.empty_action);
                await this.getList();
            }
        },
        //---------------------------------------------------------------------
        async listAction(type = null){

            if(!type && this.action.type)
            {
                type = this.action.type;
            } else{
                this.action.type = type;
            }

            let url = this.ajax_url+'/action/'+type
            let method = 'PUT';

            switch (type)
            {
                case 'delete':
                    url = this.ajax_url
                    method = 'DELETE';
                    break;
                case 'delete-all':
                    method = 'DELETE';
                    break;
            }

            let options = {
                params: this.action,
                method: method,
                show_success: false
            };
            await vaah().ajax(
                url,
                this.updateListAfter,
                options
            );
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
                 * Create a record, hence method is `POST`
                 * https://docs.vaah.dev/guide/laravel.html#create-one-or-many-records
                 */
                case 'create-and-new':
                case 'create-and-close':
                case 'create-and-clone':
                    options.method = 'POST';
                    options.params = item;
                    break;

                /**
                 * Update a record with many columns, hence method is `PUT`
                 * https://docs.vaah.dev/guide/laravel.html#update-a-record-update-soft-delete-status-change-etc
                 */
                case 'save':
                case 'save-and-close':
                case 'save-and-clone':
                    options.method = 'PUT';
                    options.params = item;
                    ajax_url += '/'+item.id
                    break;
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
                case 'create-and-new':
                case 'save-and-new':
                    this.setActiveItemAsEmpty();
                    break;
                case 'create-and-close':
                case 'save-and-close':
                    this.setActiveItemAsEmpty();
                    this.$router.push({name: 'themes.index'});
                    break;
                case 'save-and-clone':
                    this.item.id = null;
                    break;
                case 'trash':
                    this.item = null;
                    break;
                case 'delete':
                case 'activate':
                case 'deactivate':
                    this.item = null;
                    this.toList();
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
        async getFaker () {
            let params = {
                model_namespace: this.model,
                except: this.assets.fillable.except,
            };

            let url = this.base_url+'/faker';

            let options = {
                params: params,
                method: 'post',
            };

            vaah().ajax(
                url,
                this.getFakerAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        getFakerAfter: function (data, res) {
            if(data)
            {
                let self = this;
                Object.keys(data.fill).forEach(function(key) {
                    self.item[key] = data.fill[key];
                });
            }
        },

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        onItemSelection(items)
        {
            this.action.items = items;
        },
        //---------------------------------------------------------------------
        setActiveItemAsEmpty()
        {
            this.item = vaah().clone(this.assets.empty_item);
        },
        //---------------------------------------------------------------------
        confirmDelete()
        {
            if(this.action.items.length < 1)
            {
                vaah().toastErrors(['Select a record']);
                return false;
            }
            this.action.type = 'delete';
            vaah().confirmDialogDelete(this.listAction);
        },
        //---------------------------------------------------------------------
        confirmDeleteAll()
        {
            this.action.type = 'delete-all';
            vaah().confirmDialogDelete(this.listAction);
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
        async delayedSearchThemes()
        {
            let self = this;
            this.query.page = 1;
            this.action.items = [];
            clearTimeout(this.search.delay_timer);
            this.search.delay_timer = setTimeout(async function() {
                await self.getThemes();
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
        async clearSearch()
        {
            this.query.filter.q = null;
            this.query.status= null;
            await this.updateUrlQueryString(this.query);
            await this.getList();
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
        closeForm()
        {
            this.$router.push({name: 'themes.index'})
        },
        //---------------------------------------------------------------------
        toList()
        {
            // this.$router.go();
        },
        //---------------------------------------------------------------------
        toForm()
        {
            this.item = vaah().clone(this.assets.empty_item);
            this.getFormMenu();
            this.$router.push({name: 'themes.form'})
        },
        //---------------------------------------------------------------------
        toView(item)
        {
            this.item = vaah().clone(item);
            this.$router.push({name: 'themes.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        toEdit(item)
        {
            this.item = item;
            this.$router.push({name: 'themes.form', params:{id:item.id}})
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
        async getListSelectedMenu()
        {
            this.list_selected_menu = [
                {
                    label: 'Activate',
                    command: async () => {
                        await this.updateList('activate')
                    }
                },
                {
                    label: 'Deactivate',
                    command: async () => {
                        await this.updateList('deactivate')
                    }
                },
                {
                    separator: true
                },
                {
                    label: 'Trash',
                    icon: 'pi pi-times',
                    command: async () => {
                        await this.updateList('trash')
                    }
                },
                {
                    label: 'Restore',
                    icon: 'pi pi-replay',
                    command: async () => {
                        await this.updateList('restore')
                    }
                },
                {
                    label: 'Delete',
                    icon: 'pi pi-trash',
                    command: () => {
                        this.confirmDelete()
                    }
                },
            ]

        },
        //---------------------------------------------------------------------
        getListBulkMenu()
        {
            this.list_bulk_menu = [
                {
                    label: 'Mark all as active',
                    command: async () => {
                        await this.listAction('activate-all')
                    }
                },
                {
                    label: 'Mark all as inactive',
                    command: async () => {
                        await this.listAction('deactivate-all')
                    }
                },
                {
                    separator: true
                },
                {
                    label: 'Trash All',
                    icon: 'pi pi-times',
                    command: async () => {
                        await this.listAction('trash-all')
                    }
                },
                {
                    label: 'Restore All',
                    icon: 'pi pi-replay',
                    command: async () => {
                        await this.listAction('restore-all')
                    }
                },
                {
                    label: 'Delete All',
                    icon: 'pi pi-trash',
                    command: async () => {
                        this.confirmDeleteAll();
                    }
                },
            ];
        },
        //---------------------------------------------------------------------
        getFilterMenu()
        {
            this.status_list = [

                {
                    label: 'All',
                    command: async () => {
                        this.query.filter.status = 'all';
                    }
                },
                {
                    label: 'Active',
                    command: async () => {
                        this.query.filter.status = 'active';
                    }
                },
                {
                    label: 'Inactive',
                    command: async () => {
                        this.query.filter.status = 'inactive';
                    }
                },
                {
                    label: 'Update Available',
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
        async getFormMenu()
        {
            let form_menu = [];

            if(this.item && this.item.id)
            {
                form_menu = [
                    {
                        label: 'Save & Close',
                        icon: 'pi pi-check',
                        command: () => {

                            this.itemAction('save-and-close');
                        }
                    },
                    {
                        label: 'Save & Clone',
                        icon: 'pi pi-copy',
                        command: () => {

                            this.itemAction('save-and-clone');

                        }
                    },
                    {
                        label: 'Trash',
                        icon: 'pi pi-times',
                        command: () => {
                            this.itemAction('trash');
                        }
                    },
                    {
                        label: 'Delete',
                        icon: 'pi pi-trash',
                        command: () => {
                            this.confirmDeleteItem('delete');
                        }
                    },
                ];

            } else{
                form_menu = [
                    {
                        label: 'Create & Close',
                        icon: 'pi pi-check',
                        command: () => {
                            this.itemAction('create-and-close');
                        }
                    },
                    {
                        label: 'Create & Clone',
                        icon: 'pi pi-copy',
                        command: () => {

                            this.itemAction('create-and-clone');

                        }
                    },
                    {
                        label: 'Reset',
                        icon: 'pi pi-refresh',
                        command: () => {
                            this.setActiveItemAsEmpty();
                        }
                    }
                ];
            }

            form_menu.push({
                label: 'Fill',
                icon: 'pi pi-pencil',
                command: () => {
                    this.getFaker();
                }
            },)

            this.form_menu_list = form_menu;

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
            return vaah().toLabel(text);
        }
    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useThemeStore, import.meta.hot))
}
