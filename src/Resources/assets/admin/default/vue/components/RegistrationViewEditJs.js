import TForm from './reusable/TableFormGenerator';

    export default {

        props: ['urls', 'id'],
        components:{
            't-form': TForm,
        },
        data()
        {
            let obj = {
                assets: null,
                columns: null,
                edit: false
            };

            return obj;
        },
        watch: {

        },
        created() {

        },
        mounted() {

            //---------------------------------------------------------------------
            this.getDetails();
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            getDetails: function () {


                var url = this.urls.current+"/view/"+this.$props.id;

                console.log(url, 'url-->');

                var params = {};
                this.$helpers.ajax(url, params, this.getDetailsAfter);
            },
            //---------------------------------------------------------------------
            getDetailsAfter: function (data) {

                this.columns = data;

                this.$helpers.stopNprogress();

            },
            //---------------------------------------------------------------------
            store: function () {
                var url = this.urls.current+"/assets";
                var params = {};
                this.$helpers.ajax(url, params, this.storeAfter);
            },
            //---------------------------------------------------------------------
            storeAfter: function (data) {

                this.$helpers.stopNprogress();
            },

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }