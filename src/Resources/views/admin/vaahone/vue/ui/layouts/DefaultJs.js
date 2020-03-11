import globalComponents from "../vaahnuxt/helpers/globalComponents";
import Footer from './../components/partials/Footer'

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{
        ...globalComponents,
        Footer,
    },
    data()
    {
        let obj = {
            assets: null,
        };

        return obj;
    },
    watch: {



    },
    mounted() {
        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
