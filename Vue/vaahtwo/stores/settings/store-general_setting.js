import { watch } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import { vaah } from '../../vaahvue/pinia/vaah'
import { useRootStore } from "./../root";
import qs from 'qs'

let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/general";

let empty_states = {
    query: [],
    list: null,
    action: []
};

export const useGeneralStore = defineStore({
    id: 'general',
    state: () => ({
        title: 'General - Settings',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        assets: null,
        rows_per_page: [10,20,30,50,100,500],
        list: null,
        item: null,
        fillable:null,
        empty_query:empty_states.query,
        empty_action:empty_states.action,
        query: vaah().clone(empty_states.query),
        action: vaah().clone(empty_states.action),
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
        route: null,
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        form: {
            type: 'Create',
            action: null,
            is_button_loading: null
        },
        is_list_loading: null,
        count_filters: 0,
        list_selected_menu: [],
        list_bulk_menu: [],
        item_menu_list: [],
        item_menu_state: null,
        form_menu_list: [],
        field:{
            name:null,
            type:null
        },
        field_type: null,
        custom_field_list:null,
        active_index:[],
        languages: null,
        visibitlity_options: [{name:'Enable',value:"1"}, {name:'Disable',value:"0"}],
        maintenanceModeOptions: [{name:'Enable',value:"1"}, {name:'Disable',value:"0"}],
        redirect_after_logout_options: [
            {name:'Backend',value:'backend'},
            {name:'Frontend',value:'frontend'},
            {name:'Custom',value:'custom'}
        ],
        password_protection_options: [{name:'Enable',value:"1"}, {name:'Disable',value:"0"}],
        copyright_text_options: [{name:'Use App Name',value:"app_name"}, {name:'Custom',value:"custom"}],
        copyright_link_options: [{name:'Use App Url',value:"app_url"}, {name:'Custom',value:"custom"}],
        copyright_year_options: [{name:'Use Current year',value:"use_current_year"}, {name:'Custom',value:"custom"}],
        laravel_queues_options: [{name:'Enable',value:"1"}, {name:'Disable',value:"0"}],
        sign_up_options: [{name:'Enable',value:"1"}, {name:'Disable',value:"0"}],
        social_media_links: null,
        add_link: null,
        show_link_input: true,
        date_format_options: ['Y-m-d', 'y/m/d', 'y.m.d', 'custom'],
        time_format_options: ['H:i:s', 'h:i A', 'h:i:s A', 'custom'],
        date_time_format_options: ['Y-m-d H:i:s', 'Y-m-d h:i A', 'd-M-Y H:i', 'custom'],
        meta_tag: null,
        script_tag:{
            script_after_body_start:null,
            script_after_head_start:null,
            script_before_body_close:null,
            script_before_head_close:null,
        },
        allowed_files:null,
        tag_type:null,
        filtered_registration_roles:null,
        filtered_allowed_files:null,
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                await vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                );
            }
        },
        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;
                this.languages = data.languages;
                this.allowed_files = data.file_types;
            }
        },
        //---------------------------------------------------------------------
        async getList() {
            let options = {
                query: vaah().clone(this.query)
            };

            await vaah().ajax(
                this.ajax_url+'/list',
                this.afterGetList,
                options
            );
        },
        //---------------------------------------------------------------------
        afterGetList(data, res)
        {
            if (data) {
                this.list = data.list;
                this.social_media_links = data.links;
                this.script_tag = data.scripts;
                this.meta_tag = data.meta_tags;
                this.list.maximum_number_of_forgot_password_attempts_per_session = parseInt(this.list.maximum_number_of_forgot_password_attempts_per_session);
                this.list.maximum_number_of_login_attempts_per_session = parseInt(this.list.maximum_number_of_login_attempts_per_session);
            }
        },
        //---------------------------------------------------------------------
        getCopy(value)
        {
           let text =  "{!! config('settings.global."+value+"'); !!}";
            navigator.clipboard.writeText(text);
            vaah().toastSuccess(['Copied']);
        },
        //---------------------------------------------------------------------
        removeVariable(item) {

            if(item.id)
            {
                this.social_media_links = vaah().removeInArrayByKey(this.social_media_links, item, 'id');
            } else
            {
                this.social_media_links = vaah().removeInArrayByKey(this.social_media_links, item, 'count');
            }
            vaah().toastErrors(['Removed']);
        },
        //---------------------------------------------------------------------
        async storeSiteSettings() {
            let options = {
                method: 'post',
                params:{
                    list: this.list
                }
            };

            let ajax_url = this.ajax_url+'/store/site/settings';
            await vaah().ajax(ajax_url, this.storeSiteSettingsAfter, options);
        },
        //---------------------------------------------------------------------
        storeSiteSettingsAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        async storeLinks(){
            let options = {
                method: 'post',
            };

            options.params = { links: this.social_media_links };

            let ajax_url = this.ajax_url+'/store/links';
            await vaah().ajax(ajax_url, this.storeLinksAfter, options);
        },
        //---------------------------------------------------------------------
        storeLinksAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        async storeScript(){
            let options = {
                method: 'post',
            };

            options.params = { list: this.script_tag };

            let ajax_url = this.ajax_url+'/store/site/settings';
            await vaah().ajax(ajax_url, this.storeScriptAfter, options);
        },
        //---------------------------------------------------------------------
        storeScriptAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        async storeSecuritySettings () {
            let options = {
                method: 'post',
            };

            options.params = { list: this.list };

            let ajax_url = this.ajax_url+'/store/site/settings';
            await vaah().ajax(ajax_url, null, options);

        },
        //---------------------------------------------------------------------
        expandAll() {
            let accordionTabs = document.getElementById('accordionTabContainer').children.length;
            for (let i = 0; i <= accordionTabs; i++) {
                this.active_index.push(i);
            }
        },
        //---------------------------------------------------------------------
        collapseAll() {
            this.active_index = [];
        },
        //---------------------------------------------------------------------
        addLinkHandler() {
            if (!this.show_link_input) {
                return this.show_link_input = true;
            } else if (this.show_link_input && this.add_link !== "" && this.add_link !== null) {
                let count = this.social_media_links.length;

                let item = {
                    id: null,
                    count: count,
                    category: "global",
                    label: this.add_link,
                    excerpt: null,
                    type: "link",
                    key: "link_"+count,
                    value: null,
                    created_at: null,
                    updated_at: null,
                };
                this.social_media_links.push(item);
                this.add_link = null;
                return this.show_link_input = true;
            }
        },
        //---------------------------------------------------------------------
        addMetaTags() {

            let count = this.meta_tag.length;

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

            this.meta_tag.push(item);;

        },
        //---------------------------------------------------------------------
        async storeTags() {
            let options = {
                method: 'post',
                params: {
                    tags:this.meta_tag
                }
            };

            let ajax_url = this.ajax_url+'/store/meta/tags';
            await vaah().ajax(ajax_url, this.storeTagsAfter, options);
        },
        //---------------------------------------------------------------------
        storeTagsAfter(data, res) {
            this.getList();
        },
        //---------------------------------------------------------------------
        async clearCache() {

            let options = {
                method: 'get',
            };

            let ajax_url = this.base_url+'/clear/cache';
            await vaah().ajax(ajax_url, this.clearCacheAfter, options);
        },
        //---------------------------------------------------------------------
        clearCacheAfter(data, res) {
            window.location.reload(true);
        },
        //---------------------------------------------------------------------
        async removeMetaTags(tag){
            if(tag.id)
            {
                this.meta_tag = vaah().removeInArrayByKey(this.meta_tag, tag, 'id');
                let options = {
                    method: 'POST',
                    params: tag
                };
                await vaah().ajax(
                    this.ajax_url+'/delete/meta/tag',
                    null,
                    options
                );
            } else
            {
                this.meta_tag = vaah().removeInArrayByKey(this.meta_tag, tag, 'uid');
            }
        },
        //---------------------------------------------------------------------
        generateTags() {
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
        generateOpenGraph(){

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

            this.meta_tag = this.meta_tag.concat(list);

        },
        //---------------------------------------------------------------------
        generateWebmaster() {

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

            this.meta_tag = this.meta_tag.concat(list);

        },
        //---------------------------------------------------------------------
        searchRegistrationRoles(event){
            if (!event.query.trim().length) {
                this.filtered_registration_roles = this.assets.roles;
            }
            else {
                this.filtered_registration_roles = this.assets.roles.filter((roles) => {
                    return roles.toLowerCase().startsWith(event.query.toLowerCase());
                });
            }
        },
        searchAllowedFiles(event){
            if (!event.query.trim().length) {
                this.filtered_allowed_files = this.assets.file_types;
            }
            else {
                this.filtered_allowed_files = this.assets.file_types.filter((files) => {
                    return files.toLowerCase().search(event.query.toLowerCase());
                });
            }
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }
    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useGeneralStore, import.meta.hot))
}
