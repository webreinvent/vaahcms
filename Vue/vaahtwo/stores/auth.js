import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'
import {watch} from "vue";

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        base_url: base_url,
        ajax_url: ajax_url,
        json_url: json_url,
        gutter: 20,
        show_progress_bar: false,
        is_resend_disabled: false,
        is_installation_verified: false,
        is_forgot_password_btn_loading: false,
        forgot_password_items: {
            email: null,
        },
        title: {
            heading: 'Welcome Back',
            description: 'Please Sign in to continue',
        },
        is_mfa_visible: false,
        is_reset_password_btn_loading: false,
        verification_otp: null,
        reset_password_items: {
            reset_password_code: null,
            password: null,
            password_confirmation: null,
        },
        security_timer: 0,
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
        sign_up_items: {
            first_name: null,
            last_name:null,
            username: null,
            email: null,
            password: null,
            confirm_password: null,
        },
        is_otp_btn_loading: false,
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
                this.$router.push({ name: 'sign.in' })
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
                this.$router.push({ name: 'sign.in' })
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
                if(data.verification_response && data.verification_response.success) {
                    this.is_mfa_visible = true;
                    this.security_timer = 30;
                    this.title.heading = 'Multi-Factor Authentication';
                    this.title.description = 'You have received an email which contains two factor code.';
                    this.resendCountdown();
                } else {
                    window.location = data.redirect_url+'#/vaah';
                }
            }
        },
        //-----------------------------------------------------------------------
        signUp () {
            this.is_btn_loading = true;
            let params = {
                params: this.sign_up_items,
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/signup/post',
                this.signUpAfter,
                params
            );
        },
        //---------------------------------------------------------------------
        signUpAfter (data,) {
            this.is_btn_loading = false
            if(data) {
                setTimeout(() => {
                    window.location = data.redirect_url;
                }, 2000);
            }
        },
        //---------------------------------------------------------------------
        async verifyInstallStatus() {

            let params = {
            };

            vaah().ajax(
                this.base_url+'/setup/json/status',
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
        generateOTP: function () {
            this.is_otp_btn_loading = true;

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
            this.is_otp_btn_loading = false;
            if (data) {

            }
        },
        //---------------------------------------------------------------------
        verifySecurityOtp () {
            this.is_btn_loading = true;
            let options = {
                params: {
                    'verification_otp':this.verification_otp
                },
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/verify/security/otp',
                this.verifySecurityOtpAfter,
                options
            );


        },
        //---------------------------------------------------------------------
        verifySecurityOtpAfter (data, res) {
            this.is_btn_loading = false
            if(data && data.redirect_url)
            {
                window.location = data.redirect_url;
            }
        },
        //-----------------------------------------------------------------------
        //---------------------------------------------------------------------
        resendSecurityOtp () {
            let options = {
                params: {},
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/resend/security/otp',
                null,
                options
            );
            this.is_resend_disabled = true;
            this.security_timer = 30;
            this.resendCountdown();
        },
        //-----------------------------------------------------------------------
        resendCountdown () {
            if (this.security_timer > 0) {
                this.is_resend_disabled = true;
                setTimeout(() => {
                    this.security_timer--;
                    this.resendCountdown();
                }, 1000);
            } else {
                this.is_resend_disabled = false   ;
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
