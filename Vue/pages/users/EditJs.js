import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker.vue'
import AutoComplete from '../../vaahvue/reusable/AutoComplete.vue'
import FileUploader from '../../vaahvue/reusable/FileUploader.vue'

let namespace = 'users';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        item() {return this.$store.getters[namespace+'/state'].active_item},
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
            is_content_loading: false,
            is_btn_loading: null,
            labelPosition: 'on-border',
            params: {},
            local_action: null,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView()
        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------

        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.is_content_loading = true;

            this.updateView();
            this.getAssets();
            this.getItem();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        getItem: function () {
            this.$Progress.start();
            this.params = {};
            let url = this.ajax_url+'/item/'+this.$route.params.id;
            this.$vaah.ajaxGet(url, this.params, this.getItemAfter);
        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            this.$Progress.finish();
            this.is_content_loading = false;

            if(data)
            {
                this.update('active_item', data);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'user.list'});
            }
        },
        //---------------------------------------------------------------------
        updateNewItem: function()
        {
            this.update('item', this.item);
        },
        //---------------------------------------------------------------------
        setBirthDate: function (date) {
            this.item.birth = date;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        setTimeZone: function (item) {
            this.item.timezone = item.slug;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        setCountry: function (item) {
            this.item.country = item.name;
            this.item.country_code = item.code;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        store: function () {
            this.$Progress.start();

            let params = this.item;

            let url = this.ajax_url+'/store/'+this.item.id;
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {

            this.$Progress.finish();

            if(data)
            {

                this.$emit('eReloadList');

                if(this.local_action === 'save-and-close')
                {
                    this.saveAndClose()
                }

                if(this.local_action === 'save-and-new')
                {
                    this.saveAndNew()
                }

                if(this.local_action === 'save-and-clone')
                {
                    this.saveAndClone()
                }

            }

        },
        //---------------------------------------------------------------------
        setLocalAction: function (action) {
            this.local_action = action;
            this.store();
        },
        //---------------------------------------------------------------------
        saveAndClose: function () {
            this.update('active_item', null);
            this.$router.push({name:'user.list'});
        },
        //---------------------------------------------------------------------
        saveAndNew: function () {
            this.update('active_item', null);
            this.resetNewItem();
            this.$router.push({name:'user.create'});
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
            this.update('active_item', null);
            this.$router.push({name:'user.create'});
        },
        //---------------------------------------------------------------------
        getNewItem: function()
        {
            let new_item = {
                email: null,
                username: null,
                password: null,
                display_name: null,
                title: null,
                first_name: null,
                middle_name: null,
                last_name: null,
                gender: null,
                country_calling_code: null,
                phone: null,
                timezone: null,
                alternate_email: null,
                avatar_url: null,
                birth: null,
                country: null,
                country_code: null,
                status: null,
                is_active: null,
            };
            return new_item;
        },
        //---------------------------------------------------------------------
        resetNewItem: function()
        {
            let new_item = this.getNewItem();
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        resetActiveItem: function () {
            this.update('active_item', null);
            this.$router.push({name:'user.list'});
        },
        //---------------------------------------------------------------------
        setStatus: function()
        {
           if(this.item.is_active == '1'){
               this.item.status = 'active';
           }else{
               this.item.status = 'inactive';
           }
        },
        //---------------------------------------------------------------------
        setIsActiveStatus: function()
        {
           if(this.item.status == 'active'){
               this.item.is_active = 1;
           }else{
               this.item.is_active = 0;
           }
        },
        //---------------------------------------------------------------------
        fillNewItem: function () {

            let new_item = {
                    email: null,
                    username: null,
                    password: null,
                    display_name: null,
                    title: null,
                    first_name: null,
                    middle_name: null,
                    last_name: null,
                    gender: null,
                    country_calling_code: null,
                    phone: null,
                    timezone: null,
                    alternate_email: null,
                    avatar_url: null,
                    birth: null,
                    country: null,
                    country_code: null,
                    status: null,
                    is_active: null,
                };

            for(let key in new_item)
            {
                new_item[key] = this.item[key];
            }
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        storeAvatar: function (data) {
            this.$Progress.start();
            let params = data;
            params.user_id = this.item.id;
            let url = this.ajax_url+'/avatar/store';
            this.$vaah.ajax(url, params, this.storeAvatarAfter);
        },
        //---------------------------------------------------------------------
        storeAvatarAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.item.avatar = data.avatar;
                this.item.avatar_url = data.avatar_url;
                this.update('active_item', this.item);
            }

        },
        //---------------------------------------------------------------------
        removeAvatar: function () {
            this.$Progress.start();
            let params = {
                user_id: this.item.id
            };

            let url = this.ajax_url+'/avatar/remove';
            this.$vaah.ajax(url, params, this.removeAvatarAfter);
        },
        //---------------------------------------------------------------------
        removeAvatarAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.item.avatar = data.avatar;
                this.item.avatar_url = data.avatar_url;
                this.update('active_item', this.item);
            }

        },
        //---------------------------------------------------------------------
        isHidden: function(key)
        {
            if(this.page.assets.fields
                && this.page.assets.fields[key]
                && this.page.assets.fields[key].is_hidden){
                return this.page.assets.fields[key].is_hidden
            }

            return false;
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
