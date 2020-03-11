
export default {

    props: ['urls'],
    computed:{
        ajax_url(){
            let ajax_url = this.$store.state.urls.themes;
            return ajax_url;
        }
    },
    components:{
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
        this.getAssets();
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------
        getAssets: function () {
            let assets = this.$store.state.themes.assets;
            if(assets)
            {
                this.assets = assets;
            }else{
                var url = this.ajax_url+"/assets";
                var params = {};
                this.$vaahcms.ajax(url, params, this.getAssetsAfter);
            }
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data) {
            data.type = 'themes';
            this.assets = data;
            this.$store.commit('updateAssets', data);
            this.$vaahcms.stopNprogress();
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}