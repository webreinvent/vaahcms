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
        ajax_url: ajax_url,
        json_url: json_url,
        is_btn_loading_db_connection: false,
        is_btn_loading_config: false,
        status: null,
        gutter: 20,
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
            }
        },
        items: [
            {
                label: 'Publish assets'
            },
            {
                label: 'Clear Cache'
            }
        ],
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
    }),
    getters: {},
    actions: {
        async getAssets() {

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
        publishAssets() {

            this.showProgress();

            let params = {
            };

            vaah().ajax(
                this.json_url+'/publish/assets',
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
        afterTestDatabaseConnection(data, res)
        {
            this.is_btn_loading_db_connection = false;
            if(data)
            {
                this.config.env.db_is_valid=true;
            }
        },


        //---------------------------------------------------------------------
        routeAction(name)
        {
            this.$router.push({name: name})
        },
        async to(path)
        {
            this.$router.push({path: path})
        },
        showProgress()
        {
            this.show_progress_bar = true;
        },
        hideProgress()
        {
            this.show_progress_bar = false;
        }

    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSetupStore, import.meta.hot))
}
