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
            active_dependency: null,

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
            this.config.active_step = 2;
            this.updateConfig();
            this.getDependencies();
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
        getDependencies: function () {
            let params = {};
            let url = this.ajax_url+'/get/dependencies';
            this.$vaah.ajax(url, params, this.getDependenciesAfter);
        },
        //---------------------------------------------------------------------
        getDependenciesAfter: function (data, res) {
            if(data)
            {
                this.config.dependencies = data.list;
                this.config.count_total_dependencies = data.list.length;
                this.updateConfig();
            }
        },
        //---------------------------------------------------------------------
        async installDependencies() {

            let index;
            let dependency;

            this.config.count_installed_dependencies = 0;
            this.config.count_installed_progress = 0;

            this.updateConfig();

            if(this.config.dependencies)
            {
                let dependencies = this.config.dependencies;
                for(index in dependencies)
                {
                    dependency = dependencies[index];
                    await this.installDependency(dependency);
                }
            }

        },
        //---------------------------------------------------------------------
        async installDependency(dependency) {
            this.active_dependency = dependency;
            let params = {
                name: this.active_dependency.name,
                slug: this.active_dependency.slug,
                type: this.active_dependency.type,
                source: this.active_dependency.source,
                download_link: this.active_dependency.download_link,
            };
            let url = this.ajax_url+'/install/dependencies';
            await this.$vaah.ajax(url, params, this.installDependencyAfter);
        },
        //---------------------------------------------------------------------
        installDependencyAfter: function (data, res) {
            if(data)
            {
                console.log('--->this.active_dependency', this.active_dependency);
                if(this.active_dependency)
                {
                    this.active_dependency.installed = true;
                    this.$vaah.updateArray(this.config.dependencies, this.active_dependency);

                    this.config.count_installed_dependencies = this.config.count_installed_dependencies+1;
                    let progress = this.config.count_total_dependencies/this.config.count_installed_dependencies;

                    progress =  Math.round(progress*100);
                    this.config.count_installed_progress = progress;

                    this.updateConfig();
                    this.active_dependency = null;
                }

            }
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        fnAfter: function (data, res) {
            this.is_content_loading = false;
            this.list = data.list;
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
