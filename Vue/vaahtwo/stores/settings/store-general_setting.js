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
        activeIndex:[],
        selectedFieldType:null,
        fieldTypes:[
            {name:"Text",value:"text"},
            {name:"Email",value:"email"},
            {name:"TextArea",value:"textarea"},
            {name:"Number",value:"number"},
            {name:"Password",value:"password"}
        ],
        languages: null,
        selectedLanguage: null,
        visibility: 'Visible',
        visibitlityOptions: ['Visible', 'Invisible'],
        redirectAfterLogout: 'Backend',
        redirectAfterLogoutOptions: ['Backend', 'Frontend', 'Custom'],
        copyrightText: 'app-name',
        copyrightLink: 'Use App Url',
        copyrightYear: 'Use Current Year',
        passwordProtection: 'Disable',
        passwordProtectionOptions: ['Disable', 'Enable'],
        laravelQueues: 'Enable',
        laravelQueuesOptions: ['Disable', 'Enable'],
        socialMediaLinks: null,
        addLink: null,
        showLinkInput: true,
        dateFormatOptions: ['Y-m-d', 'y/m/d', 'y.m.d', 'Custom'],
        dateFormat: 'y-m-d',
        timeFormatOptions: ['H:i:s', 'h:i A', 'h:i:s A', 'Custom'],
        timeFormat: 'H:i:s',
        dateTimeFormatOptions: ['Y-m-d H:i:s', 'Y-m-d h:i A', 'd-M-Y H:i', 'Custom'],
        dateTimeFormat: 'Y-m-d H:i:s',
        metaTag: null,
        scriptTag:{
            script_after_body_start:null,
            script_after_head_start:null,
            script_before_body_close:null,
            script_before_head_close:null,
        },
        value:null,
    }),
    getters: {

    },
    actions: {
        //---------------------------------------------------------------------
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                vaah().ajax(
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
                this.allowedFiles = data.file_types;
                this.metaOptions = data.vh_meta_attributes;

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
                this.socialMediaLinks = data.links;
                this.scriptTag = data.scripts;
                this.metaTag = data.meta_tags;
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
                this.socialMediaLinks = vaah().removeInArrayByKey(this.socialMediaLinks, item, 'id');
            } else
            {
                this.socialMediaLinks = vaah().removeInArrayByKey(this.socialMediaLinks, item, 'count');
            }
            vaah().toastErrors(['Removed']);
        },
        //---------------------------------------------------------------------
        storeSiteSettings() {
            let options = {
                method: 'post',
                params:{
                    list: this.list
                }
            };

            let ajax_url = this.ajax_url+'/store/site/settings';
            vaah().ajax(ajax_url, this.storeSiteSettingsAfter, options);
        },
        //---------------------------------------------------------------------
        storeSiteSettingsAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        storeLinks(){
            let options = {
                method: 'post',
            };

            options.params = { links: this.socialMediaLinks };

            let ajax_url = this.ajax_url+'/store/links';
            vaah().ajax(ajax_url, this.storeLinksAfter, options);
        },
        //---------------------------------------------------------------------
        storeLinksAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        storeScript(){
            let options = {
                method: 'post',
            };

            options.params = { list: this.scriptTag };

            let ajax_url = this.ajax_url+'/store/site/settings';
            vaah().ajax(ajax_url, this.storeScriptAfter, options);
        },
        //---------------------------------------------------------------------
        storeScriptAfter(){
            this.getList();
        },
        //---------------------------------------------------------------------
        expandAll() {
            let accordionTabs = document.getElementById('accordionTabContainer').children.length;
            for (let i = 0; i <= accordionTabs; i++) {
                this.activeIndex.push(i);
            }
        },
        //---------------------------------------------------------------------
        collapseAll() {
            this.activeIndex = [];
        },
        //---------------------------------------------------------------------
        addLinkHandler() {
            if (!this.showLinkInput) {
                return this.showLinkInput = true;
            } else if (this.showLinkInput && this.addLink !== "" && this.addLink !== null) {
                this.socialMediaLinks.push({label: this.addLink, icon: 'pi-link'});
                this.addLink = null;
                return this.showLinkInput = true;
            }
        },
        //---------------------------------------------------------------------
        addMetaTags() {

            let count = this.metaTag.length;

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

            this.metaTag.push(item);;

        },
        //---------------------------------------------------------------------
        storeTags() {

            let options = {
                method: 'post',
                params: this.metaTag
            };

            let ajax_url = this.ajax_url+'/store/meta/tags';
            vaah().ajax(ajax_url, this.storeTagsAfter, options);
        },
        //---------------------------------------------------------------------
        storeTagsAfter(data, res) {
            this.getList();
        },
        //---------------------------------------------------------------------
        clearCache() {

            let options = {
                method: 'get',
            };

            let ajax_url = this.ajax_url+'/clear/cache';
            vaah().ajax(ajax_url, this.clearCacheAfter, options);
        },
        //---------------------------------------------------------------------
        clearCacheAfter(data, res) {
            window.location.reload(true);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useGeneralStore, import.meta.hot))
}
