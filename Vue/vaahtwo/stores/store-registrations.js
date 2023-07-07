import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import qs from 'qs'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Registration';

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/registrations";

let empty_states = {
    query: {
        page: 1,
        rows: 20,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
            status:null,
        },
    },
    action: {
        type: null,
        items: [],
    }
};

export const useRegistrationStore = defineStore({
    id: 'registrations',
    state: () => ({
        title: 'Registrations',
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
        item: {},
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
        route_prefix: 'registrations.',
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
        item_status:null,
        meta_content:null,
        display_meta_modal:false,
        is_btn_loading: false,

        gender_options: [
            {name:'Male',value:'m',icon: ''},
            {name:'Female',value:'f',icon: ''},
            {name:'Others',value:'o',icon: ''},
        ],

        filtered_country_codes: [],
        row_active:null,
        display_bio_modal: null,
        bio_modal_data: null
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
                case 'registrations.index':
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
            )
        },
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;
                if(data.rows)
                {
                    // this.setRegistrationStatuses();
                    if (!this.query.rows) {
                        this.query.rows = data.rows;
                    } else {
                        this.query.rows = parseInt(this.query.rows);
                    }
                }

                if(this.route.params && !this.route.params.id){
                    this.item = vaah().clone(data.empty_item);
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
            if(data)
            {
                this.list = data;
                this.firstElement = this.query.rows * (this.query.page - 1);
            }

            this.is_btn_loading = false;
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
            } else {
                this.$router.push({name: 'registrations.index'});
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
        async itemActionAfter(data, res)
        {
            if(data)
            {

                this.item = data.item;
                await this.getList();
                await this.formActionAfter();
                this.getItemMenu();
            }
        },
        //---------------------------------------------------------------------
        async formActionAfter ()
        {


            switch (this.form.action)
            {
                case 'create-and-new':
                    this.setActiveItemAsEmpty();
                    break;
                case 'create-and-clone':
                    this.item.id = null;
                    break;
                case 'save-and-new':
                    this.setActiveItemAsEmpty();
                    this.route.params.id = null;
                    this.$router.push({name: 'registrations.form'});
                    break;
                case 'create-and-close':
                case 'save-and-close':
                    this.setActiveItemAsEmpty();
                    this.$router.push({name: 'registrations.index'});
                    break;
                case 'save-and-clone':
                    this.item.id = null;
                    break;
                case 'trash':
                    // this.item = null;
                    break;
                case 'delete':
                    this.item = null;
                    this.toList();
                    break;
            }
            this.getFormMenu();
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

            this.query.page = this.page;
            this.query.rows = this.rows;

            await this.updateUrlQueryString(this.query);
        },
        //---------------------------------------------------------------------
        closeForm()
        {
            this.$router.push({name: 'registrations.index'})
        },
        //---------------------------------------------------------------------
        toList()
        {
            this.item = null;
            this.$router.push({name: 'registrations.index'})
        },
        //---------------------------------------------------------------------
        toForm()
        {
            this.item = vaah().clone(this.assets.empty_item);
            this.getFormMenu();
            this.$router.push({name: 'registrations.form'})
        },
        //---------------------------------------------------------------------
        toView(item)
        {
            this.row_active = 'is-selected';
            this.item = vaah().clone(item);
            this.$router.push({name: 'registrations.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        toEdit(item)
        {
            this.item = item;
            this.$router.push({name: 'registrations.form', params:{id:item.id}})
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
                    label: 'Email Verification Pending',
                    icon: 'pi pi-calendar-times',
                    command: async () => {
                        await this.updateList('email-verification-pending')
                    }
                },
                {
                    label: 'Email Verified',
                    icon: 'pi pi-envelope',
                    command: async () => {
                        await this.updateList('email-verified')
                    }
                },
                {
                    label: 'User Created',
                    icon: 'pi pi-user-plus',
                    command: async () => {
                        await this.updateList('user-created')
                    }
                },
                {
                    separator: true
                },
              /*  {
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
                },*/
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
                    label: 'All Users Email Verification Pending',
                    icon: 'pi pi-calendar-times',
                    command: async () => {
                        await this.listAction('email-verification-pending')
                    }
                },
                {
                    label: 'All Users Email Verified',
                    icon: 'pi pi-envelope',
                    command: async () => {
                        await this.listAction('email-verified')
                    }
                },
                {
                    label: 'All User Created',
                    icon: 'pi pi-user-plus',
                    command: async () => {
                        await this.listAction('user-created')
                    }
                },
                {
                    separator: true
                },
               /* {
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
                },*/
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

            if(this.item && this.item.id )
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
                return this.assets.fields[key].to_registration
            }

            return false;
        },
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
        checkHidden(item)
        {
            let select_array = vaah().findInArrayByKey(this.assets.custom_fields.value, 'slug', item);
            return select_array.is_hidden;
        },
        //---------------------------------------------------------------------
        openModal(item){
            this.meta_content = JSON.stringify(item,null,2);
            this.display_meta_modal=true;
        },
        //---------------------------------------------------------------------
        async sync() {
            this.is_btn_loading = true;
            await this.getList();
        },
        //---------------------------------------------------------------------
        displayBioModal(item) {
            this.display_bio_modal = true;
            this.bio_modal_data = item;
        },
        //---------------------------------------------------------------------
        registrationStatus() {
            if (!this.assets) return;
            const store = this;
            let itemList = [];

            this.assets.registration_statuses.forEach(function(key,index) {
                itemList.push({
                    label: key.name,
                    command: () => {
                        store.changeStatus(key.slug);
                    }
                });
            });

            return [{
                items: itemList
            }];
        },
        //---------------------------------------------------------------------
        userCreatedOption() {
            if (!this.assets) return;
            const store = this;
            let itemList = [{
                label: 'Create User & Send Welcome Email',
                command: () => {
                    store.confirmCreateUser(null,true);
                }
            }];

            return [{
                items: itemList
            }];
        },
        //---------------------------------------------------------------------
        changeStatus(status) {
            this.item.status=status;
            this.itemAction('save');
        },
        //---------------------------------------------------------------------
        confirmCreateUser(item=null,can_send_mail = false){
            if(!item)
            {
                item = this.item;
            }
            let ajax_url = this.ajax_url+'/'+item.id+'/'+'createUser';
            let options = {
                method:'post',
            };
            options.params= {
                'ids': [item.id],
                'can_send_mail': can_send_mail,
            };

            vaah().ajax(
                ajax_url,
                this.confirmCreateUserAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async confirmCreateUserAfter(data, res){
            if(data)
            {
                this.item = data.item;
                await this.getList()
                this.getItemMenu();
            }
        },
        //---------------------------------------------------------------------
        sendVerificationEmail(item=null){
            if(!item)
            {
                item = this.item;
            }
            let ajax_url = this.ajax_url+'/'+item.id+'/'+'send-verification-mail';
            let options = {
                method:'PATCH',
            };
            options.params=[item.id];

            vaah().ajax(
                ajax_url,
                this.sendVerificationEmailAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async sendVerificationEmailAfter(data, res){
            if(data)
            {
                this.item = data.item;
                await this.getList()
                this.getItemMenu();
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
    import.meta.hot.accept(acceptHMRUpdate(useRegistrationStore, import.meta.hot))
}
