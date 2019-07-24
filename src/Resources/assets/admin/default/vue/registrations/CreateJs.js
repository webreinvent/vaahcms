import TForm from './../reusable/TableFormGenerator';

    export default {

        computed:{
            ajax_url(){
                let ajax_url = this.$store.state.urls.registrations;
                return ajax_url;
            }
        },
        components:{
            't-form': TForm,
        },
        data()
        {
            let obj = {
                assets: null,
                new_item: null,
            };

            return obj;
        },
        watch: {


        },
        mounted() {

            //---------------------------------------------------------------------
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
                let assets = this.$store.state.registrations.assets;
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
                data.type = 'registrations';
                this.assets = data;
                this.$store.commit('updateAssets', data);
                this.$vaahcms.stopNprogress();
            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            updateNewItem: function (item) {
                this.new_item = item;
            },
            //---------------------------------------------------------------------
            store: function () {
                var url = this.ajax_url+"/store";
                var params = this.new_item;
                this.$vaahcms.ajax(url, params, this.storeAfter);
            },
            //---------------------------------------------------------------------
            storeAfter: function (data) {

                let id = data.id;

                this.$router.push({ path: `/registrations/view/${id}`});

                this.$root.$emit('eListReload');

            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }