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
                password: null
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
            let params = this.credentials;
            let url = this.ajax_url+'/signin/post';
            this.$vaah.ajax(url, params, this.signInAfter);

        },
        //---------------------------------------------------------------------
        signInAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                console.log('--->', data);
                this.$router.push({ name: 'dashboard.index' })
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
