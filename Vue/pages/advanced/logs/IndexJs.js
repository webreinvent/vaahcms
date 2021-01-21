import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'logs';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        item() {return this.$store.getters[namespace+'/state'].active_item},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        let obj = {
            namespace: namespace,
            is_list_fetched: null,
            given_extension: ['.log','.csv','.xml','.pdf','.xlsx'],
            tags: [],
            allow_new: true,
            open_on_focus: true,
            search_delay: null,
            search_delay_time: 800,
        };
        return obj;
    },
    watch: {
    },
    mounted() {
        //---------------------------------------------------------------------
        document.title = "Logs";
        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    },
    methods: {
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
            this.getList();
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$Progress.start();
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, this.query_string, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.is_list_fetched = true;
                if(data.list && data.list.length > 0)
                {
                    this.update('list_is_empty', false);
                } else
                {
                    this.update('list_is_empty', true);
                }

                this.update('list', data.list);
            }

        },
        //---------------------------------------------------------------------
        setRowClass: function(row, index)
        {

            if(this.page.active_item && row.name == this.page.active_item.name)
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
            this.update('active_item', item);
            this.$router.push({name: 'logs.details', params:{name:item.name}})
        },
        //---------------------------------------------------------------------
        changeStatus: function (id) {
            this.$Progress.start();
            let url = this.ajax_url+'/actions/bulk-change-status';
            let params = {
                inputs: [id],
                data: null
            };
            this.$vaah.ajax(url, params, this.changeStatusAfter);
        },
        //---------------------------------------------------------------------
        changeStatusAfter: function (data,res) {
            this.$emit('eReloadList');
            this.update('is_list_loading', false);

        },

        //---------------------------------------------------------------------
        copiedData: function (data) {

            this.$vaah.toastSuccess(['copied']);

            // alertify.success('copied');

            this.$vaah.console(data, 'copied data');

        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        deleteAllItem: function () {


            let params = {};

            let url = this.ajax_url+'/actions/bulk-delete-all';

            let self = this;

            this.$buefy.dialog.confirm({
                title: 'Deleting record',
                message: 'Are you sure you want to <b>delete</b> all the record? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.$Progress.start();

                    self.$vaah.ajax(url, params, self.deleteAllItemAfter);
                }
            });

        },
        //---------------------------------------------------------------------
        deleteAllItemAfter: function (data, res) {

            if(data && data.message === 'success'){
                this.getList();
                if(this.item){
                    this.$root.$emit('eReloadItem');
                }
            }

            },
        //---------------------------------------------------------------------
        deleteItem: function (item) {

            let url = this.ajax_url+'/actions/bulk-delete';

            let self = this;

            this.$buefy.dialog.confirm({
                title: 'Deleting record',
                message: 'Are you sure you want to <b>delete</b> the record? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.$Progress.start();

                    self.$vaah.ajax(url, item, self.deleteItemAfter);
                }
            });



        },
        //---------------------------------------------------------------------
        deleteItemAfter: function (data, res) {

            if(data && data.message === 'success'){
                this.getList();
                if(this.item){
                    this.$root.$emit('eReloadItem');
                }
            }
            },
        //---------------------------------------------------------------------
        delayedSearch: function()
        {
            let self = this;
            clearTimeout(this.search_delay);
            this.search_delay = setTimeout(function() {
                self.getList();
            }, this.search_delay_time);

            this.query_string.page = 1;
            this.update('query_string', this.query_string);

        },

        //---------------------------------------------------------------------
        onReload: function()
        {
            this.getList();

            this.$root.$emit('eReloadItem');
        },

        //---------------------------------------------------------------------
        downloadFile: function(file_name)
        {
            window.location.href = this.ajax_url+"/download-file/"+file_name;
        },


        //---------------------------------------------------------------------
        clearSearch: function()
        {
            this.query_string.q = null;

            this.update('query_string',this.query_string);

            this.getList();
        },
        //---------------------------------------------------------------------
        setFilter: function(text)
        {
            if(text && text.length > 0 && text[text.length-1].charAt(0) !== '.'){
                let ext = text[text.length-1];
                this.query_string.file_type.pop();
                this.query_string.file_type.push('.'+ext);
            }
            this.getList();
        },
    }
}
