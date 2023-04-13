import GlobalComponents from '../vaahvue/helpers/GlobalComponents'
import Loader from '../vaahvue/reusable/Loader'

import Logo from '../components/Logo.vue';
import Footer from '../components/Footer.vue';


import { ContentLoader } from "vue-content-loader";

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
        ajax_url() {return this.$store.getters['root/state'].ajax_url},
    },
    components:{
        ContentLoader,
        Loader,
        Logo,
        Footer,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_btn_otp_loading: false,
            is_verification_btn_otp_loading: false,
            is_verification_form_visible: false,
            is_resend_otp_btn_loading: false,
            security_timer: 0,
            verification: {
                otp_0: null,
                otp_1: null,
                otp_2: null,
                otp_3: null,
                otp_4: null,
                otp_5: null,
            },
            signin: {
                type: 'password',
                email: null,
                password: null,
                attempts: 0,
                login_otp:null,
                max_attempts: 5,
                is_password_disabled: null,
            }
        }
    },
    watch: {
        security_timer: {
            handler(value) {

                if (value > 0) {
                    setTimeout(() => {
                        this.security_timer--;
                    }, 1000);
                }

            },
            immediate: true // This ensures the watcher is triggered upon creation
        }
    },
    mounted() {

    },
    methods: {

        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: 'root',
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        signIn: function () {
            this.root.no_of_login_attempt++;
            this.update('no_of_login_attempt',this.root.no_of_login_attempt);
            this.is_btn_loading = true;
            let params = this.signin;
            let url = this.ajax_url+'/signin/post';
            this.$vaah.ajax(url, params, this.signInAfter);

        },
        //---------------------------------------------------------------------
        signInAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {


                if(data.verification_response && data.verification_response.status
                    && data.verification_response.status === 'success'){
                    this.security_timer = 30;
                    this.is_verification_form_visible = true;
                }else{
                    window.location = this.root.base_url+'/backend#/vaah';
                }


            }
        },
        //---------------------------------------------------------------------
        verifySecurityOtp: function () {
            this.is_verification_btn_otp_loading = true;
            let params = {
                'verify_otp': this.verification
            };
            let url = this.ajax_url+'/verify/security/otp';
            this.$vaah.ajax(url, params, this.verifySecurityOtpAfter);

        },
        //---------------------------------------------------------------------
        verifySecurityOtpAfter: function (data, res) {
            this.is_verification_btn_otp_loading = false;
            if(data && data.redirect_url)
            {

                window.location = data.redirect_url;

            }
        },
        //---------------------------------------------------------------------
        generateOTP: function () {

            this.is_btn_otp_loading = true;
            let params = this.signin;
            let url = this.ajax_url+'/signin/generate/otp';
            this.$vaah.ajax(url, params, this.generateOTPAfter);

        },
        //---------------------------------------------------------------------
        generateOTPAfter: function (data, res) {
            this.is_btn_otp_loading = false;
            if(data)
            {

            }
        },
        //---------------------------------------------------------------------
        resendSecurityOtp: function (e) {
            e.preventDefault();
            this.is_resend_otp_btn_loading = true;
            var url = this.ajax_url+'/resend/security/otp';
            var params = {};
            this.$vaah.ajax(url, params, this.resendSecurityOtpAfter);
        },
        //---------------------------------------------------------------------
        resendSecurityOtpAfter: function (data) {

            this.security_timer = 30;

            if(data)
            {
                this.is_resend_otp_btn_loading = false;
            }

        },

        //---------------------------------------------------------------------
        moveToElement: function (event, next_el_id, previous_el_id) {

            console.log('--->event.key', event.key);

            if(event.key === 'v'
                || event.key === 'V'
                || event.key === 'Control'
            )
            {
                return false
            }

            let otp_val = event.target.value;

            if (event.key === "Backspace" || event.key === "Delete") {
                if(previous_el_id)
                {
                    document.getElementById(previous_el_id).focus();
                }
            } else
            {
                if(next_el_id)
                {
                    document.getElementById(next_el_id).focus();
                }
            }
        },
        //---------------------------------------------
        onOtpPaste: function(event)
        {
            console.log('--->paste value', event.target.value);
            let paste_otp =  this.getClipboardValue(event);

            if(paste_otp)
            {
                paste_otp = paste_otp.trim();
                paste_otp = paste_otp.replace(" ", '');
                paste_otp = paste_otp.trim();
                let otp_arr = paste_otp.split("");

                let otp_val;
                let otp_index;

                if(otp_arr.length > 0)
                {
                    for(let index in otp_arr)
                    {
                        otp_index = 'otp_'+index;
                        otp_val = otp_arr[index];
                        this.verification[otp_index] = otp_val;
                    }
                }
            }


        },
        //---------------------------------------------------------------------
        getClipboardValue: function (e) {

            let text =  (!!e.clipboardData)? e.clipboardData.getData("text/plain") : window.clipboardData.getData("Text");

            return text;
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
