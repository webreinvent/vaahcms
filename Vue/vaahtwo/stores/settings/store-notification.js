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
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        activeSubTab:0,
        assets:null,
        fillable:null,
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
        checked:true,
        activeNotification:null,
        notifications: null,
        notification_variables: null,
        notification_actions: null,
        help_urls: null,
        content:null,
        active_notification:null,
    }),
    getters: {

    },
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
        },
        //---------------------------------------------------------------------
        searchCountry(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredCountries = [...this.countries];
                }
                else {
                    this.filteredCountries = this.countries.filter((country) => {
                        return country.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        async showNotificationSettings(item){
            this.active_notification = vaah().findInArrayByKey(this.notifications,'id',item.id)
            let options = {
                method:'post',
                query: item
            };
            await vaah().ajax(
                this.ajax_url+'/list',
                this.afterShowNotificationSettings,
                options
            );
        },
        //---------------------------------------------------------------------
        afterShowNotificationSettings(data, res){
            if(data){
                this.content = data.list;
            }
        },
        //---------------------------------------------------------------------
        hideNotificationSettings(){
            this.show  = false;
            this.activeNotification = null;
        },
        //---------------------------------------------------------------------
        getCopy(value) {
            // let copyText = "{!! config('settings.global."+value+"'); !!}";
            navigator.clipboard.writeText(value);
            vaah().toastSuccess(['Copied']);
        },
    }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useNotificationStore, import.meta.hot))
}
