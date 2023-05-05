import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings";

let empty_states = {
    query: {
        page: null,
        rows: null,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
        },
        recount: null,
    },

    sidebar_menu_items:[],

    list: null,
    settings:{
        list: null,
        links: [],
        scripts: null,
        meta_tags: [],
    },

    role_permissions_query: {
        q: null,
        module: null,
        section: null,
        page: null,
        rows: null,
    },
    role_users_query: {
        q: null,
        page: null,
        rows: null,
    },

    action: {
        type: null,
        items: [],
    }
};

export const useSettingStore = defineStore({
    id: 'settings',
    state: () => ({
        title: 'Settings',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        assets: null,
        general_assets: null,
        rows_per_page: [10,20,30,50,100,500],
        list: null,
        item: {
            name: null,
            slug: null
        },
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
        route_prefix: 'settings.',
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
        total_permissions: null,
        total_users: null,
        permission_menu_items: null,
        role_permissions: null,
        role_user_menu_items: null,
        role_users: null,
        search_item: null,
        active_role_permission: null,
        active_role_user: null,
        module_section_list: null,
        role_permissions_query: vaah().clone(empty_states.role_permissions_query),
        role_users_query: vaah().clone(empty_states.role_users_query),
        is_btn_loading: false,
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
                case 'roles.index':
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
                    if (this.watch_stopper && !newVal.name.includes(this.route_prefix)) {
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

            watch(this.role_permissions_query, (newVal, oldVal) => {
                this.delayedRolePermissionSearch();
            }, {
                deep:true
            });

            watch(this.role_users_query, (newVal, oldVal) => {
                this.delayedRoleUsersSearch();
            }, {
                deep:true
            });
        },
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                vaah().ajax(
                    this.ajax_url+'/general/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.general_assets = data;


            }
        },
        //---------------------------------------------------------------------
        async getList() {
            let options = {
                query: vaah().clone(this.query)
            };

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
            this.query.recount = null;

            if (data) {
                this.list = data;
                this.total_permissions = res.data.totalPermissions;
                this.total_users = res.data.totalUsers;
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
                this.$router.push({name: 'roles.index'});
            }
            this.getItemMenu();
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
        itemAction(type, item=null){
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
            if(data)
            {
                this.item = data;
                await this.getList();
                await this.formActionAfter();
                this.getItemMenu();

                if (this.route.params && this.route.params.id) {
                    await this.getItem(this.route.params.id);
                }
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
                    this.$router.push({name: 'roles.index'});
                    break;
                case 'save-and-clone':
                    this.item.id = null;
                    break;
                case 'trash':
                    this.item = null;
                    break;
                case 'delete':
                    this.item = null;
                    this.toList();
                    break;
            }
        },
        //---------------------------------------------------------------------
        async toggleIsActive(item)
        {
            if(item.is_active)
            {
                await this.itemAction('activate', item);
            } else{
                await this.itemAction('deactivate', item);
            }
        },
        //---------------------------------------------------------------------
        async paginate(event) {
            this.query.page = event.page+1;
            await this.getList();
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
        async sync() {
            this.is_btn_loading = true;
            this.query.recount = true;
            await this.getList();
        },
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
                await self.getList();
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
            await this.updateUrlQueryString(this.query);
        },
        //---------------------------------------------------------------------
        async getItemPermissions() {

            this.showProgress();

            let params = {
                query: this.role_permissions_query,
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/item/' + this.item.id + '/permissions',
                this.afterGetItemPermissions,
                params
            );
        },
        //---------------------------------------------------------------------
        afterGetItemPermissions(data, res) {

            this.hideProgress();

            if (data) {
                this.role_permissions = data;
            }
        },
        //---------------------------------------------------------------------
        async delayedRolePermissionSearch() {
            let self = this;
            if(self.item && self.item.id)
            {
                clearTimeout(this.search.delay_timer);
                this.search.delay_timer = setTimeout(async function() {
                    await  self.getItemPermissions();
                },this.search.delay_time)
            }

        },
        //---------------------------------------------------------------------
        async permissionPaginate(event) {
            this.role_permissions_query.page = event.page+1;
            await this.getItemPermissions();
        },
        //---------------------------------------------------------------------
         async getItemUsers() {

            this.showProgress();

            let params = {
                query: this.role_users_query,
                method: 'get',
            };

            vaah().ajax(
                this.ajax_url+'/item/' + this.item.id + '/users',
                this.afterGetItemUsers,
                params
            );
        },
        //---------------------------------------------------------------------
        afterGetItemUsers(data, res) {
            this.hideProgress();

            if (data) {
                this.role_users = data;
            }
        },
        //---------------------------------------------------------------------
        async userPaginate(event) {
            this.role_users_query.page = event.page+1;
            await this.getItemUsers();
        },
        //---------------------------------------------------------------------
        async delayedRoleUsersSearch() {
            let self = this;
            if(self.item && self.item.id) {
                clearTimeout(this.search.delay_timer);
                this.search.delay_timer = setTimeout(async function () {
                    await self.getItemUsers();
                }, this.search.delay_time);
            }
        },
        //---------------------------------------------------------------------
        changeRoleStatus (id) {

            let inputs = {
                inputs: [id],
            };

            let data = {};

            this.actions(false, 'change-role-permission-status', inputs, data);
        },
        //---------------------------------------------------------------------
        afterChangeRoleStatus (data,res) {

            this.hideProgress();
            this.getItemPermissions(this.filter.page);
            this.$store.dispatch('root/reloadPermissions');
        },
        //---------------------------------------------------------------------
        changeRolePermission (item) {

            let inputs = {
                id : this.item.id,
                permission_id : item.id,
            };

            let data = {};

            if (item.pivot.is_active) {
                data.is_active = 0;
            } else {
                data.is_active = 1;
            }

            this.actions(false, 'toggle-permission-active-status', inputs, data)

        },
        //---------------------------------------------------------------------
        changeUserRole: function (item) {

            let params = {
                id : this.item.id,
                user_id : item.id,
            };

            let data = {};

            if(item.pivot.is_active)
            {
                data.is_active = 0;
            } else
            {
                data.is_active = 1;
            }

            this.actions(false, 'toggle-user-active-status', params, data)

        },
        //---------------------------------------------------------------------
        bulkActions (input, action) {
            let params = {
                id: this.item.id,
                permission_id: null,
                user_id: null
            };

            let data = {
                is_active: input
            };

            this.actions(false, action, params, data)

        },
        //---------------------------------------------------------------------
        actions (e, action, inputs , data) {

            this.showProgress();

            if (e) {
                e.preventDefault();
            }

            let params = {
                params: {
                    inputs: inputs,
                    data: data,
                },
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/actions/' + action,
                this.afterActions,
                params
            );
        },
        //---------------------------------------------------------------------
        async afterActions (data,res) {
            await this.hideProgress();
            await this.getItemPermissions(this.item.id);
            await this.getItemUsers();
            await this.getList();
        },
        //---------------------------------------------------------------------
        resetRolePermissionFilters() {
            this.role_permissions_query.q = null;
            this.role_permissions_query.module = null;
            this.role_permissions_query.section = null;
            this.role_permissions_query.rows = this.assets.rows;
        },
        //---------------------------------------------------------------------
        getModuleSection() {

            let params = {
                params: {
                    module: this.role_permissions_query.module,
                },
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/module/' + this.role_permissions_query.module +'/sections',
                this.afterAetModuleSection,
                params
            );
        },
        //---------------------------------------------------------------------
        afterAetModuleSection(data, res) {
            if(data){
                this.module_section_list = data;
            }
        },
        //---------------------------------------------------------------------
        resetRoleUserFilters() {
            this.role_users_query.q = null;
            this.role_users_query.rows = this.assets.rows;
        },
        //---------------------------------------------------------------------
        closeForm()
        {
            this.$router.push({name: 'roles.index'})
        },
        //---------------------------------------------------------------------
        toList()
        {
            this.item = null;
            this.$router.push({name: 'roles.index'})
        },
        //---------------------------------------------------------------------
        toForm()
        {
            this.item = vaah().clone(this.assets.empty_item);
            this.getFormMenu();
            this.$router.push({name: 'roles.form'})
        },
        //---------------------------------------------------------------------
        toView(item)
        {
            this.item = vaah().clone(item);
            this.$router.push({name: 'roles.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        toEdit(item)
        {
            this.item = item;
            this.$router.push({name: 'roles.form', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        async toPermission(item) {
            this.item = item;
            await this.getItemPermissions();
            this.$router.push({name: 'roles.permissions', params: {id: item.id}});
        },
        //---------------------------------------------------------------------
        toUser(item) {
            this.item = item;
            this.getItemUsers();
            this.$router.push({name: 'roles.users', params: {id: item.id}});
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
        getItemMenu()
        {
            let item_menu = [];

            if(this.item && this.item.deleted_at)
            {

                item_menu.push({
                    label: 'Restore',
                    icon: 'pi pi-refresh',
                    command: () => {
                        this.itemAction('restore');
                    }
                });
            }

            if(this.item && this.item.id && !this.item.deleted_at)
            {
                item_menu.push({
                    label: 'Trash',
                    icon: 'pi pi-times',
                    command: () => {
                        this.itemAction('trash');
                    }
                });
            }

            item_menu.push({
                label: 'Delete',
                icon: 'pi pi-trash',
                command: () => {
                    this.confirmDeleteItem('delete');
                }
            });

            this.item_menu_list = item_menu;
        },
        //---------------------------------------------------------------------
        confirmDeleteItem()
        {
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
        getMenuItems() {
            this.list_bulk_menu = [
                {
                    label: 'Active All Permissions',
                    command: async () => {
                        await this.listAction('activate-all')
                    }
                },
                {
                    label: 'Inactive All Permissions',
                    command: async () => {
                        await this.listAction('deactivate-all')
                    }
                },
            ]
        },
        //---------------------------------------------------------------------
        async getPermissionMenuItems() {
            this.permission_menu_items = [
                {
                    label: 'Active All Permissions',
                    command: () => {
                        this.bulkActions(1, 'toggle-permission-active-status');
                    }
                },
                {
                    label: 'Inactive All Permissions',
                    command: () => {
                        this.bulkActions(0, 'toggle-permission-active-status');
                    }
                }
            ]
        },
        //---------------------------------------------------------------------
        async getRoleUserMenuItems() {
            this.role_user_menu_items = [
                {
                    label: 'Attach To All Users',
                    command: () => {
                        this.bulkActions(1, 'toggle-user-active-status');
                    }
                },
                {
                    label: 'Detach To All Users',
                    command: () => {
                        this.bulkActions(0, 'toggle-user-active-status');
                    }
                }
            ]
        },
        //---------------------------------------------------------------------
        hasPermission(slug) {
            const root = useRootStore();
            return vaah().hasPermission(root.permissions, slug);
        },
        //---------------------------------------------------------------------
        showProgress()
        {
            this.show_progress_bar = true;
        },
        //---------------------------------------------------------------------
        hideProgress()
        {
            this.show_progress_bar = false;
        },
        //---------------------------------------------------------------------
        strToSlug(name)
        {
            return vaah().strToSlug(name);
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }
    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSettingStore, import.meta.hot))
}
