import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url+'/auth';
let json_url = ajax_url + "/json";

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
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
        sendCode()
        {
            this.is_forgot_password_btn_loading = true;
            let params = {
                params: this.forgot_password_items,
                method: 'post',
            };
            vaah().ajax(
                this.ajax_url+'/sendResetCode/post',
                this.sendCodeAfter,
                params
            );

        },
        //-----------------------------------------------------------------------
        sendCodeAfter(data, res)
        {
            this.is_forgot_password_btn_loading = false;
            if(data)
            {
                this.$router.push({ name: 'dashboard' })
            }
        },
        //-----------------------------------------------------------------------
        resetPassword()
        {
            this.is_reset_password_btn_loading = true;
            let params = {
                params: this.reset_password_items,
                method: 'post',
            };
            vaah().ajax(
                this.ajax_url+'/resetPassword/post',
                this.resetPasswordAfter,
                params
            );
        },
        //-----------------------------------------------------------------------
        resetPasswordAfter(data, res)
        {
            this.is_reset_password_btn_loading = false;
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
    import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))
}
