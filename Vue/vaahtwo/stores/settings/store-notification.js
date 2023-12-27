import {watch} from 'vue'
import {acceptHMRUpdate, defineStore} from 'pinia'
import qs from 'qs'
import countriesData from "../../assets/data/country.json";
import {vaah} from '../../vaahvue/pinia/vaah'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/notifications";


let empty_states = {
    query: {
        page: 1,
        rows: 20,
        filter: {
            q: null,
            trashed: null,
            sort: null,

        },
        recount: null,
    },

    action: {
        type: null,
        items: [],
    },

};
export const useNotificationStore = defineStore({
    id: 'notifications',
    state: () => ({
        title: 'Notifications - Settings - ',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        activeSubTab: 0,
        assets: null,
        rows_per_page: [10, 20, 30, 50, 100, 500],
        fillable: null,
        empty_query: empty_states.query,
        firstElement: null,
        query: vaah().clone(empty_states.query),
        empty_action: empty_states.action,
        action: vaah().clone(empty_states.action),
        list: null,
        route: null,
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
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
        name: null,
        countries: null,
        selectedCountry1: null,
        filteredCountries: null,
        checked: true,
        activeNotification: null,
        notifications: null,
        notification_variables: null,
        notification_actions: null,
        help_urls: null,
        active_notification: null,
        is_add_from_disabled: false,
        is_add_subject_disabled: false,
        is_testing: false,
        send_to: null,
        users: null,
        user_list: null,
        show_new_item_form: false,
        new_item: {
            name: null,
        },
        searched_notification_variables: null,
        notification: null,
    }),
    getters: {},
    actions: {
        async onLoad(route) {
            /**
             * Set initial routes
             */
            this.route = route;

            /**
             * Update with view and list css column number
             */
            /**
             * Update query state with the query parameters of url
             */
            await this.updateQueryFromUrl(route);
        },

        async updateQueryFromUrl(route) {
            if (route.query) {
                if (Object.keys(route.query).length > 0) {
                    for (let key in route.query) {
                        this.query[key] = route.query[key]
                    }
                    this.countFilters(route.query);
                }
            }
        },

        watchRoutes(route) {
            //watch routes
            this.watch_stopper = watch(route, (newVal, oldVal) => {

                    if (this.watch_stopper && !newVal.name.includes(this.route_prefix)) {
                        this.watch_stopper();

                        return false;
                    }

                    this.route = newVal;
                }, {deep: true}
            )


        },
        //---------------------------------------------------------------------
        watchStates() {
            watch(this.query.filter, (newVal, oldVal) => {
                    this.delayedSearch();
                }, {deep: true}
            );


        },
        //---------------------------------------------------------------------
        async getAssets() {
            if (this.assets_is_fetching === true) {
                this.assets_is_fetching = false;

                let options = {
                    query: vaah().clone(this.query)
                };
                await this.updateUrlQueryString(this.query);
                await vaah().ajax(
                    this.ajax_url + '/assets',
                    await this.afterGetAssets,
                    options.query
                );
            }
        },
        //---------------------------------------------------------------------
        async afterGetAssets(data, res) {
            if (data) {
                await this.getList();
                if (this.route.params.id) {
                    await this.showNotificationSettings(this.route.params);
                }
                this.assets = data;
                this.notifications = data.notifications;
                this.notification_variables = data.notification_variables.success;
                this.notification_actions = data.notification_actions.success;
                this.help_urls = data.help_urls;




            }
            this.getUser();
        },

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
        async afterGetList(data, res) {

            this.query.recount = null;

            if (data) {
                this.list = data;
                this.query.rows = data.per_page;
            }
        },
        async delayedSearch() {
            let self = this;
            this.query.page = 1;
            this.action.items = [];
            clearTimeout(this.search.delay_timer);
            this.search.delay_timer = setTimeout(async function () {
                await self.updateUrlQueryString(self.query);
                await self.getList();
            }, this.search.delay_time);
        },

        async updateUrlQueryString(query) {
            //remove reactivity from source object
            query = vaah().clone(query)

            //create query string
            let query_string = qs.stringify(query, {
                skipNulls: true,
            });
            let query_object = qs.parse(query_string);

            if (query_object.filter) {
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
        countFilters: function (query) {
            this.count_filters = 0;
            if (query && query.filter) {
                let filter = vaah().cleanObject(query.filter);
                this.count_filters = Object.keys(filter).length;
            }
        },
        //---------------------------------------------------------------------
        async getUser() {
            await vaah().ajax(
                this.base_url + '/json/users/',
                this.afterGetUser,
            );
        },
        //---------------------------------------------------------------------
        afterGetUser(data, res) {
            if (res) {
                this.users = res.data;
            }
        },
        //---------------------------------------------------------------------
        searchCountry(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredCountries = [...this.countries];
                } else {
                    this.filteredCountries = this.countries.filter((country) => {
                        return country.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        async showNotificationSettings(item) {

            this.item = item;
            this.$router.push({name: 'notification-form.index', params:{id:item.id}})
            this.active_notification = vaah().findInArrayByKey(this.list.data, 'id', item.id);

            let options = {
                method: 'post',
                query: item,
            };

            vaah().ajax(
                this.ajax_url + '/get-item',
                this.afterShowNotificationSettings,
                options
            );

        },
        //---------------------------------------------------------------------
        afterShowNotificationSettings(data, res) {
            if (data) {
                this.active_notification.contents = data.list;
                if (this.active_notification.via_mail) {
                    if (data.list.mail.length < 1) {
                        this.addMailContent();
                    } else {
                        this.setMailButton();
                    }

                }

                if (this.active_notification.via_sms && data.list.sms.length < 1) {
                    this.addSmsContent();
                }

                if (this.active_notification.via_push && data.list.push.length < 1) {
                    this.addPushContent();
                }

                if (this.active_notification.via_backend && data.list.backend.length < 1) {
                    this.addBackendContent();
                }

                if (this.active_notification.via_frontend && data.list.frontend.length < 1) {
                    this.addFrontendContent();
                }
            }
            this.setMailButton();
        },
        //---------------------------------------------------------------------
        addToMail(key) {
            let sort = 0;
            if (this.active_notification.contents && this.active_notification.contents.mail) {
                sort = this.active_notification.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_notification.id,
                via: 'mail',
                sort: sort,
                key: key,
                value: null,
            }

            this.active_notification.contents.mail.push(line);

        },
        //---------------------------------------------------------------------
        addAction() {
            let sort = 0;
            if (this.active_notification.contents && this.active_notification.contents.mail) {
                sort = this.active_notification.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_notification.id,
                via: 'mail',
                sort: sort,
                key: 'action',
                value: null,
                meta: {
                    action: null
                }
            };

            this.active_notification.contents.mail.push(line);

        },
        //---------------------------------------------------------------------
        addSubject() {
            let sort = 0;
            if (this.active_notification.contents && this.active_notification.contents.mail) {
                sort = this.active_notification.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_notification.id,
                via: 'mail',
                sort: sort,
                key: 'subject',
                value: null,
            };

            this.active_notification.contents.mail.push(line);
        },
        //---------------------------------------------------------------------
        addFrom() {
            let sort = 0;
            if (this.active_notification.contents && this.active_notification.contents.mail) {
                sort = this.active_notification.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_notification.id,
                via: 'mail',
                sort: sort,
                key: 'from',
                value: this.assets.email,
                meta: {
                    name: null
                }
            };

            this.active_notification.contents.mail.push(line);
        },
        //---------------------------------------------------------------------
        addMailContent() {
            let lines = [
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'mail',
                    sort: 0,
                    key: 'subject',
                    value: null,
                }
            ];

            this.active_notification.contents.mail = lines;
            this.setMailButton();
        },
        //---------------------------------------------------------------------
        setMailButton() {
            this.is_add_from_disabled = false;
            this.is_add_subject_disabled = false;

            if (this.active_notification && this.active_notification.contents
                && this.active_notification.contents.mail) {
                this.active_notification.contents.mail.forEach((mail, key) => {
                    if (mail.key === 'from') {
                        this.is_add_from_disabled = true;
                    }

                    if (mail.key === 'subject') {
                        this.is_add_subject_disabled = true;
                    }
                });
            }
        },
        //---------------------------------------------------------------------
        addSmsContent() {
            let sms_lines = [
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'sms',
                    sort: 0,
                    key: 'content',
                    value: null,
                }
            ];

            this.active_notification.contents.sms = sms_lines;
        },
        //---------------------------------------------------------------------
        addPushContent() {

            let lines = [
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'push',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'push',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.active_notification.contents.push = lines;
        },
        //---------------------------------------------------------------------
        addBackendContent() {
            let lines = [
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'backend',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'backend',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.active_notification.contents.backend = lines;

        },
        //---------------------------------------------------------------------
        addFrontendContent() {
            let lines = [
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'frontend',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_notification.id,
                    via: 'frontend',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.active_notification.contents.frontend = lines;
        },
        //---------------------------------------------------------------------
        async hideNotificationSettings() {
            this.active_notification = null;
           await this.resetUrlQuery();
            await this.getAssets();
        },
        async resetUrlQuery() {
            this.route.params.id   = null;
            await this.$router.replace({query: null});
            await this.$router.push({name: 'notifications.index'})
            await this.updateUrlQueryString(this.query);
        },
        //---------------------------------------------------------------------
        getCopy(value) {
            // let copyText = "{!! config('settings.global."+value+"'); !!}";
            navigator.clipboard.writeText(value);
            vaah().toastSuccess(['Copied']);
        },
        //---------------------------------------------------------------------
        removeContent(item, via) {
            let lines = vaah().removeInArrayByKey(this.active_notification.contents[via], item, 'sort');

            this.active_notification.contents[via] = lines;
        },
        //---------------------------------------------------------------------
        async storeNotification() {
            let options = {
                method: 'post',
                params: this.active_notification
            };

            let ajax_url = this.ajax_url + '/store';
            await vaah().ajax(ajax_url, null, options);
        },
        //---------------------------------------------------------------------
        async sendNotification() {
            this.is_sending = true;
            let options = {
                method: 'post',
                params: {
                    notification_id: this.active_notification.id,
                    user_id: this.send_to.id
                }
            };

            let ajax_url = this.ajax_url + '/send';
            await vaah().ajax(ajax_url, null, options);
        },
        //---------------------------------------------------------------------
        searchUser(event) {
            if (!event.query.trim().length) {
                this.user_list = this.users;
            } else {
                this.user_list = this.users.filter((user) => {
                    return user.name.toLowerCase().startsWith(event.query.toLowerCase());
                });
            }
        },
        //---------------------------------------------------------------------
        addNewNotification() {
            this.show_new_item_form = !this.show_new_item_form;
        },
        //---------------------------------------------------------------------
        async create() {
            let query = {
                item: this.new_item,
                rows: this.query.rows
            }

            let options = {
                method: 'post',
                params: query
            };

            let ajax_url = this.ajax_url + '/create';
            await vaah().ajax(ajax_url, this.createAfter, options);
        },
        //---------------------------------------------------------------------
        async createAfter(data, res) {
            this.new_item.name = null;
            await this.getList();
        },
        //---------------------------------------------------------------------
        searchNotificationVarialbles(event) {
            if (!event.query.trim().length) {
                this.searched_notification_variables = this.users;
            } else {
                this.searched_notification_variables = this.notification_variables.filter((variables) => {
                    return variables.name.toLowerCase().startsWith(event.query.toLowerCase());
                });
            }
        },
        //---------------------------------------------------------------------
        async callShowNotificationSettings() {
            // this.active_notification = this.notification;
            const item = vaah().findInArrayByKey(this.assets.notifications, 'id', this.notification);
            await this.showNotificationSettings(item);
        },
        //---------------------------------------------------------------------
        async clearNotificationSearch() {
            this.notification = null;
            this.active_notification = null;
            await this.getAssets();
        },
        //---------------------------------------------------------------------
        getNotificationDcoument(url) {
            window.open(url, '_blank');
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        },
        async paginate(event) {
            this.query.page = event.page + 1;
            this.query.rows = event.rows;
            this.firstElement = this.query.rows * (this.query.page - 1);
            await this.getList();
        },
        //---------------------------------------------------------------------

        itemAction(type, item = null) {

            if (!item) {
                item = this.item;
            }

            this.form.action = type;

            let ajax_url = this.ajax_url;

            let options = {
                method: 'post',
            };

            switch (type) {

                /**
                 * Delete a record, hence method is `DELETE`
                 * and no need to send entire `item` object
                 * https://docs.vaah.dev/guide/laravel.html#delete-a-record-hard-deleted
                 */
                case 'trash':
                    options.method = 'DELETE';
                    ajax_url += '/' + item.id + '/action/' + type;
                    break;
                /**
                 * Update a record's one column or very few columns,
                 * hence the method is `PATCH`
                 * https://docs.vaah.dev/guide/laravel.html#update-a-record-update-soft-delete-status-change-etc
                 */
                default:
                    options.method = 'PUT';
                    ajax_url += '/' + item.id + '/action/' + type;
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
            }

        },
        onItemSelection(items) {
            this.action.items = items;
        },
        isViewLarge() {
            return this.view === 'large';
        },
//---------------------------------------------------------------------------

        async listAction(type = null) {
            if (!type && this.action.type) {
                type = this.action.type;
            } else {
                this.action.type = type;
            }

            let url = this.ajax_url + '/action/' + type
            let method = 'PUT';

            switch (type) {
                case 'delete':
                    method = 'DELETE';
                    break;
                case 'trash':
                    method = 'DELETE';
                    break;
                case 'delete-all':
                    method = 'DELETE';
                    break;
            }
            this.action.filter = this.query.filter;

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

        isListActionValid() {

            if (!this.action.type) {
                vaah().toastErrors(['Select an action type']);
                return false;
            }

            if (this.action.items.length < 1) {
                vaah().toastErrors(['Select records']);
                return false;
            }

            return true;
        },
        async updateList(type = null) {

            if (!type && this.action.type) {
                type = this.action.type;
            } else {
                this.action.type = type;
            }

            if (!this.isListActionValid()) {
                return false;
            }


            let method = 'PUT';

            switch (type) {
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
                this.ajax_url + '/action/' + type,
                this.updateListAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        async updateListAfter(data, res) {
            if (data) {
                this.action = vaah().clone(this.empty_action);
                await this.getList();
            }
        },

        confirmDelete() {
            if (this.action.items.length < 1) {
                vaah().toastErrors(['Select a record']);
                return false;
            }
            this.action.type = 'delete';
            vaah().confirmDialogDelete(this.listAction);
        },
        //---------------------------------------------------------------------
        confirmDeleteAll() {
            this.action.type = 'delete-all';
            vaah().confirmDialogDelete(this.listAction);
        },

        async getListSelectedMenu() {
            this.list_selected_menu = [
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
        getListBulkMenu() {
            this.list_bulk_menu = [

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
        async clearSearch() {
            this.query.filter.q = null;
            await this.updateUrlQueryString(this.query);
            await this.getList();
        },
        async resetQuery() {
            //reset query strings
            await this.resetQueryString();

            //reload page list
            await this.getList();
        },
        //---------------------------------------------------------------------
        async resetQueryString() {
            for (let key in this.query.filter) {
                this.query.filter[key] = null;
            }
            await this.updateUrlQueryString(this.query);
        },
    }
});


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useNotificationStore, import.meta.hot))
}
