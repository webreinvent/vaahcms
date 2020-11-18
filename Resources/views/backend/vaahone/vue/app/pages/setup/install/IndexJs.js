import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'setup';

import Logo from '../../../components/Logo';
import Footer from '../../../components/Footer';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        status() {return this.$store.getters[namespace+'/state'].status},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        config() {return this.$store.getters[namespace+'/state'].config},
    },
    components:{
        ...GlobalComponents,
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
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
