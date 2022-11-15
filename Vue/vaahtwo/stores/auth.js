import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
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
        is_btn_loading: false,
        no_of_login_attempt: null,
        max_attempts_of_login: 5,
        sign_in_items: {
            type: 'password',
            email: null,
            password: null,
            attempts: 0,
            login_otp:null,
            max_attempts: 5,
            is_password_disabled: null,
        },
        verification: {
            otp_0: null,
            otp_1: null,
            otp_2: null,
            otp_3: null,
            otp_4: null,
            otp_5: null,
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
                this.ajax_url+'/auth/sendResetCode/post',
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
                this.ajax_url+'/auth/resetPassword/post',
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
        signIn () {
            this.no_of_login_attempt++;
            this.is_btn_loading = true;

            let params = {
                params: this.sign_in_items,
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/signin/post',
                this.signInAfter,
                params
            );
        },
        //---------------------------------------------------------------------
        signInAfter (data, res) {
            this.is_btn_loading = false
            console.log(data.redirect_url);

            if(data) {
                if(data.verification_response && data.verification_response.status
                    && data.verification_response.status === 'success') {
                    this.is_verification_form_visible = true;
                } else {
                    window.location = data.redirect_url+'#/dashboard';
                }
            }
        },
        //-----------------------------------------------------------------------
        generateOTP: function () {
            this.is_btn_loading = true;

            let params = {
                params: this.sign_in_items,
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/signin/generate/otp',
                this.generateOTPAfter,
                params
            );
        },
        //---------------------------------------------------------------------
        generateOTPAfter: function (data, res) {
            this.is_btn_loading = false;
            if (data) {

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
