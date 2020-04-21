import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker'
import AutoComplete from '../../vaahvue/reusable/AutoComplete'
import FileUploader from '../../vaahvue/reusable/FileUploader'

let namespace = 'profile';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        root_assets() {return this.$store.getters['root/state'].assets},
        page() {return this.$store.getters[namespace+'/state']},
        profile() {return this.$store.getters[namespace+'/state'].profile},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        DatePicker,
        'AutoCompleteTimeZone': AutoComplete,
        'AutoCompleteCountry': AutoComplete,
        'AvatarUploader': FileUploader,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_content_loading: false,
            namespace: namespace,
            labelPosition: 'on-border',
            server:null,
            myFiles: []
        }
    },
    watch: {

    },
    mounted() {
        this.onLoad();
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
        updateProfile: function()
        {
            let update = {
                state_name: 'profile',
                state_value: this.profile,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.serverConfig();
            this.getAssets();
        },
        //---------------------------------------------------------------------
        serverConfig: function()
        {
            this.server = {
                url: this.root_assets.urls.upload,
                process:{
                    method: 'POST',
                    timeout: 7000,
                    onload: function (response) {
                        console.log('--->onload', response);
                    },
                    onerror: function (response) {
                        console.log('--->onerror', response);
                    },
                    ondata: function (formData) {
                        console.log('--->formData', formData);
                        return formData;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('#_token').attr('content'),
                        'Upload-Name': 'media'
                    },
                }



            };
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
            this.getProfile();
        },
        //---------------------------------------------------------------------
        getProfile: function () {
            this.is_content_loading = true;
            let params = {};
            let url = this.ajax_url;
            this.$vaah.ajax(url, params, this.getProfileAfter);
        },
        //---------------------------------------------------------------------
        getProfileAfter: function (data, res) {
            this.is_content_loading = false;
            if(data)
            {
                this.update('profile', data.profile);
            }
        },
        //---------------------------------------------------------------------
        setBirthDate: function (date) {
            console.log('--->date', date);
            this.profile.birth = date;
            this.updateProfile();
        },
        //---------------------------------------------------------------------
        setTimeZone: function (item) {
            this.profile.timezone = item.slug;
            this.updateProfile();
        },
        //---------------------------------------------------------------------
        setCountry: function (item) {
            this.profile.country = item.name;
            this.profile.country_code = item.code;
            this.updateProfile();
        },
        //---------------------------------------------------------------------
        storeProfile: function () {
            this.$Progress.start();
            let params = this.profile;
            let url = this.ajax_url+'/store';
            this.$vaah.ajax(url, params, this.storeProfileAfter);
        },
        //---------------------------------------------------------------------
        storeProfileAfter: function (data, res) {
            this.$Progress.finish();
            if(data)
            {
                this.update('profile', this.profile);
            }
        },
        //---------------------------------------------------------------------
        storePassword: function () {
            this.$Progress.start();
            let params = this.page.reset_password;
            let url = this.ajax_url+'/store/password';
            this.$vaah.ajax(url, params, this.storePasswordAfter);
        },
        //---------------------------------------------------------------------
        storePasswordAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                window.location.href = data.redirect_url;
            }
        },
        //---------------------------------------------------------------------

        storeAvatar: function (data) {
            console.log('--->data received', data);
            //this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/url';
            //this.$vaah.ajax(url, params, this.fnAfter);
        },
        //---------------------------------------------------------------------
        fnAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.update('list', data.list);
            }

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
