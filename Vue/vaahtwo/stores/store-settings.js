import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../vaahvue/pinia/vaah'
import { useRootStore } from "./root";


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings";

export const useSettingStore = defineStore({
    id: 'settings',
    state: () => ({
        ajax_url: ajax_url,
        assets_is_fetching: true,
        general_assets: null,
        is_root_loaded: false,
        sidebar_menu_items: [],
    }),
    getters: {

    },
    actions: {
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
        sidebarMenuItems() {
            const root = useRootStore();
            this.sidebar_menu_items = [
                {
                    label: root.assets.language_string.sidebar_menu.settings,
                    items: [
                        {
                            label: root.assets.language_string.sidebar_menu.general,
                            icon: 'pi pi-cog',
                            to: {path: '/vaah/settings/general'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.user_settings,
                            icon: 'pi pi-user',
                            to: {path: '/vaah/settings/user-settings'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.env_variables,
                            icon: 'pi pi-cog',
                            to: {path: '/vaah/settings/env-variables'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.localizations,
                            icon: 'pi pi-code',
                            to: {path: '/vaah/settings/localization'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.notifications,
                            icon: 'pi pi-bell',
                            to: {path: '/vaah/settings/notifications'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.update,
                            icon: 'pi pi-download',
                            to: {path: '/vaah/settings/update'}
                        },
                        {
                            label: root.assets.language_string.sidebar_menu.reset,
                            icon: 'pi pi-refresh',
                            to: {path: '/setup'}
                        },
                    ]
                }]

        },
    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSettingStore, import.meta.hot))
}
