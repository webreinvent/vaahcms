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
            tag_type: null,
            tags: [],
        };

        return obj;
    },
    watch: {

        'settings.meta_tags': {
            deep: true,
            handler(new_val, old_val) {
                this.tags = new_val;
            }
        },


    },
    mounted() {
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
        addTag: function () {
            let item = this.linkItem();

            this.tags.push(item);

            console.log('--->tags', this.tags);

        },
        //---------------------------------------------------------------------
        linkItem: function () {

            let count = this.tags.length;

            let item = {
                id: null,
                uid: count,
                category: "global",
                label: "Meta Tag",
                excerpt: null,
                type: "meta_tags",
                key: "meta_tags_"+count,
                value: {
                    attribute: 'name',
                    attribute_value: '',
                    content: '',
                },
                created_at: null,
                updated_at: null,
            };

            return item;

        },
        //---------------------------------------------------------------------
        removeTag: function (tag) {

            console.log('--->tag', tag);

            if(tag.id)
            {
                this.tags = this.$vaah.removeInArrayByKey(this.tags, tag, 'id');
            } else
            {
                this.tags = this.$vaah.removeInArrayByKey(this.tags, tag, 'uid');
            }

            console.log('--->tags', this.tags);

        },
        //---------------------------------------------------------------------
        generateTags: function () {
            if(this.tag_type == 'open-graph')
            {
                this.generateOpenGraph();
            }

            if(this.tag_type == 'google-webmaster')
            {
                this.generateWebmaster();
            }

        },
        //---------------------------------------------------------------------
        generateOpenGraph: function () {

            let list = [
                {
                    id: null,
                    uid: 'meta_tags_og_title',
                    category: "global",
                    label: "Open Graph Title",
                    type: "meta_tags",
                    key: "meta_tags_og_title",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:title',
                        content: '',
                    },

                },
                {
                    id: null,
                    uid: 'meta_tags_og_site_name',
                    category: "global",
                    label: "Open Graph Site Name",
                    type: "meta_tags",
                    key: "meta_tags_og_site_name",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:site_name',
                        content: '',
                    },

                },
                {
                    id: null,
                    uid: 'meta_tags_og_url',
                    category: "global",
                    label: "Open Graph Site Url",
                    type: "meta_tags",
                    key: "meta_tags_og_url",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:url',
                        content: '',
                    },

                },
                {
                    id: null,
                    uid: 'meta_tags_og_description',
                    category: "global",
                    label: "Open Graph Description",
                    type: "meta_tags",
                    key: "meta_tags_og_description",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:description',
                        content: '',
                    },

                },
                {
                    id: null,
                    uid: 'meta_tags_og_type',
                    category: "global",
                    label: "Open Graph Type",
                    type: "meta_tags",
                    key: "meta_tags_og_type",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:type',
                        content: '',
                    },

                },
                {
                    id: null,
                    uid: 'meta_tags_og_image',
                    category: "global",
                    label: "Open Graph Image",
                    type: "meta_tags",
                    key: "meta_tags_og_image",
                    value: {
                        attribute: 'property',
                        attribute_value: 'og:image',
                        content: '',
                    },

                }
            ];

            this.tags = this.tags.concat(list);

        },
        //---------------------------------------------------------------------
        generateWebmaster: function () {

            let list = [
                {
                    id: null,
                    uid: 'meta_tags_google_webmaster',
                    category: "global",
                    label: "Google Webmaster",
                    type: "meta_tags",
                    key: "meta_tags_google_webmaster",
                    value: {
                        attribute: 'name',
                        attribute_value: 'google-site-verification',
                        content: '',
                    },

                }
            ];

            this.tags = this.tags.concat(list);

        },
        //---------------------------------------------------------------------
        storeTags: function () {
            this.$Progress.start();
            let params = {
                tags: this.tags
            };
            let url = this.ajax_url+'/store/meta/tags';
            this.$vaah.ajax(url, params, this.storeTagsAfter);
        },
        //---------------------------------------------------------------------
        storeTagsAfter: function (data, res) {
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
    }
}
