import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'


let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/profile";

export const useProfileStore = defineStore({
    id: 'profile',
    state: () => ({
        title: 'Profile',
        assets: null,
        list: null,
        profile: null,
        mfa_methods: null,
        active_item:null,
        assets_is_fetching: true,
        base_url: base_url,
        ajax_url: ajax_url,
        gutter: 20,
        show_progress_bar: false,
        is_logged_in: false,
        is_installation_verified: false,
        permissions: null,
        gender: null,
        filtered_timezone: null,
        filtered_country: null,
        filtered_country_codes: null,
        reset_password: {
            current_password:null,
            new_password:null,
            confirm_password:null
        },
        gender_options: [
            {name:'Male',value:'m',icon: ''},
            {name:'Female',value:'f',icon: ''},
            {name:'Others',value:'o',icon: ''},
        ],
    }),
    getters: {},
    actions: {
        async getAssets() {

            if(this.assets_is_fetching === true){
                this.assets_is_fetching = false;

                let options = {
                    method:'post'
                };

                await vaah().ajax(
                    this.ajax_url+'/assets',
                    this.afterGetAssets,
                    options
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
        async getProfile() {

            let options = {
                method:'post'
            };

            await vaah().ajax(
                this.ajax_url,
                this.afterGetProfile,
                options
            );
        },
        //---------------------------------------------------------------------
        afterGetProfile(data, res)
        {
            if(data)
            {
                this.list = data;
                this.mfa_methods=data.mfa_methods;
                this.profile = data.profile;
            }
        },
        //---------------------------------------------------------------------
        searchCountry(event){
            this.country_name_object = null;
            this.country = null;

            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filtered_country = this.assets.countries;
                }
                else {
                    this.filtered_country = this.assets.countries.filter((country) => {
                        return country.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        searchCountryCode(event){
            this.country_name_object = null;
            this.country = null;

            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filtered_country_codes = this.assets.country_code;
                }
                else {
                    this.filtered_country_codes = this.assets.country_code.filter((country_calling_code) => {
                        return country_calling_code.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
        //---------------------------------------------------------------------
        setCountry(event){
            console.log(this.profile.country);
            this.profile.country = event.value.name;
        },
        setCountryCode(event){
            this.profile.country_calling_code = event.value.calling_code;
        },
        //---------------------------------------------------------------------
        async storeProfile(){
            let options = {
                method:'post',
                params:this.profile,
            };

            await vaah().ajax(
                this.ajax_url+'/store',
                null,
                options
            );
        },
        //---------------------------------------------------------------------
        async storePassword() {
            let options = {
                method:'post',
                params:this.reset_password,
            };

            await vaah().ajax(
                this.ajax_url+'/store/password',
                this.storePasswordAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        storePasswordAfter(data, res) {
            if(data){
                window.location.href = data.redirect_url;
            }
        },
        //---------------------------------------------------------------------
        async storeAvatar(event){
            let options = {
                method:'post',
                params:event,
            };

            await vaah().ajax(
                this.ajax_url+'/avatar/store',
                this.storeAvatarAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        storeAvatarAfter(data, res) {
            if(data){
                this.profile.avatar = data.avatar;
                this.profile.avatar_url = data.avatar_url;
            }

        },
        //---------------------------------------------------------------------
        async removeAvatar(){
            let options = {
                method:'post'
            };

            await vaah().ajax(
                this.ajax_url+'/avatar/remove',
                this.removeAvatarAfter,
                options
            );
        },
        //---------------------------------------------------------------------
        removeAvatarAfter(data, res) {
            if(data){
                this.profile.avatar = data.avatar;
                this.profile.avatar_url = data.avatar_url;
            }
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }
    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useProfileStore, import.meta.hot))
}
