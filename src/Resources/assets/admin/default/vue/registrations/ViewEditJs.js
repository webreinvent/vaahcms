import TForm from './../reusable/TableFormGenerator';
import TView from './../reusable/TableViewGenerator';
import TableLoader from './../reusable/TableLoader';

    export default {

        props: ['urls', 'id'],
        computed:{
            ajax_url(){
                let ajax_url = this.$store.state.urls.registrations;
                return ajax_url;
            }
        },
        components:{
            't-form': TForm,
            't-view': TView,
            't-loader': TableLoader,
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

            id: function (newVal, oldVal) {
                this.getDetails();
            }

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
                this.columns = null;

                var url = this.ajax_url+"/view/"+this.id;

                console.log(url, 'url-->');

                var params = {};
                this.$vaahcms.ajax(url, params, this.getDetailsAfter);
            },
            //---------------------------------------------------------------------
            getDetailsAfter: function (data) {
                this.columns = null;
                this.columns = data;
                this.$vaahcms.stopNprogress();
            },
            //---------------------------------------------------------------------
            updateItem: function (item) {
                this.item = item;

                this.$vaahcms.console(this.item, 'this.item');

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
                var url = this.ajax_url+"/store";
                var params = this.item;

                this.$vaahcms.console(params, 'params');

                this.$vaahcms.ajax(url, params, this.storeAfter);
            },
            //---------------------------------------------------------------------
            storeAfter: function (data) {

                this.edit = false;
                this.item = data;
                this.$root.$emit('eListReload');
            },

            //---------------------------------------------------------------------
            getColumnValue: function(column_name)
            {
                var item = this.$vaahcms.findInArrayByKey(this.columns, 'name', column_name);

                if(!item)
                {
                    return false;
                }
                return item.value;
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }