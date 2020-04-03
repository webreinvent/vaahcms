import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker'
import AutoComplete from '../../vaahvue/reusable/AutoComplete'

let namespace = 'registrations';

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
            this.$vaah.ajax(url, this.params, this.getItemAfter);
        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            this.$Progress.finish();
            this.is_content_loading = false;

            if(data && data.item)
            {
                console.log('--->data.item', data);
                this.update('active_item', data.item);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'reg.list'});
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

            console.log('--->params', params);

            let url = this.ajax_url+'/store/'+this.item.id;
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {

            this.$Progress.finish();

            if(data)
            {
                this.$root.$emit('eReloadList');

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
            this.$router.push({name:'reg.list'});
        },
        //---------------------------------------------------------------------
        saveAndNew: function () {
            this.update('active_item', null);
            this.resetNewItem();
            this.$router.push({name:'reg.create'});
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
            this.update('active_item', null);
            this.$router.push({name:'reg.create'});
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
                };

            for(let key in new_item)
            {
                new_item[key] = this.item[key];
            }
            this.update('new_item', new_item);
        }
        //---------------------------------------------------------------------
    }
}
