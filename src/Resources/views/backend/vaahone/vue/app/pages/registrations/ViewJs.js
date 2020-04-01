import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import TableTrView from '../../vaahvue/reusable/TableTrView'

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
        TableTrView,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_content_loading: false,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.getItem();
        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------

        //----------------------------------------------------
        //----------------------------------------------------
    },
    methods: {
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
            this.getItem();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        getItem: function (action) {

            this.$Progress.start();
            this.is_content_loading = true;

            this.params = {
                new_item: this.new_item,
                action: action
            };

            console.log('--->this.$route.params.id', this.$route.params.id);

            let url = this.ajax_url+'/item/'+this.$route.params.id;
            this.$vaah.ajax(url, this.params, this.getItemAfter);
        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            this.$Progress.finish();
            this.is_content_loading = false;

            if(data)
            {
                console.log('--->data.item', data);
                this.update('active_item', data.item);
            }
        },
        //---------------------------------------------------------------------
        isCopiable: function (label) {

            if(
                label == 'id' || label == 'uuid'
                || label == 'email' || label == 'username'
            )
            {
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        isUpperCase: function (label) {

            if(
                label == 'id' || label == 'uuid'
            )
            {
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
