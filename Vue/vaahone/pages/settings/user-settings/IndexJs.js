import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';
import copy from "copy-to-clipboard";
import draggable from 'vuedraggable';

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
        draggable
    },
    data()
    {
        let obj = {
            ajax_url: ajax_url,
            labelPosition: 'on-border',
            is_btn_loading: false,
            assets:null,
            list: [],
            field_list: [],
            custom_field_list: [],
            reveal: false,
            reveal_password: false,
            reveal_text: 'Reveal Values',
            is_empty: false,
            has_mobile_cards: true,
            field:{
                name:null,
                type:null
            },
            field_type: null
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
            if(data && data.list){
                this.field_list = data.list.fields;

                if(data.list.custom_fields){
                    this.custom_field_list = data.list.custom_fields;
                }else{
                    this.custom_field_list = this.getNewItem();
                }

            }
        },
        //---------------------------------------------------------------------
        storeField: function (item) {

            this.$Progress.start();

            this.is_btn_loading = true;

            let params = {
                item : item
            };

            let url = this.ajax_url+'/field/store';
            this.$vaah.ajax(url, params, this.storeFieldAfter);
        },
        //---------------------------------------------------------------------
        storeFieldAfter: function (data, res) {
            this.getList();
            this.is_btn_loading = false;
            this.$Progress.finish();
        },
        //---------------------------------------------------------------------
        storeCustomField: function () {

            this.$Progress.start();

            this.is_btn_loading = true;

            let params = {
                item : this.custom_field_list
            };

            let url = this.ajax_url+'/custom-field/store';
            this.$vaah.ajax(url, params, this.storeCustomFieldAfter);
        },
        //---------------------------------------------------------------------
        storeCustomFieldAfter: function (data, res) {

            if(res.data.status === 'success'){
                this.getList();
            }

            this.is_btn_loading = false;
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

            if (column.label === 'Apply for Registration') {
                return {
                    class: 'is-vcentered has-text-centered',
                    style: {'padding-top': '12px'}
                }
            }

            return {
                class: 'is-vcentered',
            }
        },
        //---------------------------------------------------------------------
        expandAll: function () {

            $('.collapse-content').each(function (index, item) {
                $(item).slideDown();
            });

        },
        //---------------------------------------------------------------------
        collapseAll: function () {
            $('.collapse-content').each(function (index, item) {
                $(item).slideUp();
            });
        },
        //---------------------------------------------------------------------
        toggleFieldOptions: function (event) {

            let el = event.target;

            console.log('--->', el);

            let target = $(el).closest('.dropzone-field').find('.dropzone-field-options');


            console.log('--->', target);
            target.toggle();

        },
        //---------------------------------------------------------------------
        deleteGroupField: function (index) {
            this.custom_field_list.value.splice(index, 1);
        },
        //---------------------------------------------------------------------
        addCustomField: function () {


            if(!this.field_type){
                this.$vaah.toastErrors(['Select field Type first.']);
                return false;
            }

            let new_item = {
                "name": null,
                "slug": null,
                "type": this.field_type,
                "excerpt": null,
                "is_hidden": false,
                "to_registration": false,
            };

            if(this.field_type === 'textarea'
                || this.field_type === 'text'
                || this.field_type === 'email'){
                new_item.maxlength = null;
                new_item.minlength = null;
            }

            if(this.field_type === 'password'){
                new_item.is_password_reveal = null;
            }

            if(this.field_type === 'number'){
                new_item.min = null;
                new_item.max = null;
            }

            this.custom_field_list.value.push(new_item);
        },
        //---------------------------------------------------------------------
        getNewItem: function () {

            return {
                "id": null,
                "key": null,
                "category": "user_setting",
                "label": "custom_fields",
                "excerpt": null,
                "type": "json",
                "value": []
            };

        },
        //---------------------------------------------------------------------
        onInputFieldName: function (field) {

            field.slug = this.$vaah.strToSlug(field.name,'_');

        },
        //---------------------------------------------------------------------
    }
}
