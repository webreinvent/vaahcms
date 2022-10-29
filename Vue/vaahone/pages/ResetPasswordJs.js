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
            this.credentials.reset_password_code = newValue;
        }
    },
    mounted() {

        if(this.$route.params && this.$route.params.code){
            this.credentials.reset_password_code = this.$route.params.code;
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
        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
