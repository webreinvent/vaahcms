import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'localizations';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
    },
    data()
    {
        let obj = {
            assets:null,
            list: null,
        };

        return obj;
    },
    watch: {


    },
    mounted() {


        //---------------------------------------------------------------------

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

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
