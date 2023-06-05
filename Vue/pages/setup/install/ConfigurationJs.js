import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'setup';

import Logo from '../../../components/Logo.vue';
import Footer from '../../../components/Footer.vue';
import AutoComplete from "../../../vaahvue/reusable/AutoComplete.vue";

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        status() {return this.$store.getters[namespace+'/state'].status},
        config() {return this.$store.getters[namespace+'/state'].config},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        'AutoCompleteTimeZone': AutoComplete,
        Logo,
        Footer,

    },
    data()
    {
        return {
            is_btn_loading_db_connection: false,
            is_btn_loading_mail_config: false,
            is_btn_loading_config: false,
            is_modal_test_mail_active: false,
            labelPosition: 'on-border',
        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        if(this.root && this.root.assets && this.root.assets.timezone){
            this.config.env.app_timezone = this.root.assets.timezone;
        }

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
            this.getRequiredConfigurations();
            this.getAssets();
            this.config.active_step = 0;
            this.updateConfig();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
            this.config.env.app_url = this.assets.app_url;
            this.updateConfig();
        },
        //---------------------------------------------------------------------
        updateConfig: function()
        {
            this.update('config', this.config);
        },
        //---------------------------------------------------------------------
        getRequiredConfigurations: function () {

            let params = {};
            let url = this.ajax_url+'/get/required/configurations';
            this.$vaah.ajax(url, params, this.getRequiredConfigurationsAfter);
        },
        //---------------------------------------------------------------------
        getRequiredConfigurationsAfter: function (data, res) {

            if(data)
            {
                this.config.env.app_key = data.app_key;
                this.config.env.app_vaahcms_env = data.app_vaahcms_env;
                this.updateConfig();
            }
        },
        //---------------------------------------------------------------------
        setTimeZone: function (item) {
            this.config.env.app_timezone = item.slug;
            this.updateConfig();
        },
        //---------------------------------------------------------------------
        loadConfigurations: function () {


            if(this.config.env.app_env != 'custom')
            {
                this.config.env.app_env_custom = "";
                let params = this.config.env;
                let url = this.ajax_url+'/get/configurations';
                this.$vaah.ajax(url, params, this.loadConfigurationsAfter);
            }


        },
        //---------------------------------------------------------------------
        loadConfigurationsAfter: function (data, res) {
            if(data)
            {
                let config = this.$vaah.getNonReactiveObject(this.config);

                for(let key in config.env)
                {
                    if( data[key])
                    {
                        config.env[key] = data[key];
                    }
                }

                this.update('config', config);
            }
        },
        //---------------------------------------------------------------------
        testDatabaseConnection: function () {
            this.is_btn_loading_db_connection = true;
            this.config.env.db_is_valid=false;
            this.updateConfig();

            let params = this.config.env;
            let url = this.ajax_url+'/test/database/connection';
            this.$vaah.ajax(url, params, this.testDatabaseConnectionAfter);
        },
        //---------------------------------------------------------------------
        testDatabaseConnectionAfter: function (data, res) {
            this.is_btn_loading_db_connection = false;
            if(data)
            {
                this.config.env.db_is_valid=true;
                this.update('config', this.config);
            }
        },
        //---------------------------------------------------------------------
        setMailConfigurations: function () {
            if(this.config.env.mail_provider!='other')
            {
                let mail_config = this.$vaah.findInArrayByKey(this.assets.mail_sample_settings, 'slug', this.config.env.mail_provider);

                if(mail_config)
                {
                    for(let key in mail_config.settings)
                    {
                        this.config.env[key] = mail_config.settings[key];
                    }
                    this.update('config', this.config);
                }
            } else
            {
                this.config.env.mail_driver = null;
                this.config.env.mail_host = null;
                this.config.env.mail_port = null;
                this.config.env.mail_encryption = null;
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        testMailConfiguration: function () {
            this.is_btn_loading_mail_config = true;
            this.config.env.mail_is_valid=false;
            this.updateConfig();
            let params = this.config.env;
            let url = this.ajax_url+'/test/mail/configuration';
            this.$vaah.ajax(url, params, this.testMailConfigurationAfter);
        },
        //---------------------------------------------------------------------
        testMailConfigurationAfter: function (data, res) {
            this.is_btn_loading_mail_config = false;
            if(data)
            {
                this.config.env.mail_is_valid=true;
                this.update('config', this.config);
            }
        },
        //---------------------------------------------------------------------
        validateConfigurations: function () {
            this.is_btn_loading_config = true;
            let params = this.config.env;
            let url = this.ajax_url+'/test/configurations';
            this.$vaah.ajax(url, params, this.validateConfigurationsAfter);
        },
        //---------------------------------------------------------------------
        validateConfigurationsAfter: function (data, res) {

            if(!data)
            {
                this.is_btn_loading_config = false
            } else
            {
                this.config.active_step = 1;
                location.assign(this.root.base_url+"/backend#/install/migrate");
                window.location.reload();
            }

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
    }
}
