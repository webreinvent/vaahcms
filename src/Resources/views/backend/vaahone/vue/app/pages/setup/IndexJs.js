import GlobalComponents from '../../vaahvue/helpers/GlobalComponents';

let namespace = 'setup';

import Logo from '../../components/Logo';
import Footer from '../../components/Footer';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        status() {return this.$store.getters[namespace+'/state'].status},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
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
            show_reset_modal: false,
            reset_inputs: {
                confirm: null,
                delete_media: false,
                delete_dependencies: false,
            },

        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        this.$root.$on('eReloadList', this.getList);
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
            this.getStatus();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        async getStatus() {
            await this.$store.dispatch(namespace+'/getStatus');
        },
        //---------------------------------------------------------------------
        confirmReset: function () {
            this.is_btn_loading = true;
            let params = this.reset_inputs;
            let url = this.ajax_url+'/reset/confirm';
            this.$vaah.ajax(url, params, this.confirmResetAfter);
        },
        //---------------------------------------------------------------------
        confirmResetAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                location.reload(true);
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
