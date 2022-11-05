import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json/setup";

export const useSetupStore = defineStore({
    id: 'setup',
    state: () => ({
        assets: null,
        assets_is_fetching: true,
        ajax_url: ajax_url,
        json_url: json_url,
        status: null,
        gutter: 20,
        items: [
            {
                label: 'Publish assets'
            },
            {
                label: 'Clear Cache'
            }
        ],
        install_items: [
            {
                label: 'Configuration',
                icon: 'pi pi-fw pi-cog',
                to: '/ui/public/install/configuration'
            },
            {
                label: 'Migrate',
                icon: 'pi pi-fw pi-database',
                to: '/ui/public/install/migrate'
            },
            {
                label: 'Dependencies',
                icon: 'pi pi-fw pi-server',
                to: '/ui/public/install/dependencies'
            },
            {
                label: 'Account',
                icon: 'pi pi-fw pi-user-plus',
                to: '/ui/public/install/account'
            }
        ],
        show_progress_bar: false,
    }),
    getters: {},
    actions: {
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                let params = {
                };

                vaah().ajax(
                    this.json_url+'-assets',
                    this.afterGetAssets,
                    params
                );
            }
        },


        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;

            }
        },
        async getStatus() {

            let params = {
            };

            vaah().ajax(
                this.json_url+'/status',
                this.afterGetStatus,
                params
            );

        },


        //---------------------------------------------------------------------
        afterGetStatus(data, res)
        {
            if(data)
            {
                this.status = data;

            }
        },
        publishAssets() {

            this.showProgress();

            let params = {
            };

            vaah().ajax(
                this.json_url+'/publish/assets',
                this.afterPublishAssets,
                params
            );

        },


        //---------------------------------------------------------------------
        afterPublishAssets(data, res)
        {
            this.hideProgress();
        },


        //---------------------------------------------------------------------
        routeAction(name)
        {
            this.$router.push({name: name})
        },
        async to(path)
        {
            this.$router.push({path: path})
        },
        showProgress()
        {
            this.show_progress_bar = true;
        },
        hideProgress()
        {
            this.show_progress_bar = false;
        }

    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSetupStore, import.meta.hot))
}
