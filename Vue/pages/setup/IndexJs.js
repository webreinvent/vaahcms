import GlobalComponents from '../../vaahvue/helpers/GlobalComponents';

let namespace = 'setup';

import Logo from '../../components/Logo.vue';
import Footer from '../../components/Footer.vue';

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
        clearCache: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/clear/cache';
            this.$vaah.ajax(url, params, this.clearCacheAfter);
        },
        //---------------------------------------------------------------------
        clearCacheAfter: function (data, res) {
            this.$Progress.finish();
            if(res && res.data && res.data.status && res.data.status === 'success' ){
                window.location.reload(true);
            }
        },
        //---------------------------------------------------------------------
        publishAssets: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/publish/assets';
            this.$vaah.ajax(url, params, this.publishAssetsAfter);
        },
        //---------------------------------------------------------------------
        publishAssetsAfter: function (data, res) {
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
    }
}
