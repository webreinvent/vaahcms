import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url+'/setup';
let json_url = ajax_url + "/json";

export const useSetupStore = defineStore({
    id: 'setup',
    state: () => ({
        assets: null,
        assets_is_fetching: true,
        base_url: base_url,
        ajax_url: ajax_url,
        json_url: json_url,
        filtered_country_codes: [],
        advanced_option_menu_list: [],
        is_btn_loading_mail_config: false,
        is_btn_loading_db_connection: false,
        is_modal_test_mail_active: false,
        is_btn_loading_config: false,
        is_btn_loading_dependency: false,
        btn_is_migration: false,
        status: null,
        route: null,
        gutter: 20,
        active_dependency: null,
        debug_option: [
            {
                name:'True',
                slug:'true'
            },
            {
                name:'False',
                slug:'false'
            }
        ],
        config:{
            active_step: 0,
            is_migrated: false,
            dependencies: null,
            count_total_dependencies: 0,
            count_installed_dependencies: 0,
            count_installed_progress: 0,
            is_account_created: false,
            btn_is_account_creating: false,
            account:{

                email: null,
                username: null,
                password: null,
                first_name: null,
                middle_name: null,
                last_name: null,
                country_calling_code: null,
                country_calling_code_object: null,
                phone: null,

            },
            env:{
                app_name: "VaahCMS",
                app_key: null,
                app_debug: 'true',
                app_env: null,
                app_env_custom: null,
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
            },
            data_testid_app_env:{
               'data-testid':"configuration-env"
            },
            data_testid_debug:{
                'data-testid':"configuration-debug"
            },
            data_testid_timezone:{
                'data-testid':"configuration-timezone"
            },
            data_testid_db_type:{
                'data-testid':"configuration-db_type"
            },
            data_testid_db_password:{
                'data-testid':"configuration-db_password",
                'autocomplete':'new-password'
            },
            data_testid_mail_provider:{
                'data-testid':"configuration-mail_provider"
            },
            data_testid_mail_password:{
                'data-testid':"configuration-mail_password"
            },
            data_testid_mail_encryption:{
                'data-testid':"configuration-mail_encryption"
            },
        },
        install_items: [
            {
                label: 'Configuration',
                icon: 'pi pi-fw pi-cog',
                to: '/setup/install/configuration'
            },
            {
                label: 'Migrate',
                icon: 'pi pi-fw pi-database',
                to: '/setup/install/migrate'
            },
            {
                label: 'Dependencies',
                icon: 'pi pi-fw pi-server',
                to: '/setup/install/dependencies'
            },
            {
                label: 'Account',
                icon: 'pi pi-fw pi-user-plus',
                to: '/setup/install/account'
            }
        ],
        show_progress_bar: false,
        show_reset_modal: false,
        reset_inputs: {
            confirm: null,
            delete_dependencies: null,
            delete_media: null,
        },
        reset_confirm: null,
        autocomplete_on_focus: true
    }),
    getters: {},
    actions: {
        async getAssets(route = null) {

            if(route){
                this.route = route;
                this.assets_is_fetching = true;
            }

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                let params = {
                };

                vaah().ajax(
                    this.json_url+'/assets',
                    this.afterGetAssets,
                    params
                );
            }
        },


        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;

                if(this.route && this.route.name === 'setup.install.migrate'
                    && !this.assets.env_file ){

                    this.assets_is_fetching = true;
                    this.getAssets();
                }

                this.config.env.app_url = this.assets.app_url;

            }
        },
        async getStatus() {

            let params = {
            };

            vaah().ajax(
                this.json_url+'/status',
                this.afterGetStatus,
                params
            );

        },


        //---------------------------------------------------------------------
        afterGetStatus(data, res)
        {
            if(data)
            {
                this.status = data;

            }
        },
        async getRequiredConfigurations() {

            let params = {
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/required/configurations',
                this.getRequiredConfigurationsAfter,
                params
            );

        },


        //---------------------------------------------------------------------
        getRequiredConfigurationsAfter(data, res)
        {
            if(data)
            {
                this.config.env.app_key = data.app_key;
                this.config.env.vaahcms_vue_app = data.vaahcms_vue_app;

            }
        },
        publishAssets() {

            this.showProgress();

            let params = {
            };

            vaah().ajax(
                this.ajax_url+'/publish/assets',
                this.afterPublishAssets,
                params
            );

        },


        //---------------------------------------------------------------------
        afterPublishAssets(data, res)
        {
            this.hideProgress();
        },
        //---------------------------------------------------------------------
        clearCache: function () {

            this.showProgress();

            let params = {
            };

            vaah().ajax(
                this.ajax_url+'/clear/cache',
                this.afterClearCache,
                params
            );
        },
        //---------------------------------------------------------------------
        afterClearCache: function (data, res) {
            this.hideProgress();
        },
        //---------------------------------------------------------------------
        confirmReset: function () {
            this.reset_confirm = true;
            this.showProgress();

            let params = {
                params: this.reset_inputs,
                method: 'post'
            };

            vaah().ajax(
                this.ajax_url+'/reset/confirm',
                this.afterConfirmReset,
                params
            );
        },
        //---------------------------------------------------------------------
        async afterConfirmReset (data, res) {
            this.reset_confirm = false;
            if(data)
            {
                location.reload(true);
            }
        },
        //---------------------------------------------------------------------
        loadConfigurations: function () {


            if(this.config.env.app_env !== 'custom')
            {
                this.config.env.app_env_custom = "";

                let params = {
                    params : this.config.env,
                    method: 'post',
                };

                vaah().ajax(
                    this.ajax_url+'/get/configurations',
                    this.afterLoadConfigurations,
                    params
                );
            }


        },
        //---------------------------------------------------------------------
        afterLoadConfigurations: function (data, res) {
            if(data)
            {
                this.config.env.db_password = null;
                for(let key in this.config.env)
                {
                    if( data[key])
                    {
                        this.config.env[key] = data[key];

                    }
                }

            }
        },
        //---------------------------------------------------------------------
        testDatabaseConnection() {

            this.is_btn_loading_db_connection = true;
            this.config.env.db_is_valid=false;

            this.showProgress();

            let params = {
                params: this.config.env,
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/test/database/connection',
                this.afterTestDatabaseConnection,
                params
            );

        },

        //---------------------------------------------------------------------
        afterTestDatabaseConnection(data, res)
        {
            this.is_btn_loading_db_connection = false;
            if(data && !res.data.errors)
            {
                this.config.env.db_is_valid=true;
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        testMailConfiguration: function () {
            this.is_btn_loading_mail_config = true;
            this.config.env.mail_is_valid=false;
            this.showProgress();

            let params = {
                params: this.config.env,
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/test/mail/configuration',
                this.afterTestMailConfiguration,
                params
            );

        },
        //---------------------------------------------------------------------
        afterTestMailConfiguration: function (data, res) {
            this.is_btn_loading_mail_config = false;

            if(data && !res.data.errors)
            {
                this.config.env.mail_is_valid=true;
            }
        },
        //---------------------------------------------------------------------
        setMailConfigurations: function () {

            console.log(222,this.config.env.mail_provider);

            if(this.config.env.mail_provider!='other')
            {
                let mail_config = vaah().findInArrayByKey(
                    this.assets.mail_sample_settings, 'slug', this.config.env.mail_provider);

                if(mail_config)
                {
                    for(let key in mail_config.settings)
                    {
                        this.config.env[key] = mail_config.settings[key];
                    }
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
        validateConfigurations: function () {
            this.is_btn_loading_config = true;
            let params = {
                params: this.config.env,
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/test/configurations',
                this.afterValidateConfigurations,
                params
            );
        },
        //---------------------------------------------------------------------
        afterValidateConfigurations: function (data, res) {

            if(!data)
            {
                this.is_btn_loading_config = false
            } else
            {
                this.config.active_step = 1;
                this.$router.push({name: 'setup.install.migrate'})
            }

        },

        //---------------------------------------------------------------------
        runMigrations: function () {
            this.btn_is_migration = true;
            this.config.is_migrated = false;
            let params = {
                method: 'post',
            };

            vaah().ajax(
                this.ajax_url+'/run/migrations',
                this.afterRunMigrations,
                params
            );
        },
        //---------------------------------------------------------------------
        afterRunMigrations: function (data, res) {

            this.btn_is_migration = false;
            if(data)
            {
                this.config.is_migrated = true;
            }

        },

        //---------------------------------------------------------------------
        validateMigration: function () {
            if(!this.config.is_migrated)
            {
                vaah().toastErrors(['Click on Migrate & Run Seeds button']);
                return false;
            } else
            {
                this.$router.push({name: 'setup.install.dependencies'})
            }
        },
        //---------------------------------------------------------------------
        getDependencies: function () {

            let params = {};

            vaah().ajax(
                this.ajax_url+'/get/dependencies',
                this.afterGetDependencies,
                params
            );
        },
        //---------------------------------------------------------------------
        afterGetDependencies: function (data, res) {
            if(data)
            {
                this.config.dependencies = data.list;
                this.config.count_total_dependencies = data.list.length;
            }
        },
        //---------------------------------------------------------------------
        generateUsername()
        {
            let email = this.config.account.email.split('@');
            if(email[0])
            {
                this.config.account.username = email[0];
            }
        },
        //---------------------------------------------------------------------
        createAccount: function () {
            this.config.btn_is_account_creating = true;
            this.config.env.db_is_valid=false;
            let params = {
                params: this.config.account,
                method: 'post',
            };
            vaah().ajax(
                this.ajax_url+'/store/admin',
                this.createAccountAfter,
                params
            );
        },

        //---------------------------------------------------------------------
        createAccountAfter: function (data, res) {
            this.config.btn_is_account_creating = false;
            if(data)
            {
                this.config.is_account_created = true;
                this.config.env.db_is_valid=true;
            }
        },
        //---------------------------------------------------------------------
        validateAccountCreation: function (){
            if(!this.config.is_account_created)
            {
                vaah().toastErrors(['Create the Super Administrator Account']);
            } else
            {
                this.resetConfig();
                this.$router.push({name: 'sign.in'})
            }
        },
        //---------------------------------------------------------------------
        getAdvancedOptionMenu: function (){
            this.advanced_option_menu_list =  [
                {
                    label: 'Publish assets',
                    command: () => {
                        this.publishAssets()
                    }
                },
                {
                    label: 'Clear Cache',
                    command: () => {
                        this.clearCache()
                    }
                },
            ];
        },
        //---------------------------------------------------------------------
        resetConfig() {
            this.config = {
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
                    country_calling_code_object: null,
                    phone: null,

                },
                env:{
                    app_name: "VaahCMS",
                    app_key: null,
                    app_debug: 'true',
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
        },
        //---------------------------------------------------------------------
        searchCountryCode: function (event) {
            this.autocomplete_on_focus = true;
            this.country_calling_code_object = null;
            this.country_calling_code = null;

           setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filtered_country_codes = this.assets.country_calling_codes;
                }
                else {
                    this.filtered_country_codes = this.assets.country_calling_codes.filter((country) => {
                        return country.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        onSelectCountryCode: function (event){

            this.config.account.country_calling_code = event.value.slug;

        },
        //---------------------------------------------------------------------
        validateDependencies: function (event){

            if(this.config.count_installed_progress != 100)
            {
                vaah().toastErrors(['Dependencies are not installed.']);
                return false;
            } else
            {
                this.$router.push({name: 'setup.install.account'})
            }

        },
        //---------------------------------------------------------------------
        skipDependencies: function () {
            this.config.count_installed_progress = 100;
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        async installDependencies() {

            let index;
            let dependency;


            this.config.count_installed_dependencies = 0;
            this.config.count_installed_progress = 0;

            if(this.config.dependencies)
            {
                this.is_btn_loading_dependency = true;
                let dependencies = this.config.dependencies;
                for(index in dependencies)
                {
                    dependency = dependencies[index];
                    await this.installDependency(dependency);
                }

                this.is_btn_loading_dependency = false;
            }



        },
        //---------------------------------------------------------------------
        async installDependency(dependency) {
            this.active_dependency = dependency;

            let params = {
                params: {
                    name: this.active_dependency.name,
                    slug: this.active_dependency.slug,
                    type: this.active_dependency.type,
                    source: this.active_dependency.source,
                    download_link: this.active_dependency.download_link,
                    import_sample_data: this.active_dependency.import_sample_data,
                },
                method: 'post',
            };
            await vaah().ajax(
                this.ajax_url+'/install/dependencies',
                this.afterInstallDependency,
                params
            );
        },
        //---------------------------------------------------------------------
        afterInstallDependency: function (data, res) {
            if(data)
            {
                console.log('--->this.active_dependency', this.active_dependency);
                if(this.active_dependency)
                {
                    this.active_dependency.installed = true;
                    vaah().updateArray(this.config.dependencies, this.active_dependency);

                    this.config.count_installed_dependencies = this.config.count_installed_dependencies+1;
                    let progress = this.config.count_installed_dependencies/this.config.count_total_dependencies;

                    progress =  Math.round(progress*100);
                    this.config.count_installed_progress = progress;

                    this.active_dependency = null;
                }

            }
        },
        //---------------------------------------------------------------------
        routeAction(name)
        {
            this.$router.push({name: name})
        },
        //---------------------------------------------------------------------
        async to(path)
        {
            this.$router.push({path: path})
        },
        //---------------------------------------------------------------------
        showProgress()
        {
            this.show_progress_bar = true;
        },
        //---------------------------------------------------------------------
        hideProgress()
        {
            this.show_progress_bar = false;
        },
        //--------display country code on focus event-------------------------------------------------------------
        showCallingCodes(event)
        {
            this.autocomplete_on_focus = true;
        },
        //---------------------------------------------------------------------
        setFocusDropDownToTrue()
        {
            this.autocomplete_on_focus = true;
        }
    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSetupStore, import.meta.hot))
}
