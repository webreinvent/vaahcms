import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

export const useRootStore = defineStore({
    id: 'root',
    state: () => ({
        assets: null,
        assets_is_fetching: true,
        base_url: base_url,
        ajax_url: ajax_url,
        json_url: json_url,
        gutter: 20,
        show_progress_bar: false,
        is_logged_in: false,
        is_installation_verified: false,
        permissions: null,
        top_menu_items: [
            {
                to:'/',
                title:'',
                icon:'pi pi-home'
            },
            {
                to:'/',
                title:'',
                icon:'pi pi-link'
            }
        ],
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

            }
        },


        //---------------------------------------------------------------------
        async reloadAssets(data, res)
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
                    value: null
                }
            ]
        },
        //-----------------------------------------------------------------------
        async to(path)
        {
            this.$router.push({path: path})
        },
        showProgress()
        {
            this.show_progress_bar = true;
        },
        hideProgress()
        {
            this.show_progress_bar = false;
        }

    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRootStore, import.meta.hot))
}
