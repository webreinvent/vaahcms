import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import copy from "copy-to-clipboard";

import semver from "semver";

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url+"/backend/vaah/settings/update";

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
    },
    components:{
        ...GlobalComponents,
    },
    data()
    {
        let obj = {
            ajax_url: ajax_url,
            update_message:'Current version of VaahCMS is',
            labelPosition: 'on-border',
            assets:null,
            is_check_update_loading: false,
            update_available: false,
            manual_update: false,
            backend_update: false,
            is_button_active: false,
            backup_database: false,
            is_update_step_visible: false,
            is_checkbox_active: true,
            release: null,
            remote_version: null,
            status: {
                download_latest_version: null,
                publish_assets: null,
                migration_and_seeds: null,
                clear_cache: null,
                page_refresh: null,
            },

        };

        return obj;
    },
    watch: {


    },
    mounted() {

        document.title = "Update";
        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        getAssets: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/assets';
            this.$vaah.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.assets = data;
                this.getList();
            }

        },
        //---------------------------------------------------------------------
        checkForUpdate: function () {
            this.$Progress.start();
            this.is_check_update_loading = true;
            let params = {};
            let url = 'https://api.github.com/repos/webreinvent/vaahcms/releases/latest'; //51763184
            this.$vaah.ajaxGet(url, params, this.checkForUpdateAfter);
        },
        //---------------------------------------------------------------------
        checkForUpdateAfter: function (data, res) {
            this.$Progress.finish();

            this.is_check_update_loading = false;
            this.update_available=false;
            this.manual_update=false;
            this.backend_update=false;

            console.log('--->', res);
            console.log('--->', res.data.tag_name);

            if(!res || !res.data || !res.data.tag_name)
            {
                this.$vaah.toastErrors(['Something went wrong.']);
                return false;
            }

            this.release = res.data;

            let local = semver.clean(this.root.assets.vaahcms.version);
            this.remote_version = semver.clean(res.data.tag_name);

            console.log('local--->', local);
            console.log('remote--->', this.remote_version);

            let diff = semver.diff(this.remote_version, local );

            this.update_message= 'Current version of VaahCMS is';

            if(diff){
                this.update_available=true;
                if(diff === 'major'){
                    this.manual_update=true;
                }else{
                    this.backend_update=true;

                }
            }else{
                this.update_message= 'You are running a latest version of VaahCms';
            }

            this.storeUpdateCheck();

        },
        //---------------------------------------------------------------------
        storeUpdateCheck: function () {
            this.$Progress.start();
            let params = {
                remote_version: this.remote_version,
                update_available: this.update_available,
                manual_update: this.manual_update,
            };
            let url = this.ajax_url+'/store';
            this.$vaah.ajax(url, params, this.storeUpdateCheckAfter);
        },
        //---------------------------------------------------------------------
        storeUpdateCheckAfter: function (data, res) {
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        onUpdate: function (data, res) {
            this.$Progress.start();
            this.is_checkbox_active = false;
            this.is_button_active = false;
            this.is_update_step_visible = true;
            this.status.download_latest_version = 'pending';

            let url = this.ajax_url+'/upgrade';
            this.$vaah.ajax(url, {}, this.onUpdateAfter);
        },
        //---------------------------------------------------------------------
        onUpdateAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.download_latest_version = res.data.status;

                if(res.data.status === 'success'){

                    if(!data){
                        this.$Progress.finish();
                        this.status.download_latest_version = 'failed';
                        this.$vaah.toastErrors(['Go to Root path','Run <b>Composer Update</b>']);
                        return false;
                    }

                    this.status.publish_assets = 'pending';
                    let url = this.ajax_url+'/publish';
                    this.$vaah.ajax(url, {}, this.onPublishAfter);
                }else{
                    this.$Progress.finish();
                    this.status.download_latest_version = 'failed';
                }
            }


        },
        //---------------------------------------------------------------------
        onPublishAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.publish_assets = res.data.status;

                if(res.data.status === 'success'){
                    this.status.migration_and_seeds = 'pending';
                    let url = this.ajax_url+'/run/migrations';
                    this.$vaah.ajax(url, {}, this.onMigrationAndSeedsAfter);
                }else{
                    this.$Progress.finish();
                    this.status.publish_assets = 'failed';
                }
            }
        },
        //---------------------------------------------------------------------
        onMigrationAndSeedsAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.migration_and_seeds = res.data.status;

                if(res.data.status === 'success'){
                    this.status.clear_cache = 'pending';
                    let url = this.ajax_url+'/cache';
                    this.$vaah.ajax(url, {}, this.onClearCacheAfter);
                }else{
                    this.$Progress.finish();
                    this.status.migration_and_seeds = 'failed';
                }
            }
        },
        //---------------------------------------------------------------------
        onClearCacheAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.clear_cache = res.data.status;

                if(res.data.status === 'success'){
                    this.status.page_refresh = 'pending';
                    location.reload();
                }else{
                    this.$Progress.finish();
                    this.status.clear_cache = 'failed';
                }
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
