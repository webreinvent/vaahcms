import TopMenu from './../components/App/TopMenu'
import Aside from './../components/App/Aside'
import Footer from './../components/App/Footer'

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{
        TopMenu,
        Aside,
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
