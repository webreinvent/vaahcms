import GlobalComponents from '../../../../vaahvue/helpers/GlobalComponents';
import TagInputs from '../../../../vaahvue/reusable/TagInputs.vue';

import copy from 'copy-to-clipboard';

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
        base_url() {return this.$store.getters[namespace+'/state'].base_url},
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
            control_size: 'is-small',
            is_loading: false,
            inputs: {
                copyright_text_custom: false,
                copyright_link_custom: false,
                copyright_year_custom: false,
                search_engine_visibility:{
                    type: null,
                    message: null,
                },
                maintenance_mode:{
                    type: null,
                    message: null,
                },
                password_protection:{
                    type: null,
                    message: null,
                },
                laravel_queues:{
                    type: null,
                    message: null,
                },

            },
        };

        return obj;
    },
    watch: {

        'list.copyright_text': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'app_name')
                {
                    this.inputs.copyright_text_custom = false;
                }
            }
        },
        'inputs.copyright_text_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.copyright_text = '';
                    this.updateList();
                }
            }
        },

        'list.copyright_link': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'app_url')
                {
                    this.inputs.copyright_link_custom = false;
                }
            }
        },
        'inputs.copyright_link_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.copyright_link = '';
                    this.updateList();
                }
            }
        },

        'list.copyright_year': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 'use_current_year')
                {
                    this.inputs.copyright_year_custom = false;
                }
            }
        },
        'inputs.copyright_year_custom': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val)
                {
                    this.list.copyright_year = '';
                    this.updateList();
                }
            }
        },
        'list.search_engine_visibility': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 1)
                {
                    this.inputs.search_engine_visibility.type = null;
                    this.inputs.search_engine_visibility.message = null;
                } else
                {
                    this.inputs.search_engine_visibility.type = 'is-danger';
                    this.inputs.search_engine_visibility.message = "The site will be discouraged to be indexed by search engines";
                }
            }
        },
        'list.maintenance_mode': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 0)
                {
                    this.inputs.maintenance_mode.type = null;
                    this.inputs.maintenance_mode.message = null;
                } else
                {
                    this.inputs.maintenance_mode.type = 'is-danger';
                    this.inputs.maintenance_mode.message = "The site will display a maintenance page only.";
                }
            }
        },
        'list.password_protection': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 0)
                {
                    this.inputs.password_protection.type = null;
                    this.inputs.password_protection.message = null;
                } else
                {
                    this.inputs.password_protection.type = 'is-danger';
                    this.inputs.password_protection.message = "The site will only be accessing using this password.";
                }
            }
        },

        'list.laravel_queues': {
            deep: true,
            handler(new_val, old_val) {
                if(new_val == 0)
                {
                    this.inputs.laravel_queues.type = null;
                    this.inputs.laravel_queues.message = null;
                } else
                {
                    this.inputs.laravel_queues.type = 'is-success';
                    this.inputs.laravel_queues.message = "Make sure you set up the cron job for: " +
                        "php artisan queue:work --queue=high,medium,low,default --env=env-file";
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
            this.is_loading = true;
            let params = {
                list: this.list
            };
            let url = this.ajax_url+'/store/site/settings';
            this.$vaah.ajax(url, params, this.storeSiteSettingsAfter);
        },
        //---------------------------------------------------------------------
        storeSiteSettingsAfter: function (data, res) {
            this.$Progress.finish();
            this.is_loading = false;
        },
        //---------------------------------------------------------------------
        copySetting: function (value,is_method = false)
        {
            let setting = null;

            if(is_method){
                setting = "{!! "+value+" !!}";
            }else{
                setting = "{!! config('settings.global."+value+"'); !!}";
            }

            copy(setting);
            this.$buefy.toast.open({
                message: 'Copied!',
                type: 'is-success'
            });
        },
        //---------------------------------------------------------------------
        clearCache: function () {
            this.$Progress.start();
            this.btn_is_loading = true;
            let params = {};
            let url = this.base_url+'/clear/cache';
            this.$vaah.ajax(url, params, this.clearCacheAfter);
        },
        //---------------------------------------------------------------------
        clearCacheAfter: function (data, res) {
            this.$Progress.finish();
            this.btn_is_loading = false;
            window.location.reload(true);

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
