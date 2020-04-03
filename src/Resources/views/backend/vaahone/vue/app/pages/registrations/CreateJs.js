import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker'
import AutoComplete from '../../vaahvue/reusable/AutoComplete'

let namespace = 'registrations';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        new_item() {return this.$store.getters[namespace+'/state'].new_item},
        new_item_errors() {return this.$store.getters[namespace+'/state'].new_item_errors},
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
        this.resetActiveItem();
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
            this.updateView();
            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        resetActiveItem: function()
        {
            this.update('active_item', null);
        },
        //---------------------------------------------------------------------
        create: function (action) {
            this.is_btn_loading = true;

            //  this.$Progress.start();

            this.params = {
                new_item: this.new_item,
                action: action
            };

            let url = this.ajax_url+'/create';
            this.$vaah.ajax(url, this.params, this.createAfter);
        },
        //---------------------------------------------------------------------
        createAfter: function (data, res) {
            this.is_btn_loading = false;
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
        updateNewItem: function()
        {
            this.update('new_item', this.new_item);
        },
        //---------------------------------------------------------------------
        setBirthDate: function (date) {
            this.new_item.birth = date;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        setTimeZone: function (item) {
            this.new_item.timezone = item.slug;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        setCountry: function (item) {
            this.new_item.country = item.name;
            this.new_item.country_code = item.code;
            this.updateNewItem();
        },
        //---------------------------------------------------------------------
        setLocalAction: function (action) {
            this.local_action = action;
            this.create();
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
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
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
                new_item[key] = this.new_item[key];
            }
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
