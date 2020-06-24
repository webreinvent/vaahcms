import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url+"/backend/vaah/settings/env";

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
            env_file: null,
            list: [],
            reveal: false,
            reveal_password: false,
            reveal_text: 'Reveal Values',
        };

        return obj;
    },
    watch: {


    },
    mounted() {


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
                this.env_file = data.env_file;
            }
        },
        //---------------------------------------------------------------------
        toggleReveal: function () {
            if(this.reveal_password == false)
            {
                this.reveal = true;
                this.reveal_text = 'Hide Values';
                this.reveal_password = true;
            } else
            {
                this.reveal = false;
                this.reveal_text = 'Reveal Values';
                this.reveal_password = false;
            }
        },
        //---------------------------------------------------------------------
        addVariable: function () {
            let item = this.emptyItem();
            this.list.push(item);
        },
        //---------------------------------------------------------------------
        emptyItem: function () {

            let count = this.list.length;

            let item = {
                uid: count,
                key: 'VARIABLE_NAME_'+count,
                value: null,
            };

            return item;

        },
        //---------------------------------------------------------------------
        removeVariable: function (item) {

            if(item.uid)
            {
                this.list = this.$vaah.removeInArrayByKey(this.list, item, 'uid');
            } else
            {
                this.list = this.$vaah.removeInArrayByKey(this.list, item, 'key');
            }
        },

        //---------------------------------------------------------------------
        generateKeyPair: function()
        {
            let pair = [];
            this.list.forEach(function (item) {

                pair[item.key] = item.value;

            });

            return pair;
        },
        //---------------------------------------------------------------------
        validate: function()
        {
            let pair = this.generateKeyPair();

            let failed = false;
            let messages = [];

            if(!pair['APP_KEY']) {
                messages.push("APP_KEY is required");
                failed = true;
            }

            if(!pair['APP_ENV']) {
                messages.push("APP_ENV is required");
                failed = true;
            }

            if(!pair['APP_URL']) {
                messages.push("APP_URL is required");
                failed = true;
            }

            if(failed)
            {
                this.$vaah.toastErrors(messages);
                return false;
            }


            return true;
        },
        //---------------------------------------------------------------------
        confirmChanges: function()
        {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Updating environment variables',
                message: 'Invalid value(s) can break the application, are you sure to proceed?. You will be <b>logout</b> and redirected to login page.',
                confirmText: 'Proceed',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.store();
                }
            })
        },
        //---------------------------------------------------------------------
        store: function () {

            let valid = this.validate();

            if(!valid)
            {
                return false;
            }

            this.$Progress.start();

            let params = this.list;

            let url = this.ajax_url+'/store';
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {
            this.$Progress.finish();
            if(data)
            {
                window.location.href = data.redirect_url;
            }
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
        isSecrete: function(item)
        {
            if(
                item.key == 'APP_KEY'
                || item.key.includes('SECRET')
                || item.key.includes('API_KEY')
                || item.key.includes('API')
                || item.key.includes('AUTH_KEY')
                || item.key.includes('PRIVATE_KEY')
                || item.key.includes('MERCHANT_KEY')
                || item.key.includes('SALT')
                || item.key.includes('AUTH_TOKEN')
                || item.key.includes('API_TOKEN')
            ){
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        inputType: function (item) {

            if(item.key.includes('PASSWORD'))
            {
                return 'password';
            }


            if(this.isSecrete(item))
            {
                return 'password';
            }


            return 'text';
        },
        //---------------------------------------------------------------------
        showRevealButton: function (item) {

            if(item.key.includes('PASSWORD'))
            {
                return true;
            }

            if(this.isSecrete(item))
            {
                return true;
            }

            return false;
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
    }
}
