import TForm from './reusable/TableFormGenerator';
import TView from './reusable/TableViewGenerator';

    export default {

        props: ['urls', 'id'],
        components:{
            't-form': TForm,
            't-view': TView,
        },
        data()
        {
            let obj = {
                assets: null,
                columns: null,
                edit: false,
                item: null
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
            updateItem: function (item) {
                this.item = item
            },
            //---------------------------------------------------------------------
            toggleEdit: function () {
                if(this.edit === true)
                {
                    this.edit = false;
                } else
                {
                    this.edit = true;
                }
            },
            //---------------------------------------------------------------------
            store: function () {
                var url = this.urls.current+"/assets";
                var params = this.item;
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