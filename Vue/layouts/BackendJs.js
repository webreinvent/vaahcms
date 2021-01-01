import TopMenu from './../components/App/TopMenu.vue'
import Aside from './../components/App/Aside.vue'
import Footer from './../components/App/Footer.vue'
import Notices from './../components/Notices.vue'

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
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
