import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

export const useRootStore = defineStore({
    id: 'root',
    state: () => ({
        assets: null,
        assets_is_fetching: true,
        ajax_url: ajax_url,
        json_url: json_url,
        gutter: 20,
        show_progress_bar: false,
        is_installation_verified: false,
        is_forgot_password_btn_loading: false,
        forgot_password_items: {
            email: null,
        },
        is_reset_password_btn_loading: false,
        reset_password_items: {
            reset_password_code: null,
            password: null,
            password_confirmation: null,
        },
    }),
    getters: {},
    actions: {
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                let params = {
                };

                vaah().ajax(
                    this.json_url+'/assets',
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
        //---------------------------------------------------------------------
        async verifyInstallStatus() {

            let params = {
            };

            vaah().ajax(
                this.ajax_url+'/setup/json/status',
                this.afterVerifyInstallStatus,
                params
            );

        },


        //---------------------------------------------------------------------
        afterVerifyInstallStatus(data, res)
        {
            if(data)
            {

                if(data.stage !== 'installed')
                {
                    this.$router.push({name : 'setup.index'});
                }

                this.is_installation_verified = true;

            }
        },
        //-----------------------------------------------------------------------
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
    import.meta.hot.accept(acceptHMRUpdate(useRootStore, import.meta.hot))
}
