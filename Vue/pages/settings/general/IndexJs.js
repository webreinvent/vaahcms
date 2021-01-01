import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import TagInputs from '../../../vaahvue/reusable/TagInputs.vue';

import SiteSettings from './partials/SiteSettings.vue';
import DateTime from './partials/DateTime.vue';
import SocialMediaLinks from './partials/SocialMediaLinks.vue';
import Scripts from './partials/Scripts.vue';
import MetaTags from './partials/MetaTags.vue';

let namespace = 'general';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        list() {return this.$store.getters[namespace+'/state'].list},
        settings() {return this.$store.getters[namespace+'/state'].settings},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        'TagRolesOnRegistration': TagInputs,
        'TagFileTypes': TagInputs,
        SiteSettings,
        DateTime,
        SocialMediaLinks,
        Scripts,
        MetaTags,
    },
    data()
    {
        let obj = {
            namespace:namespace,
            labelPosition: 'on-border',
        };

        return obj;
    },
    watch: {


    },
    mounted() {
        document.title = "Generals";
        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------
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
        updateList: function()
        {
            let update = {
                state_name: 'list',
                state_value: this.list,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateSettings: function()
        {
            let update = {
                state_name: 'settings',
                state_value: this.settings,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, params, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.update('list', data.list);
                this.update('settings', data);
            }
        },
        //---------------------------------------------------------------------
        expandAll: function () {

            $('.collapse-content').each(function (index, item) {
                $(item).slideDown();
            });

        },
        //---------------------------------------------------------------------
        collapseAll: function () {
            $('.collapse-content').each(function (index, item) {
                $(item).slideUp();
            });
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
