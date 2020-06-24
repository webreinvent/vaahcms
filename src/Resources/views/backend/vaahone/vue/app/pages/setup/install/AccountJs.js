import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';


let namespace = 'setup';

import Logo from '../../../components/Logo';
import Footer from '../../../components/Footer';
import AutoComplete from "../../../vaahvue/reusable/AutoComplete";

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
        'AutoCompleteCallingCode': AutoComplete,
        Logo,
        Footer,

    },
    data()
    {
        return {
            btn_is_account_creating: false,
            labelPosition: 'on-border',
        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
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
        onLoad: function()
        {
            this.getAssets();
            this.config.active_step = 3;
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
        setCallingCode: function (item) {
            this.config.account.country_calling_code = item.slug;
            this.updateConfig();
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        createAccount: function () {
            this.btn_is_account_creating = true;
            let params = this.config.account;
            let url = this.ajax_url+'/store/admin';
            this.$vaah.ajax(url, params, this.createAccountAfter);
        },
        //---------------------------------------------------------------------
        createAccountAfter: function (data, res) {
            this.btn_is_account_creating = false;
            if(data)
            {
                this.config.is_account_created = true;
                this.updateConfig();
            }
        },

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

        generateUsername: function () {
            let email = this.config.account.email.split('@');
            if(email[0])
            {
                this.config.account.username = email[0];
                this.updateConfig();
            }
        },
        //---------------------------------------------------------------------
        validateAccountCreation: function () {
            if(!this.config.is_account_created)
            {
                this.$vaah.toastErrors(['Create the Administrator Account'])
            } else
            {
                this.resetConfig();
                this.$router.push({name: 'sign.in'})
            }
        },
        //---------------------------------------------------------------------
        resetConfig: function () {

            let config = {
                active_step: 0,
                is_migrated: false,
                dependencies: null,
                count_total_dependencies: 0,
                count_installed_dependencies: 0,
                count_installed_progress: 0,
                is_account_created: false,
                account:{

                    email: null,
                    username: null,
                    password: null,
                    first_name: null,
                    middle_name: null,
                    last_name: null,
                    country_calling_code: null,
                    phone: null,

                },
                env:{
                    app_name: "VaahCMS",
                    app_key: null,
                    app_debug: true,
                    app_env: null,
                    app_url: null,
                    app_timezone: null,
                    db_connection: 'mysql',
                    db_host: '127.0.0.1',
                    db_port: 3306,
                    db_database: null,
                    db_username: null,
                    db_password: null,
                    db_is_valid: false,
                    mail_provider: null,
                    mail_driver: null,
                    mail_host: null,
                    mail_port: null,
                    mail_username: null,
                    mail_password: null,
                    mail_encryption: null,
                    mail_from_address: null,
                    mail_from_name: null,
                    mail_is_valid: false,
                    test_email_to: null,
                }
            };

            this.update('config', config);

        }
        //---------------------------------------------------------------------
    }
}
