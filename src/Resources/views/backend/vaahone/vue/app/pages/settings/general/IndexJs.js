import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import TagInputs from '../../../vaahvue/reusable/TagInputs';

let namespace = 'general';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        settings() {return this.$store.getters[namespace+'/state'].settings},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
        'TagRolesOnRegistration': TagInputs,
        'TagFileTypes': TagInputs,
    },
    data()
    {
        let obj = {
            namespace:namespace,
            list: null,
            labelPosition: 'on-border',
        };

        return obj;
    },
    watch: {


    },
    mounted() {

        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
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
        onLoad: function()
        {
            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
