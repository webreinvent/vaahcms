import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';


export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        let obj = {
            labelPosition: 'on-border',
        };
        return obj;
    },
    watch: {
    },
    mounted() {

        //---------------------------------------------------------------------
        document.title = "Jobs";
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
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
