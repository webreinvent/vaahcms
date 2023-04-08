import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import qs from 'qs'
import countriesData from "../../assets/data/country.json";
import { vaah } from '../../vaahvue/pinia/vaah'
let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/notifications";

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
        fillable: null,
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
        is_testing:false,
        send_to:null,
        users:null,
        user_list:null,
        show_new_item_form:false,
        new_item: {
            name: null,
        },
        searched_notification_variables:null,
       notification: null,
    }),
    getters: {},
    actions: {
        //---------------------------------------------------------------------
        async getAssets() {
            if (this.assets_is_fetching === true) {
                this.assets_is_fetching = false;

                await vaah().ajax(
                    this.ajax_url + '/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res) {
            if (data) {
                this.assets = data;
                this.notifications = data.notifications;
                this.notification_variables = data.notification_variables.success;
                this.notification_actions = data.notification_actions.success;
                this.help_urls = data.help_urls;
            }
            this.getUser();
        },
        //---------------------------------------------------------------------
        async getUser(){
            await vaah().ajax(
                this.base_url+'/json/users/',
                this.afterGetUser,
            );
        },
        //---------------------------------------------------------------------
        afterGetUser(data, res){
            if(res){
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
            this.active_notification = vaah().findInArrayByKey(this.notifications, 'id', item.id);

            let options = {
                method: 'post',
                query:  item,
            };

            vaah().ajax(
                this.ajax_url + '/list',
                this.afterShowNotificationSettings,
                options
            );
        },
        //---------------------------------------------------------------------
        afterShowNotificationSettings(data, res) {
            if (data) {
                this.active_notification.contents = data.list;
                if(this.active_notification.via_mail)
                {
                    if(data.list.mail.length < 1){
                        this.addMailContent();
                    }else{
                        this.setMailButton();
                    }

                }

                if(this.active_notification.via_sms && data.list.sms.length < 1)
                {
                    this.addSmsContent();
                }

                if(this.active_notification.via_push && data.list.push.length < 1)
                {
                    this.addPushContent();
                }

                if(this.active_notification.via_backend && data.list.backend.length < 1)
                {
                    this.addBackendContent();
                }

                if(this.active_notification.via_frontend && data.list.frontend.length < 1)
                {
                    this.addFrontendContent();
                }
            }
            this.setMailButton();
        },
        //---------------------------------------------------------------------
        addToMail(key) {
            let sort = 0;
            if(this.active_notification.contents && this.active_notification.contents.mail)
            {
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
            if(this.active_notification.contents && this.active_notification.contents.mail)
            {
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
            if(this.active_notification.contents && this.active_notification.contents.mail)
            {
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
            if(this.active_notification.contents && this.active_notification.contents.mail)
            {
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
        addMailContent()
        {
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
            this.is_add_from_disabled =  false;
            this.is_add_subject_disabled =  false;

            if(this.active_notification && this.active_notification.contents
                && this.active_notification.contents.mail){
                this.active_notification.contents.mail.forEach((mail,key) => {
                    if(mail.key === 'from'){
                        this.is_add_from_disabled =  true;
                    }

                    if(mail.key === 'subject'){
                        this.is_add_subject_disabled =  true;
                    }
                });
            }
        },
        //---------------------------------------------------------------------
        addSmsContent(){
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
        hideNotificationSettings() {
            this.active_notification = null;
            this.getAssets();
        },
        //---------------------------------------------------------------------
        getCopy(value) {
            // let copyText = "{!! config('settings.global."+value+"'); !!}";
            navigator.clipboard.writeText(value);
            vaah().toastSuccess(['Copied']);
        },
        //---------------------------------------------------------------------
        removeContent(item, via)
        {
            let lines = vaah().removeInArrayByKey(this.active_notification.contents[via], item, 'sort');

            this.active_notification.contents[via] = lines;
        },
        //---------------------------------------------------------------------
        async storeNotification() {
            let options = {
                method: 'post',
                params: this.active_notification
            };

            let ajax_url = this.ajax_url+'/store';
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

            let ajax_url = this.ajax_url+'/send';
            await vaah().ajax(ajax_url, this.sendNotificationAfter, options);
        },
        //---------------------------------------------------------------------
        sendNotificationAfter(data, res) {
            if(data){
                vaah().toastSucces(['Sent']);
            }

        },
        //---------------------------------------------------------------------
        searchUser(event){
            if (!event.query.trim().length) {
                this.user_list = this.users;
            }
            else {
                this.user_list = this.users.filter((user) => {
                    return user.name.toLowerCase().startsWith(event.query.toLowerCase());
                });
            }
        },
        //---------------------------------------------------------------------
        addNewNotification(){
            this.show_new_item_form = !this.show_new_item_form;
        },
        //---------------------------------------------------------------------
        async create() {

            let options = {
                method: 'post',
                params: this.new_item
            };

            let ajax_url = this.ajax_url+'/create';
            await vaah().ajax(ajax_url, this.createAfter, options);
        },
        //---------------------------------------------------------------------
        createAfter(data, res){
            this.show_new_item_form = false;
            this.active_notification = data.item;
            this.getAssets();
        },
        //---------------------------------------------------------------------
        searchNotificationVarialbles(event){
            if (!event.query.trim().length) {
                this.searched_notification_variables = this.users;
            }
            else {
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
        getNotificationDcoument(url){
            window.open(url,'_blank');
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
    import.meta.hot.accept(acceptHMRUpdate(useNotificationStore, import.meta.hot))
}
