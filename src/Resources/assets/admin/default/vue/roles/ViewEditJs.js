import TForm from './../reusable/TableFormGenerator';
import TView from './../reusable/TableViewGenerator';
import TableLoader from './../reusable/TableLoader';

    export default {

        props: ['urls', 'id'],
        computed:{
            ajax_url(){
                let ajax_url = this.$store.state.urls.roles;
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
            },

        },
        created() {

        },
        mounted() {

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            this.getDetails();
            //---------------------------------------------------------------------
            this.$root.$on('eUpdateItem', (item) => {
                this.updateItem(item);
            });
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            getDetails: function () {

                var url = this.ajax_url+"/view/"+this.id;
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
            getColumnValue: function(column_name)
            {
                var item = this.$vaahcms.findInArrayByKey(this.columns, 'name', column_name);

                if(!item)
                {
                    return false;
                }

                this.$vaahcms.console(item, 'items');

                return item.value;
            },
            //---------------------------------------------------------------------
            updateItem: function (item) {
                this.item = item;
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
                this.$vaahcms.stopNprogress();
            },

            //---------------------------------------------------------------------
            actions: function (e, action, inputs, data) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.ajax_url+"/actions";
                var params = {
                    action: action,
                    inputs: inputs,
                    data: data,
                };

                this.$vaahcms.ajax(url, params, this.actionsAfter);
            },

            //---------------------------------------------------------------------

            actionsAfter: function (data) {
                this.getDetails();
                this.emitListReload();
            },

            //---------------------------------------------------------------------
            emitListReload: function () {
                this.$root.$emit('eListReload');
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }