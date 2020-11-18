
export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        ajax_url() {return this.$store.getters['root/state'].ajax_url},
    },
    components:{

    },
    data()
    {
        return {
            is_btn_loading: false,
            credentials: {
                email: null,
                password: null
            },

        }
    },
    watch: {

    },
    mounted() {

    },
    methods: {
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
