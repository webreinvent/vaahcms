import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker'
import AutoComplete from '../../vaahvue/reusable/AutoComplete'

let namespace = 'profile';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        profile() {return this.$store.getters[namespace+'/state'].profile},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
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
            is_btn_loading: false,
            is_content_loading: false,
            namespace: namespace,
            labelPosition: 'on-border',
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
            this.getAssets();
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
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
