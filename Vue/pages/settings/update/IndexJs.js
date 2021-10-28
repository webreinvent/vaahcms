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
            labelPosition: 'on-border',
            assets:null,
            update_available: false,
            is_button_active: false,
            release: null,
            remote_version: null,
            status: {
                download_latest_version: null,
                publish_assets: null,
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
            let params = {};
            let url = 'https://api.github.com/repos/webreinvent/vaahcms/releases/51763184';
            this.$vaah.ajaxGet(url, params, this.checkForUpdateAfter);
        },
        //---------------------------------------------------------------------
        checkForUpdateAfter: function (data, res) {
            this.$Progress.finish();

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

            let c = semver.gt(this.remote_version, local );

            this.update_available=true;

            if(c)
            {
                this.update_available=true;
            } else{
                this.update_available=false;
            }

            this.storeUpdateCheck();

        },
        //---------------------------------------------------------------------
        storeUpdateCheck: function () {
            this.$Progress.start();
            let params = {
                remote_version: this.remote_version,
                update_available: this.update_available,
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
            this.status.download_latest_version = 'pending';
            let url = this.ajax_url+'/upgrade';
            this.$vaah.ajax(url, {}, this.onUpdateAfter);
        },
        //---------------------------------------------------------------------
        onUpdateAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.download_latest_version = res.data.status;

                if(res.data.status === 'success'){
                    this.status.publish_assets = 'pending';
                    let url = this.ajax_url+'/publish';
                    this.$vaah.ajax(url, {}, this.onPublishAfter);
                }
            }


        },
        //---------------------------------------------------------------------
        onPublishAfter: function (data, res) {
            if(res && res.data && res.data.status){
                this.status.publish_assets = res.data.status;

                /*if(res.data.status === 'success'){
                    this.status.publish_assets = 'pending';
                    let url = this.ajax_url+'/upgrade';
                    this.$vaah.ajax(url, {}, this.onPublishAfter);
                }*/
            }


        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
