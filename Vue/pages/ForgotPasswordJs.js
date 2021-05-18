import Logo from '../components/Logo';
import Footer from '../components/Footer';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
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
            credentials: {
                email: null,
            }
        }
    },
    watch: {

    },
    mounted() {

    },
    methods: {
        //---------------------------------------------------------------------
        onSendCode: function () {

            this.is_btn_loading = true;
            let params = this.credentials;
            let url = this.ajax_url+'/sendResetCode/post';
            this.$vaah.ajax(url, params, this.onSendCodeAfter);

        },
        //---------------------------------------------------------------------
        onSendCodeAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                this.$router.push({ name: 'dashboard.index' })
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
