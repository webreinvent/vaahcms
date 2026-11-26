import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'
// M3-T1 (F09) — dark-mode module (documentElement-only .app-dark, system
// watcher, pre-paint cache); the source of truth is the per-user
// vh_settings row surfaced in the assets bootstrap payload.
import {
    initDarkMode,
    applyPreference,
    watchSystemPreference,
    setCurrentPreference,
} from '../vaahvue/theme/dark-mode'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

/* M6 (F31) — the persistent nav rail's collapsed state seeds from localStorage
   at store creation (before first render, so there is no expand/collapse flash
   on load). */
function readSavedSidebarCollapsed() {
    try {
        return (typeof localStorage !== 'undefined'
            && localStorage.getItem('vaahtwo_sidebar_collapsed') === '1');
    } catch (e) {
        return false;
    }
}

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
        is_active_status_options: null,
        sidebar_collapsed: readSavedSidebarCollapsed()
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
        // M3-T1 (F09) — persist a dark-mode preference ('light'|'dark'|
        // 'system') to the per-user vh_settings row (one row per user),
        // then apply it locally. Returns a promise resolving with
        // { success, data }. The toggle UI (M6-T4/F23) calls this.
        setDarkMode(preference)
        {
            return new Promise((resolve) => {
                vaah().ajax(
                    this.json_url+'/dark-mode',
                    (data, res) => {
                        // vaah().ajax hands the callback (response.data.data, response):
                        // `success` lives on the envelope (res.data.success), not on
                        // the inner payload (`data`).
                        const body = (res && res.data) || {};
                        resolve({
                            success: body.success === true,
                            data: body.data || (data || null)
                        });
                    },
                    {
                        params: { dark_mode: preference },
                        method: 'post',
                        show_success: false
                    }
                ).then((res) => {
                    // apply regardless of persistence outcome (the request
                    // may fail when signed out — the DOM state stays
                    // consistent for this session)
                    const normalized = applyPreference(preference).preference;
                    setCurrentPreference(normalized);
                    watchSystemPreference(normalized);
                    this.assets = this.assets || {};
                    this.assets.theme = this.assets.theme || {};
                    this.assets.theme.dark_mode = normalized;
                });
            });
        },

        //---------------------------------------------------------------------
        afterGetAssets(data, res)
        {
            if(data)
            {
                this.assets = data;
                // M3-T1 (F09) — apply the server-stored dark-mode preference
                // (payload key: assets.theme.dark_mode) to <html> and arm
                // the system watcher when the preference is 'system'.
                setCurrentPreference(initDarkMode(this.assets));
                if(this.assets){

                    if(this.assets.extended_views
                        && this.assets.extended_views.sidebar_menu
                        && this.assets.extended_views.sidebar_menu.success){
                        for (const [key, module] of Object.entries(this.assets.extended_views.sidebar_menu.success)) {
                            this.setMenuItems(module);
                        }
                    }

                    this.initSidebarCollapsed();
                    if(this.assets.urls){
                        this.setTopMenuItems();
                    }
                }
            }
            if (this.assets && this.assets.language_string && this.assets.language_string.dashboard){
                this.getTopRightUserMenu();
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
        toSignIn(){

            this.$router.push({ name: 'sign.in' });

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
                window.location.href = this.base_url+'#';
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
            if (this.assets && this.assets.language_string && this.assets.language_string.dashboard) {
                return this.top_right_user_menu = [
                    {
                        label: this.assets && this.assets.language_string.dashboard.topnav_profile,
                        icon: 'pi pi-fw pi-user',
                        url: this.base_url + "#/vaah/profile/"
                    },
                    {
                        label: this.assets && this.assets.language_string.dashboard.topnav_logout,
                        icon: 'pi pi-fw pi-sign-out',
                        url: this.base_url + "/logout"
                    }
                ]
            }
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
            if (this.assets && this.assets.language_string &&  this.assets.language_string.dashboard) {

                let navigation_label = this.sidebar_collapsed ?
                    this.assets.language_string.dashboard.topnav_tooltip_view_full_navigation :
                    this.assets.language_string.dashboard.topnav_tooltip_view_less_navigation;

                this.top_menu_items = [
                    {
                        label: '',
                        tooltip: navigation_label,
                        icon: 'pi pi-align-justify',
                        command: () => {
                            // M6 (F31): the burger now toggles the persistent
                            // nav rail (maximize/minimize) instead of opening
                            // the retired off-canvas Drawer, so navigating
                            // between pages no longer forces a re-open.
                            this.toggleSidebarCollapsed();
                            this.top_menu_items[0].tooltip = this.sidebar_collapsed
                                ? this.assets.language_string.dashboard.topnav_tooltip_view_full_navigation
                                : this.assets.language_string.dashboard.topnav_tooltip_view_less_navigation;
                        }
                    },
                    {
                        label: '',
                        url: this.assets.urls.dashboard,
                        tooltip: this.assets.language_string.dashboard.topnav_tooltip_dashboard,
                        icon: 'pi pi-home'
                    },
                    {
                        label: '',
                        url: this.assets.urls.public,
                        tooltip: this.assets.language_string.dashboard.topnav_tooltip_visit_site,
                        target: '_blank',
                        icon: 'pi pi-external-link'
                    }

                ]
            }
        },

        //-----------------------------------------------------------------------
        // M6 (F31) — persistent nav rail (maximize / minimize). Replaces the
        // retired off-canvas Drawer: the Sidebar stays in the layout and this
        // runtime toggle collapses it to an icon rail. The choice persists per
        // browser (localStorage); if the user has never toggled, initSidebar
        // falls back to the admin's `is_sidebar_collapsed` site default.
        setSidebarCollapsed(collapsed) {
            this.sidebar_collapsed = !!collapsed;
            try {
                if (typeof localStorage !== 'undefined') {
                    localStorage.setItem('vaahtwo_sidebar_collapsed',
                        this.sidebar_collapsed ? '1' : '0');
                }
            } catch (e) { /* private mode: ignore */ }
        },
        toggleSidebarCollapsed() {
            this.setSidebarCollapsed(!this.sidebar_collapsed);
        },
        initSidebarCollapsed() {
            let saved = null;
            try {
                saved = (typeof localStorage !== 'undefined')
                    ? localStorage.getItem('vaahtwo_sidebar_collapsed')
                    : null;
            } catch (e) { saved = null; }
            if (saved === '1' || saved === '0') {
                this.sidebar_collapsed = saved === '1';
            } else if (this.assets && this.assets.is_sidebar_collapsed != null) {
                this.sidebar_collapsed = this.assets.is_sidebar_collapsed == 1;
            }
        }
    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRootStore, import.meta.hot))
}
