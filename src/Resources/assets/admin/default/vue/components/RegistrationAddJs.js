import vhSelect from 'vaah-vue-select'

//https://www.npmjs.com/package/vuejs-datepicker
import Datepicker from 'vuejs-datepicker';

    export default {

        props: ['urls', 'assets'],
        components:{
            'datepicker': Datepicker,
            'vh-select': vhSelect,
        },
        data()
        {
            let obj = {
                new_item: {
                    title: "",
                    country: "",
                    status: "",
                    gender: "",
                    timezone: "",
                    country_calling_code: "",
                    invited_by: "",
                    user_id: "",
                }
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
            store: function () {
                var url = this.urls.current+"/store";
                var params = this.new_item;
                this.$helpers.console(params, '-->');
                this.$helpers.ajax(url, params, this.storeAfter);
            },
            //---------------------------------------------------------------------
            storeAfter: function (data) {

                this.$helpers.console(data);

                this.$helpers.stopNprogress();
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }