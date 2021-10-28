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
            remote_version: null,
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
            let url = 'https://api.github.com/repos/webreinvent/vaahcms/releases/latest';
            this.$vaah.ajaxGet(url, params, this.checkForUpdateAfter);
        },
        //---------------------------------------------------------------------
        checkForUpdateAfter: function (data, res) {
            this.$Progress.finish();

            console.log('--->', res);
            console.log('--->', res.data.tag_name);

            if(!res || !res.data || !res.data.tag_name)
            {
                this.$vaah.toastErrors(['Something went wrong.'])
                return false;
            }

            let local = semver.clean(this.root.assets.vaahcms.version)
            this.remote_version = semver.clean(res.data.tag_name)

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
        //---------------------------------------------------------------------
    }
}
