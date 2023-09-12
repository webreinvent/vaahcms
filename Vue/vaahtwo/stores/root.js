import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

export const useRootStore = defineStore({
    id: 'root',
    state: () => ({
        assets: null,
        active_item:null,
        assets_is_fetching: true,
        sidebar_expanded_keys: {},
        base_url: base_url,
        ajax_url: ajax_url,
        json_url: json_url,
        gutter: 20,
        show_progress_bar: false,
        is_logged_in: false,
        is_installation_verified: false,
        permissions: null,
        top_menu_items: [],
        top_dropdown_menu_items: [
            {
                label:'Profile',
                icon:'pi pi-fw pi-user',
                to:{path:'/ui/private/profile'}
            },
            {
                label:'Logout',
                icon:'pi pi-fw pi-sign-out',
                command: () =>{
                }
            }
        ],
        top_right_user_menu: null,
        is_active_status_options: null
    }),
    getters: {},
    actions: {
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                let params = {
                };

                vaah().ajax(
                    this.json_url+'/assets',
                    this.afterGetAssets,
                    params
                );
            }
        },

        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;
                if(this.assets){

                    if(this.assets.extended_views
                        && this.assets.extended_views.sidebar_menu
                        && this.assets.extended_views.sidebar_menu.success){
                        for (const [key, module] of Object.entries(this.assets.extended_views.sidebar_menu.success)) {
                            this.setMenuItems(module);
                        }
                    }

                    if(this.assets.urls){
                        this.setTopMenuItems();
                    }
                }
            }
        },

        //---------------------------------------------------------------------
        async checkSignupPageVisible(){
            if ( this.assets && this.assets.settings &&
                this.assets.settings.is_signup_page_visible == false &&
                this.$router.currentRoute.value.name === 'signup'){
                    this.$router.push({ name: 'sign.in' });
            }
        },

        //---------------------------------------------------------------------
        async reloadAssets()
        {
            this.assets_is_fetching = true;
            await this.getAssets();
        },
        //---------------------------------------------------------------------
        checkLoggedIn()
        {
            let params = {
                method: 'post'
            };

            vaah().ajax(
                this.json_url+'/is-logged-in',
                this.afterCheckLoggedIn,
                params
            );
        },
        //---------------------------------------------------------------------
        afterCheckLoggedIn(data,res)
        {
            if(data && data.is_logged_in == false)
            {
                this.$router.push({name: 'sign.in'})
                return false;
            }

            this.is_logged_in = true;
        },
        //-----------------------------------------------------------------------
        async getPermission() {
            let params = {
                method: 'post'
            };

            vaah().ajax(
                this.json_url+'/permissions',
                this.afterGetPermission,
                params
            );
        },
        //-----------------------------------------------------------------------
        afterGetPermission(data, res) {
            if (data) {
                this.permissions = data.list;
            }
        },
        //---------------------------------------------------------------------
        async verifyInstallStatus() {

            let params = {
            };

            vaah().ajax(
                this.ajax_url+'/setup/json/status',
                this.afterVerifyInstallStatus,
                params
            );

        },


        //---------------------------------------------------------------------
        afterVerifyInstallStatus(data, res)
        {
            if(data)
            {

                if(data.stage !== 'installed')
                {
                    this.$router.push({name : 'setup.index'});
                }

                this.is_installation_verified = true;

            }
        },


        //---------------------------------------------------------------------
        toggleTopDropDownMenu()
        {
            if(data)
            {

                if(data.stage !== 'installed')
                {
                    this.$router.push({name : 'setup.index'});
                }

                this.is_installation_verified = true;

            }
        },
        //-----------------------------------------------------------------------
        async getTopRightUserMenu() {
            return this.top_right_user_menu = [
                {
                    label: "Profile",
                    icon:'pi pi-fw pi-user',
                    url: this.base_url+"#/vaah/profile/"
                },
                {
                    label: "Logout",
                    icon:'pi pi-fw pi-sign-out',
                    url: this.base_url+"/logout"
                }
            ]
        },
        //-----------------------------------------------------------------------
        async getIsActiveStatusOptions() {
            return this.is_active_status_options = [
                {
                    label: 'Yes',
                    value: 1
                },
                {
                    label: 'No',
                    value: 0
                }
            ]
        },
        //-----------------------------------------------------------------------
        async to(path)
        {
            this.$router.push({path: path})
        },
        //-----------------------------------------------------------------------
        showProgress()
        {
            this.show_progress_bar = true;
        },
        //-----------------------------------------------------------------------
        hideProgress()
        {
            this.show_progress_bar = false;
        },
        //-----------------------------------------------------------------------
        async markAsRead(item, dismiss=false){

            let options = {
                method:'post',
                params:item,
            };
            this.active_item = item;
            this.active_item.dismiss = dismiss;

            await vaah().ajax(
                this.ajax_url+'/notices/mark-as-read',
                this.markAsReadAfter,
                options
            );
        },
        //-----------------------------------------------------------------------
        markAsReadAfter(data, res){
            let item  = this.active_item;

            let list = vaah().removeInArrayByKey(this.assets.vue_notices, this.active_item, 'id');
            this.assets.vue_notices = list;
            this.active_item = null;
            if(item.meta && item.meta.action
                && item.meta.action.link && item.dismiss != true)
            {
                window.location.href = item.meta.action.link;
            }
        },
        //-----------------------------------------------------------------------
        showResponse(data){

            if(data.status != 'success'){
                vaah().toastErrors([data.error]);
            }else{
                vaah().toastSuccess([data.message]);
            }

            this.$router.replace({query: null})
        },
        //-----------------------------------------------------------------------
        setMenuItems(module){

            let self = this;

            module.forEach( (menu,m_key) => {

                if(menu['child']){
                    Object.assign(menu,
                        {items: menu['child']})
                }

                if(menu['items']){
                    self.setMenuItems(menu['items']);
                }

                let key = vaah().strToSlug(menu['label']);
                menu['key'] = key;

                if(menu.hasOwnProperty('is_expanded') && menu['is_expanded'] === true){
                    self.sidebar_expanded_keys[key] = true;
                }

            })
        },
        //-----------------------------------------------------------------------
        impersonateLogout(){

            let options = {
                method:'post'
            };

            vaah().ajax(
                this.ajax_url+'/users/impersonate/logout',
                this.afterImpersonateLogout,
                options
            );
        },
        //-----------------------------------------------------------------------
        afterImpersonateLogout(res,data){

            if(data && data.data && data.data.success){
                location.reload(true);
            }
        },

        //-----------------------------------------------------------------------
        setTopMenuItems(){

            this.top_menu_items = [
                {
                    label:'',
                    tooltip:'View Less Navigation',
                    icon:'pi pi-align-justify',
                    command: () => {

                        if(document.body.classList.contains("has-sidebar-small")){
                            document.body.classList.remove("has-sidebar-small");
                            this.top_menu_items[0].tooltip = 'View Less Navigation';
                        }else{
                            document.body.classList.add("has-sidebar-small");
                            this.top_menu_items[0].tooltip = 'View Full Navigation';
                        }

                    }
                },
                {
                    label:'',
                    url:this.assets.urls.dashboard,
                    tooltip:'Dashboard',
                    icon:'pi pi-home'
                },
                {
                    label:'',
                    url:this.assets.urls.public,
                    tooltip:'Visit Site',
                    target:'_blank',
                    icon:'pi pi-external-link'
                }

            ]
        }
    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRootStore, import.meta.hot))
}
