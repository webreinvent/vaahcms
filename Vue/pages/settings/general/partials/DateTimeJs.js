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
                date_format_custom: false,
                time_format_custom: false,
                datetime_format_custom: false,


            },
        };

        return obj;
    },
    watch: {

        'list.date_format': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'Y-m-d' || new_val == 'Y/m/d' || new_val == 'Y.m.d')
                {
                    this.inputs.date_format_custom = false;
                } else {
                    this.inputs.date_format_custom = true;
                }
            }
        },
        'inputs.date_format_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.date_format = '';
                    this.updateList();
                }
            }
        },

        'list.time_format': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'H:i:s' || new_val == 'h:i A' || new_val == 'h:i:s A')
                {
                    this.inputs.time_format_custom = false;
                } else {
                    this.inputs.time_format_custom = true;
                }
            }
        },
        'inputs.time_format_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.time_format = '';
                    this.updateList();
                }
            }
        },

        'list.datetime_format': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'Y-m-d H:i:s' || new_val == 'F j, Y h:i A' || new_val == 'd-M-Y H:i')
                {
                    this.inputs.datetime_format_custom = false;
                } else {
                    this.inputs.datetime_format_custom = true;
                }
            }
        },
        'inputs.datetime_format_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.datetime_format = '';
                    this.updateList();
                }
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
        storeSiteSettings: function () {
            this.$Progress.start();
            let params = {
                list: this.list
            };
            let url = this.ajax_url+'/store/site/settings';
            this.$vaah.ajax(url, params, this.storeSiteSettingsAfter);
        },
        //---------------------------------------------------------------------
        storeSiteSettingsAfter: function (data, res) {
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        copySetting: function (value)
        {
            let setting = "config('settings.global."+value+"');";
            copy(setting);
            this.$buefy.toast.open({
                message: 'Copied!',
                type: 'is-success'
            });
        },
        //---------------------------------------------------------------------
    }
}
