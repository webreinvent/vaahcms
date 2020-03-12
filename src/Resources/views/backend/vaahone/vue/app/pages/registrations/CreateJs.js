import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'

let namespace = 'registrations';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        new_item() {return this.$store.getters[namespace+'/state'].new_item},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        return {
            is_content_loading: false,
            labelPosition: 'on-border',
        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.getAssets();
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
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
