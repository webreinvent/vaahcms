import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import TableTrView from '../../vaahvue/reusable/TableTrView'
import TableTrActedBy from '../../vaahvue/reusable/TableTrActedBy'
import TableTrStatus from './partials/TableTrStatus'

let namespace = 'permissions';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        item() {return this.$store.getters[namespace+'/state'].active_item},
    },
    components:{
        ...GlobalComponents,
        TableTrView,
        TableTrStatus,
        TableTrActedBy,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_content_loading: false,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.getItem();
        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        this.$root.$on('eReloadItem', this.getItem);
        //----------------------------------------------------
        this.$root.$on('eResetBulkActions', this.resetBulkAction);
        //----------------------------------------------------
        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.is_content_loading = true;

            this.updateView();
            this.getAssets();
            this.getItem();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        getItem: function () {
            this.$Progress.start();
            this.params = {};
            let url = this.ajax_url+'/item/'+this.$route.params.id;
            this.$vaah.ajaxGet(url, this.params, this.getItemAfter);
        },
        //---------------------------------------------------------------------
        getItemAfter: function (data, res) {
            this.$Progress.finish();
            this.is_content_loading = false;

            if(data && data)
            {
                if(data.is_active == 1){
                    data.is_active = 'Yes';
                }else{
                    data.is_active = 'No';
                }
                this.update('active_item', data);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'perm.list'});
            }
        },
        //---------------------------------------------------------------------
        actions: function (action) {

            this.$Progress.start();
            this.page.bulk_action.action = action;
            this.update('bulk_action', this.page.bulk_action);
            let params = {
                inputs: [this.item.id],
                data: null
            };

            let url = this.ajax_url+'/actions/'+this.page.bulk_action.action;
            this.$vaah.ajax(url, params, this.actionsAfter);

        },
        //---------------------------------------------------------------------
        actionsAfter: function (data, res) {
            let action = this.page.bulk_action.action;
            if(data)
            {
                this.resetBulkAction();
                this.$emit('eReloadList');

                if(action == 'bulk-delete')
                {
                    this.$router.push({name: 'perm.list'});
                } else
                {
                    this.getItem();
                }

            } else
            {
                this.$Progress.finish();
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        resetBulkAction: function()
        {
            this.page.bulk_action = {
                selected_items: [],
                data: {},
                action: "",
            };
            this.update('bulk_action', this.page.bulk_action);
        },
        //---------------------------------------------------------------------
        confirmDelete: function()
        {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Deleting record',
                message: 'Are you sure you want to <b>delete</b> the record? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.actions('bulk-delete');
                }
            })
        },
        //---------------------------------------------------------------------
        isCopiable: function (label) {

            if(
                label == 'id' || label == 'uuid' || label == 'slug'
            )
            {
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        isUpperCase: function (label) {

            if(
                label == 'id' || label == 'uuid'
            )
            {
                return true;
            }

            return false;

        },
        //---------------------------------------------------------------------
        resetActiveItem: function () {
            this.update('active_item', null);
            this.$router.push({name:'perm.list'});
        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
    }
}
