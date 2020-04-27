import TopMenu from './../components/App/TopMenu'
import Aside from './../components/App/Aside'
import Footer from './../components/App/Footer'
import Notices from './../components/Notices'

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{
        TopMenu,
        Aside,
        Footer,
        Notices,
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
