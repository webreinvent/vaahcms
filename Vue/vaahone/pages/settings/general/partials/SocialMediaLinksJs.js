import GlobalComponents from '../../../../vaahvue/helpers/GlobalComponents';
import TagInputs from '../../../../vaahvue/reusable/TagInputs.vue';
import copy from "copy-to-clipboard";

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
    },
    data()
    {
        let obj = {
            namespace:namespace,
            labelPosition: 'on-border',
            inputs: {

            },
            links: [],
        };

        return obj;
    },
    watch: {

        'settings.links': {
            deep: true,
            handler(new_val, old_val) {
                this.links = new_val;
            }
        },
        'links': {
            deep: true,
            handler(new_val, old_val) {
                this.links = new_val;
            }
        },

    },
    mounted() {
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
        onLoad: function () {
            console.log('--->settings.links', this.settings.links);
            if(this.settings.links)
            {
                this.links = this.settings.links;
                console.log('--->links', this.links);

            }
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        addLink: function () {
            let item = this.linkItem();

            this.links.push(item);

            console.log('--->links', this.links);

        },
        //---------------------------------------------------------------------
        linkItem: function () {

            let count = this.links.length;

            let item = {
                id: null,
                count: count,
                category: "global",
                label: "Link",
                excerpt: null,
                type: "link",
                key: "link_"+count,
                value: null,
                created_at: null,
                updated_at: null,
            };

            return item;

        },
        //---------------------------------------------------------------------
        removeLink: function (link) {

            console.log('--->link', link);

            if(link.id)
            {
                this.links = this.$vaah.removeInArrayByKey(this.links, link, 'id');
            } else
            {
                this.links = this.$vaah.removeInArrayByKey(this.links, link, 'count');
            }

            console.log('--->links', this.links);

        },
        //---------------------------------------------------------------------
        storeLinks: function () {
            this.$Progress.start();
            let params = {
                links: this.links
            };
            let url = this.ajax_url+'/store/links';
            this.$vaah.ajax(url, params, this.storeLinksAfter);
        },
        //---------------------------------------------------------------------
        storeLinksAfter: function (data, res) {
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        copySetting: function (value)
        {
            let setting = "{!! config('settings.global."+value+"'); !!}";
            copy(setting);
            this.$buefy.toast.open({
                message: 'Copied!',
                type: 'is-success'
            });
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
