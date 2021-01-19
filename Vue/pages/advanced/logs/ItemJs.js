import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'logs';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
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
            namespace: namespace,
            labelPosition: 'on-border',
            item: null,
        };
        return obj;
    },
    watch: {
        $route(to, from) {
            this.item = null;
            this.getItem();
        }
    },
    mounted() {
        //---------------------------------------------------------------------
        this.$root.$on('eReloadItem', this.getItem);
        //---------------------------------------------------------------------
        document.title = "Log";
        //---------------------------------------------------------------------
        this.onLoad();
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
            this.getItem();
        },
        //---------------------------------------------------------------------
        getItem: function () {
            this.$Progress.start();

            if(this.$route.params && this.$route.params.name)
            {
                document.title = "Log - "+this.$route.params.name;
            }

            let params = {};

            let url = this.ajax_url+'/item/'+this.$route.params.name;

            this.$vaah.ajax(url, params, this.getItemAfter);
        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            this.$Progress.finish();
            if(data){

                if(!data.logs){
                    this.$router.push({name: 'logs.list'});
                }

                this.item = data;
            }
        },

        //---------------------------------------------------------------------
        downloadFile: function(file_name)
        {
            window.location.href = this.ajax_url+"/download-file/"+file_name;
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
    }
}
