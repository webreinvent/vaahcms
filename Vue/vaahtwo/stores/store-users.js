import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\User';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/users";

let empty_states = {
    query: {
        page: 1,
        rows: 20,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
        },
        recount: null,
    },

    action: {
        type: null,
        items: [],
    },

    user_roles_query: {
        q: null,
        page: null,
        rows: null,
    }
};

export const useUserStore = defineStore({
    id: 'users',
    state: () => ({
        title: 'Users',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        assets: null,
        user_roles:null,
        displayModal:false,
        modalData:null,
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
        route_prefix: 'users.',
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
        filtered_timezone_codes:[],
        filtered_country_codes:[],
        form_menu_list: [],
        gender_options: [
            {
                label: 'Male',
                value: 'male'
            },
            {
                label: 'Female',
                value: 'female'
            },
            {
                label: 'Others',
                value: 'others'
            }
        ],
        status_options: [
            {
                label: 'Active',
                value: 'active'
            },
            {
                label: 'Inactive',
                value: 'inactive'
            },
            {
                label: 'Blocked',
                value: 'blocked'
            },
            {
                label: 'Banned',
                value: 'banned'
            },

        ],

        user_roles_menu: null,
        meta_content: null,
        user_roles_query: vaah().clone(empty_states.user_roles_query),
        is_btn_loading: false,
        display_meta_modal: false,
        custom_fields_data:[],
        display_bio_modal: null,
        bio_modal_data: null,
        firstElement: null,
        rolesFirstElement: null,
        email_error:{
            class:'',
            msg:''

        }
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
            this.firstElement = ((this.query.page - 1) * this.query.rows);
            this.rolesFirstElement = ((this.user_roles_query.page - 1) * this.user_roles_query.rows);
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
                case 'users.index':
                    this.view = 'large';
                    this.list_view_width = 12;
                    break;
                default:
                    this.view = 'small';
                    this.list_view_width = 7;
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
                    if (newVal.params.id) {
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

            watch(this.user_roles_query, async (newVal,oldVal) =>
                {
                    await this.delayedUserRolesSearch();
                },{deep: true}
            )
        },
        //---------------------------------------------------------------------
        async getAssets() {

            if (this.assets_is_fetching === true) {
                this.assets_is_fetching = false;

                vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res) {
            if (data) {
                this.assets = data;

                if (data.rows) {
                    if (!this.query.rows) {
                        this.query.rows = data.rows;
                    } else {
                        this.query.rows = parseInt(this.query.rows);
                    }
                    this.user_roles_query.rows = data.rows;
                }

                if (this.route.params && !this.route.params.id) {
                    this.item = vaah().clone(data.empty_item);
                }

            }
        },
        //--------------------------------------------------------------------
        searchTimezoneCode: function (event){
            this.timezone_name_object = null;
            this.timezone = null;
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filtered_timezone_codes = this.assets.timezones;
                }else {
                    this.filtered_timezone_codes = this.assets.timezones.filter((timezone) => {
                        return timezone.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);

        },
        //---------------------------------------------------------------------
        onSelectTimezoneCode: function (event){
            this.item.timezone = event.value.slug;
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        searchCountryCode: function (event){
            this.country_name_object = null;
            this.country = null;

            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filtered_country_codes = this.assets.countries;
                }
                else {
                    this.filtered_country_codes = this.assets.countries.filter((country) => {
                        return country.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        onSelectCountryCode: function (event){
            this.item.country = event.value.name;
        },
        //---------------------------------------------------------------------
        async getList() {
            let options = {
                query: vaah().clone(this.query)
            };
            await this.updateUrlQueryString(this.query);
            await vaah().ajax(
                this.ajax_url,
                await this.afterGetList,
                options
            );
        },
        //---------------------------------------------------------------------
        async afterGetList (data, res) {

            this.is_btn_loading = false;
            this.query.recount = null;

            if (data) {
                this.list = data;
                this.firstElement = this.query.rows * (this.query.page - 1);
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
                this.$router.push({name: 'users.index'});
            }
            this.getItemMenu();
            await this.getFormMenu();
        },
        //---------------------------------------------------------------------
        storeAvatar(data) {

            data.user_id = this.item.id;

            let option = {
                params: data,
                method: 'post'
            };

            let url = ajax_url+'/avatar/store';

            vaah().ajax(
                url,
                this.storeAvatarAfter,
                option
            );

        },
        //---------------------------------------------------------------------
        storeAvatarAfter(data, res)
        {
            if(data){
                this.item.avatar = data.avatar;
                this.item.avatar_url = data.avatar_url;
            }
        },
        //---------------------------------------------------------------------
        removeAvatar() {

            let option = {
                params: {
                    user_id: this.item.id
                },
                method: 'post'
            };

            let url = ajax_url+'/avatar/remove';

            vaah().ajax(
                url,
                this.removeAvatarAfter,
                option
            );

        },
        //---------------------------------------------------------------------
        removeAvatarAfter(data, res)
        {
            if(data){
                this.item.avatar = data.avatar;
                this.item.avatar_url = data.avatar_url;
            }
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
        //--------------------------------------------------------------------
        async getUserRoles () {
            this.showProgress();

            let url = this.ajax_url+'/item/' + this.item.id + '/roles';

            let params = {
                query: this.user_roles_query,
                method: 'get',
            };

             vaah().ajax(
                url,
                await this.afterGetUserRoles,
                params
            );
        },
        //---------------------------------------------------------------------
        async afterGetUserRoles(data, res) {
            this.hideProgress();

            if (data) {
                this.user_roles = data;
            }
        },
        //---------------------------------------------------------------------
        async delayedUserRolesSearch() {
            let self = this;

            if (self.item && self.item.id) {
                clearTimeout(this.search.delay_timer);
                this.search.delay_timer = setTimeout(async function() {
                    await self.getUserRoles();
                },this.search.delay_time)
            }
        },
        //---------------------------------------------------------------------
        async userRolesPaginate(event) {
            this.user_roles_query.page = event.page + 1;
            this.user_roles_query.rows = event.rows;
            await this.getUserRoles();
        },
        //---------------------------------------------------------------------
        async changeUserRole(item,id){
            let params = {
                id : id,
                role_id : item.id,
            };

            let data = {};

            if (item.pivot.is_active) {
                data.is_active = 0;
            } else {
                data.is_active = 1;
            }

            await this.actions(false, 'toggle-role-active-status', params, data)

        },
        //---------------------------------------------------------------------
        async bulkActions (input, action) {

            let params = {
                id: this.item.id,
                role_id: null
            };

            let data = {
                is_active: input
            };

            await this.actions(false, action, params, data)

        },
        //---------------------------------------------------------------------
        async actions(e, action, inputs, data) {
            if (e) {
                e.preventDefault();
            }

            let url = this.ajax_url+"/actions/"+action;

            let params = {
                inputs: inputs,
                data: data,
            };

            let options = {
                params: params,
                method: 'post',
            };

            vaah().ajax(
                url,
                await this.afterActions,
                options
            );
        },
        //---------------------------------------------------------------------
        async afterActions(data,res){
            await this.getList();
            await this.getUserRoles();
        },
        //---------------------------------------------------------------------
        showModal(item){
            this.displayModal = true;
            this.modalData = item.json;
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
                    // console.log(item);return
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
                case 'save-and-new':
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
        async itemActionAfter(data, res) {
            if (data) {
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
                    this.route.params.id = null;
                    this.$router.push({name: 'users.form'});
                    break;
                case 'create-and-close':
                case 'save-and-close':
                    this.setActiveItemAsEmpty();
                    this.$router.push({name: 'users.index'});
                    break;
                case 'save-and-clone':
                    this.item.id = null;
                    this.route.params.id = null;
                    this.$router.push({name: 'users.form'});
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
            this.query.rows = event.rows;
            this.firstElement = this.query.rows * (this.query.page - 1);
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
        async resetUserRolesFilters() {
            this.user_roles_query.q = null;
            this.user_roles_query.rows = this.assets.rows;
        },
        //---------------------------------------------------------------------
        closeForm()
        {
            this.$router.push({name: 'users.index'})
        },
        //---------------------------------------------------------------------
        toList()
        {
            this.item = null;
            this.$router.push({name: 'users.index'})
        },
        //---------------------------------------------------------------------
        toForm()
        {
            this.item = vaah().clone(this.assets.empty_item);
            this.getFormMenu();
            this.$router.push({name: 'users.form'})
        },
        //---------------------------------------------------------------------
        impersonate(item)
        {
            let options = {
                method:'post'
            };
            vaah().ajax(
                this.ajax_url+'/impersonate/'+item.uuid,
                this.afterImpersonate,
                options
            );
        },
        //---------------------------------------------------------------------
        afterImpersonate(res,data)
        {
            if(data && data.data && data.data.redirect_url){
                window.location.href = data.data.redirect_url;
                location.reload(true);
            }
        },
        //---------------------------------------------------------------------
        toView(item)
        {
            this.item = vaah().clone(item);
            this.$router.push({name: 'users.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        toEdit(item)
        {
            this.item = item;
            this.$router.push({name: 'users.form', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        async toRole(item) {
            this.item = item;
            await this.getUserRoles();
            this.$router.push({name: 'users.role', params: { id: item.id }})
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
        async getItemMenu()
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

            item_menu.push({
                label: 'Generate new API Token',
                icon: 'pi pi-key',
                command: () => {
                    this.itemAction('generate-new-token');
                }
            });

            this.item_menu_list = item_menu;
        },
        //---------------------------------------------------------------------
        async getUserRolesMenuItems() {
            return this.user_roles_menu = [
                {
                    label: 'Active All Roles',
                    command: async () => {
                        await this.bulkActions(1, 'toggle-role-active-status')
                    }
                },
                {
                    label: 'Inactive All Roles',
                    command: async () => {
                        await this.bulkActions(0, 'toggle-role-active-status')
                    }
                },
            ]
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
        //--------------------------------------------------------------------
        onUpload(){
            this.user_avatar = e.files[0];

            let formData = new FormData();

            formData.append('file', this.user_avatar);
            formData.append('folder_path', 'public/media');

            vaah().ajax(
                this.ajax_url+'/upload',
                this.uploadAfter,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    method: 'post',
                    params:  formData
                }
            );
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
                        label: 'Save & New',
                        icon: 'pi pi-plus',
                        command: () => {

                            this.itemAction('save-and-new');

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
        hasPermission(slug) {
            const root = useRootStore();
            return vaah().hasPermission(root.permissions, slug);
        },
        //---------------------------------------------------------------------
        isHidden(key) {
            if (this.assets && this.assets.fields && this.assets.fields[key]) {
                return this.assets.fields[key].is_hidden
            }

            return false;
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
        checkHidden(item)
        {
            if (this.assets && this.assets.custom_fields){
                let select_array = vaah().findInArrayByKey(this.assets.custom_fields.value, 'slug', item);
                return select_array.is_hidden;
            }
            return false;
        },
        //---------------------------------------------------------------------
        openModal(item){
            this.meta_content = JSON.stringify(item,null,2);
            this.display_meta_modal=true;
        },
        //---------------------------------------------------------------------
        setIsActiveStatus() {
            if (this.item.status === 'active') {
                this.item.is_active = 1;
            } else {
                this.item.is_active = 0;
            }
        },
        //---------------------------------------------------------------------
        async displayBioModal(item) {
            this.display_bio_modal = true;
            this.bio_modal_data = item;
        },
        //---------------------------------------------------------------------
        validateEmail() {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.item.email)) {
                this.email_error = { class: '',msg:''};
            } else {
                this.email_error = { class: 'p-invalid',msg:'Please enter a valid email address'};
            }
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
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}



