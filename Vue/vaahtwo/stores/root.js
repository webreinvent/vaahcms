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
        is_forgot_password_btn_loading: false,
        forgot_password_items: {
            email: null,
        }
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
        //-----------------------------------------------------------------------
        onSendCode()
        {
            console.log('hi');
            this.is_forgot_password_btn_loading = true;
            let params = {
                params: this.forgot_password_items,
                method: 'post',
            };
            vaah().ajax(
                this.ajax_url+'/sendResetCode/post',
                this.onSendCodeAfter,
                params
            );

        },
        //-----------------------------------------------------------------------
        onSendCodeAfter(data, res)
        {
            this.is_forgot_password_btn_loading = false;
            if(data)
            {
                this.$router.push({ name: 'dashboard' })
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
