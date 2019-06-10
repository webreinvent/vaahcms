import TForm from './reusable/TableFormGenerator';

    export default {

        props: ['urls', 'assets'],
        components:{
            't-form': TForm,
        },
        data()
        {
            let obj = {
                new_item: null,
            };

            return obj;
        },
        watch: {


        },
        mounted() {

            //---------------------------------------------------------------------
            //this.getAssets();
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------
            updateNewItem: function (item) {
                this.new_item = item;
                this.$helpers.console(this.new_item, 'this.new_item-->updated');
            },
            //---------------------------------------------------------------------
            store: function () {
                var url = this.urls.current+"/store";
                var params = this.new_item;
                this.$helpers.console(params, '-->');
                this.$helpers.ajax(url, params, this.storeAfter);
            },
            //---------------------------------------------------------------------
            storeAfter: function (data) {

                this.$helpers.console(data);

                let id = data.id;

                this.$router.push({ path: `/view/${id}`});

            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }