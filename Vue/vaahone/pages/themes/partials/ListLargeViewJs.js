import Tags from './Tags';

let namespace = 'themes';
export default {
    computed: {
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        Tags,
    },

    data()
    {
        let obj = {

            namespace: namespace

        };

        return obj;
    },
    created() {
    },
    mounted(){

    },

    watch: {

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
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        async getRootAssets() {
            await this.$store.dispatch('root/reloadAssets');
        },
        //---------------------------------------------------------------------
        setRowClass: function(row, index)
        {

            if(this.page.active_item && row.id == this.page.active_item.id)
            {
                return 'is-selected';
            }

            if(row.deleted_at != null)
            {
                return 'is-danger';
            }

        },
        //---------------------------------------------------------------------
        setActiveItem: function (item) {
            this.update('list_view_class', 'is-8');
            this.update('active_item', item);
            this.$router.push({name: 'themes.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------

        confirmDelete: function (theme) {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Deleting Theme',
                message: 'This will <b>delete</b> all files & database of the theme  <b>'+theme.name+'</b>. This action cannot be undone.',
                confirmText: 'Proceed',
                type: 'is-danger',
                container: '.bulma',
                hasIcon: true,
                onConfirm: function () {
                    self.delete(theme);
                }
            })
        },
        //---------------------------------------------------------------------
        delete: function (theme) {
            this.$Progress.start();
            let params = {
                action: 'delete',
                inputs: theme
            };

            if(this.page.active_item && this.page.active_item.id === theme.id
                && this.$router.name === 'theme.view'
            )
            {
                this.update('active_item', null);
                this.$router.push({name: 'theme.list'});
            }

            let url = this.ajax_url+'/actions';
            this.$vaah.ajax(url, params, this.deleteAfter);
        },
        //---------------------------------------------------------------------
        deleteAfter: function (data, res) {
            this.$Progress.finish();
            if(data)
            {
                this.update('assets_is_fetching', false);
                this.getAssets();
                this.getRootAssets();
                this.$emit('eReloadList');
            }
        },
        //---------------------------------------------------------------------
        actions: function (action, theme) {
            this.$Progress.start();
            this.update('selected_item', theme);
            let params = {
                action: action,
                inputs: theme
            };
            let url = this.ajax_url+'/actions';
            this.$vaah.ajax(url, params, this.actionsAfter);
        },
        //---------------------------------------------------------------------
        actionsAfter: function (data, res) {

            if(data)
            {
                this.update('selected_item', null);
                this.getRootAssets();
                this.$emit('eReloadList');
            }

        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        confirmDataImport: function (theme) {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Importing Sample Data',
                message: 'This will <b>import</b> sample/dummy data of the theme <b>'+theme.name+'</b>. This action cannot be undone.',
                confirmText: 'Proceed',
                type: 'is-warning',
                container: '.bulma',
                hasIcon: true,
                onConfirm: function () {
                    self.importSampleData(theme);
                }
            })
        },
        //---------------------------------------------------------------------
        importSampleData: function (theme) {
            this.$Progress.start();
            let params = {
                action: 'import_sample_data',
                inputs: theme
            };
            let url = this.ajax_url+'/actions';
            this.$vaah.ajax(url, params, this.importSampleDataAfter);
        },
        //---------------------------------------------------------------------
        importSampleDataAfter: function (data, res) {
            this.$Progress.finish();
            if(data)
            {
                this.$emit('eReloadList');
            }

        },
        //---------------------------------------------------------------------
        confirmUpdate: function(theme)
        {
            let self = this;
            this.$buefy.dialog.confirm({
                title: 'Updating theme',
                message: 'It is recommended to create a backup before this action. This will <b>download</b> the updates for theme <b>'+theme.name+'</b>. This action cannot be undone.',
                confirmText: 'Proceed',
                type: 'is-info',
                container: '.bulma',
                hasIcon: true,
                onConfirm: function () {
                    self.getThemeDetails(theme);
                }
            })
        },
        //---------------------------------------------------------------------
        getThemeDetails: function (theme) {
            this.$Progress.start();
            let params = {};
            let url = this.assets.vaahcms_api_route+'theme/by/slug/'+theme.slug;
            this.$vaah.ajaxGet(url, params, this.getThemeDetailsAfter);
        },
        //---------------------------------------------------------------------
        getThemeDetailsAfter: function (data, res) {

            if(data)
            {
                this.update('selected_item', data);
                this.installUpdate();
            }
        },
        //---------------------------------------------------------------------
        installUpdate: function () {
            let params = this.page.selected_item;
            let url = this.ajax_url+'/install/updates';
            this.$vaah.ajax(url, params, this.installUpdateAfter);
        },
        //---------------------------------------------------------------------
        installUpdateAfter: function (data, res) {
            this.$Progress.finish();
            if(data)
            {
                this.update('selected_item', null);
                this.$emit('eReloadList');
            }

        },
        //---------------------------------------------------------------------
    }
}
