import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import copy from "copy-to-clipboard";

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url+"/backend/vaah/settings/user-setting";

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
    },
    components:{
        ...GlobalComponents,
    },
    data()
    {
        let obj = {
            ajax_url: ajax_url,
            labelPosition: 'on-border',
            assets:null,
            list: [],
            reveal: false,
            reveal_password: false,
            reveal_text: 'Reveal Values',
            is_empty: false,
            has_mobile_cards: true
        };

        return obj;
    },
    watch: {


    },
    mounted() {

        document.title = "User Settings";
        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------

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
            this.getAssets();
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        getAssets: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/assets';
            this.$vaah.ajax(url, params, this.getAssetsAfter);
        },
        //---------------------------------------------------------------------
        getAssetsAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.assets = data;
                this.getList();
            }

        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, params, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.list = data.list;
            }
        },
        //---------------------------------------------------------------------
        store: function (item) {

            this.$Progress.start();

            let params = {
                item : item
            };

            let url = this.ajax_url+'/store';
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        isDisable: function (item) {
            if(item.key == 'APP_KEY'
                || item.key == 'APP_ENV'
                || item.key == 'APP_URL'
            )
            {
                return true;
            }
        },
        //---------------------------------------------------------------------
        copy: function (value)
        {
            copy(value);
            this.$buefy.toast.open({
                message: 'Copied!',
                type: 'is-success'
            });
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        columnTdAttrs(row, column) {

            if (column.label === 'For Permission') {
                return {
                    class: 'is-vcentered',
                    style: {'padding-top': '12px'}
                }
            }

            return {
                class: 'is-vcentered',
            }
        }
        //---------------------------------------------------------------------
    }
}
