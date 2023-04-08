import {watch} from 'vue'
import {acceptHMRUpdate, defineStore} from 'pinia'
import qs, {stringify} from 'qs'
import {vaah} from '../../vaahvue/pinia/vaah'
import { useRootStore } from "../root";

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Batch';

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/batches";

let empty_states = {
    query: {
        page: 1,
        rows: 20,
        filter: {
            q: null,
            is_active: null,
            trashed: null,
            sort: null,
            from: null,
            to: null,
            date_filter_by: null
        },
    },
    action: {
        type: null,
        items: [],
    },
};

export const useBatchStore = defineStore({
    id: 'batches',
    state: () => ({
        title: 'Batches - Advanced',
        page: 1,
        rows: 20,
        dialog_content: null,
        display_detail: false,
        display_failed_ids: false,
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
        route_prefix: 'batches.',
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
        dates: [],
        first_element: null,
    }),
    actions: {
        //---------------------------------------------------------------------
        async onLoad(route)
        {
            /**
             * Set initial routes
             */

            this.route = route;
            this.first_element = ((this.query.page - 1) * this.query.rows);

            /**
             * Update query state with the query parameters of url
             */
            this.updateQueryFromUrl(route);

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
                    if (!this.query.rows) {
                        this.query.rows = data.rows;
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
                await this.getListAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async getListAfter(data) {
            this.is_btn_loading = false;

            if (data) {
                this.list = data.list;
                this.first_element = ((this.query.page - 1) * this.query.rows);
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
        async updateListAfter(data, res) {
            if(data)
            {
                this.action = vaah().clone(this.empty_action);
                await this.getList();
            }
        },
        //---------------------------------------------------------------------
        async listAction(type = null) {
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
                data: {},
                show_success: false
            };
            await vaah().ajax(
                url,
                this.updateListAfter,
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
            }
        },
        //---------------------------------------------------------------------
        async paginate(event) {
            this.query.page = event.page+1;
            this.query.rows = event.rows;
            this.first_element = ((this.query.page - 1) * this.query.rows);
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

            for(let key in this.query)
            {
                if (key === 'filter') continue;
                this.query[key] = null;
            }

            this.dates2 = null;

            this.query.page = this.page;
            this.query.rows = this.rows;

            await this.updateUrlQueryString(this.query);
        },
        //---------------------------------------------------------------------
        toList()
        {
            this.$router.push({name: 'batches.index'})
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
        async getListSelectedMenu()
        {
            this.list_selected_menu = [
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
                    label: 'Delete All',
                    icon: 'pi pi-trash',
                    command: async () => {
                        this.confirmDeleteAll();
                    }
                },
            ];
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
        getJobProgress(item,type) {
            let d = item;

            if (type===1) {
                return ((d.total_jobs - d.pending_jobs - d.failed_jobs) * 100) / d.total_jobs;
            }
            if (type===2) {
                return ((d.pending_jobs - d.failed_jobs) * 100) / d.total_jobs;
            }
            if (type===3) {
                return d.pending_jobs * 100 / d.total_jobs;
            }
        },
        displayBatchDetails(content) {
            this.dialog_content = `<pre class="is-size-6">`+content+`</pre>`;
            this.display_detail = true;
        },
        displayFailedIdDetails(content) {
            this.dialog_content = `<pre class="is-size-6">`+JSON.stringify(content)+`</pre>`;
            this.display_failed_ids = true;
        },
        deleteItem(item) {
            this.item = item;
            this.form.action = 'delete';
            vaah().confirmDialogDelete(this.itemAction);
        },
        //---------------------------------------------------------------------
        setDateRange()
        {
            if (this.dates2.length > 0) {
                let current_datetime = new Date(this.dates2[0]);
                this.query.filter.from = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate();

                current_datetime = new Date(this.dates2[1]);
                this.query.filter.to = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate();

                this.getList();
            }
        },
        //-------------------------------------------------------
        itemAction(type, item=null){
            if(!item)
            {
                item = this.item;
            }
            if (!type) {
                type = this.form.action;
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
                    options.params = { data: {}};
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
        async sync() {
            this.is_btn_loading = true;
            await this.getList();
        },
        //---------------------------------------------------------------------
        hasPermission(slug) {
            const root = useRootStore();
            return vaah().hasPermission(root.permissions, slug);
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
    import.meta.hot.accept(acceptHMRUpdate(useBatchStore, import.meta.hot))
}









