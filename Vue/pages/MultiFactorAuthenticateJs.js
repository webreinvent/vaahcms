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
            verify_item: {
                code: ''
            }
        }
    },
    watch: {

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
        verify: function () {
            this.root.no_of_login_attempt++;
            this.update('no_of_login_attempt',this.root.no_of_login_attempt);
            this.is_btn_loading = true;
            let params = this.verify_item;
            let url = this.ajax_url+'/verify/post';
            this.$vaah.ajax(url, params, this.verifyAfter);

        },
        //---------------------------------------------------------------------
        verifyAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {

                if(data.redirect_url){
                    window.location = data.redirect_url;
                }

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
