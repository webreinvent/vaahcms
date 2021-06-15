import Logo from '../components/Logo';
import Footer from '../components/Footer';

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
            is_form_visible: false,
            credentials: {
                email: null,
                reset_password_code: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    watch: {
        '$route.params.code':function(newValue,oldValue){
            this.checkResetPasswordCode();
        }

    },
    mounted() {

        if(this.$route.params && this.$route.params.code){
            this.checkResetPasswordCode();
        }else{
            this.$router.push({ name: 'dashboard.index' })
        }

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
        onResetPassword: function () {
            this.root.no_of_reset_password_attempt++;
            this.update('no_of_reset_password_attempt',this.root.no_of_reset_password_attempt);
            this.is_btn_loading = true;
            let params = this.credentials;
            let url = this.ajax_url+'/resetPassword/post';
            this.$vaah.ajax(url, params, this.onResetPasswordAfter);

        },
        //---------------------------------------------------------------------
        onResetPasswordAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                this.$router.push({ name: 'dashboard.index' })
            }
        },
        //---------------------------------------------------------------------
        checkResetPasswordCode: function () {

            let params = {
                'code': this.$route.params.code,
            };
            let url = this.ajax_url+'/checkResetPasswordCode/post';
            this.$vaah.ajax(url, params, this.checkResetPasswordCodeAfter);

        },
        //---------------------------------------------------------------------
        checkResetPasswordCodeAfter: function (data, res) {
            if(data)
            {
                if(data.email){
                    this.credentials.email = data.email;
                    this.is_form_visible = true;
                }else if(data.redirect_url){
                    this.$router.push({ name: 'dashboard.index' });

                }
            }
        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
