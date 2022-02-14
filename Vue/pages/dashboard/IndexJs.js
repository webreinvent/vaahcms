import Logo from '../../components/Logo.vue';
import Footer from '../../components/Footer.vue';


export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
        ajax_url() {return this.$store.getters['root/state'].ajax_url},
    },
    components:{
        Logo,
        Footer,
    },
    data()
    {
        return {
            is_btn_loading: false,
            credentials: {
                email: null,
                password: null
            }
        }
    },
    watch: {

    },
    mounted() {

        document.title = "Dashboard";
        //----------------------------------------------------
        this.onLoad();

    },
    methods: {

        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: 'root',
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.getItem();
        },
        //---------------------------------------------------------------------
        getItem: function () {

            let params = {};

            let url = this.ajax_url+'/dashboard/getItem';
            this.$vaah.ajaxGet(url, params, this.getItemAfter);

        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            if(data)
            {
                console.log('--->', data);
                this.update('dashboard_item',data.item);
            }
        },
        //---------------------------------------------------------------------
        signIn: function () {

            this.is_btn_loading = true;
            let params = this.credentials;
            let url = this.ajax_url+'/signin/post';
            this.$vaah.ajax(url, params, this.signInAfter);

        },
        //---------------------------------------------------------------------
        signInAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                console.log('--->', data);
            }
        },
        //---------------------------------------------------------------------
        goToLink: function (link,target = false) {

            if(!link){
                return false;
            }

            if(target){
                window.open(link, '_blank');
            }else{
                window.location.href = link;
            }

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
