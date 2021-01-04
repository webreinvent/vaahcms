import Logo from '../components/Logo.vue';
import Footer from '../components/Footer.vue';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
        ajax_url() {return this.$store.getters['root/state'].ajax_url},
    },
    components:{
        Logo,
        Footer,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_btn_otp_loading: false,
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

    },
    mounted() {

    },
    methods: {
        //---------------------------------------------------------------------
        signIn: function () {

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

                window.location.href = this.root.base_url+'/backend#/vaah';

                //this.$router.push({ name: 'dashboard.index' })
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
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
