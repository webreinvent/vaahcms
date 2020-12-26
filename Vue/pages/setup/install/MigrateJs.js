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
        'AutoCompleteTimeZone': AutoComplete,
        Logo,
        Footer,

    },
    data()
    {
        return {
            btn_is_migration: false,
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
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.getAssets();
            this.config.is_migrated = false;
            this.config.active_step = 1;
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
        confirmDelete: function()
        {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Deleting existing migrations',
                message: 'This will <b>delete</b> all existing migration from  <b>database/migrations</b> folder.',
                confirmText: 'Proceed',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.runMigrations();
                }
            })
        },
        //---------------------------------------------------------------------

        runMigrations: function () {
            this.btn_is_migration = true;
            this.config.is_migrated = false;
            this.updateConfig();

            let params = {};
            let url = this.ajax_url+'/run/migrations';
            this.$vaah.ajax(url, params, this.runMigrationsAfter);
        },
        //---------------------------------------------------------------------
        runMigrationsAfter: function (data, res) {
            this.btn_is_migration = false;
            if(data)
            {
                this.config.is_migrated = true;
                this.updateConfig();
            }
        },

        //---------------------------------------------------------------------
        validateMigration: function () {

            if(!this.config.is_migrated)
            {
                this.$vaah.toastErrors(['Click on Migrate & Run Seeds button']);
                return false;
            } else
            {
                this.$router.push({name: 'setup.install.dependencies'})
            }

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
