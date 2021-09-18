import AutoCompleteParents from './partials/AutoCompleteParents';
// import the component
import TreeSelect from '@riophae/vue-treeselect'
// import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

let namespace = 'taxonomies';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        new_item() {return this.$store.getters[namespace+'/state'].new_item},
        new_item_errors() {return this.$store.getters[namespace+'/state'].new_item_errors},
    },
    components:{
        AutoCompleteParents,
        TreeSelect
    },
    data()
    {
        return {
            namespace: namespace,
            type_parent_id: null,
            isCardModalActive: false,
            is_content_loading: false,
            is_btn_loading: null,
            labelPosition: 'on-border',
            params: {},
            taxo_type: {
                parent_id:null,
                name:null
            },
            country_list: [],
            isFetching: false,
            local_action: null,
            country_name: null
        }
    },
    watch: {
        $route(to, from) {
            this.updateView()
        },
        'new_item.name': {
            deep: true,
            handler(new_val, old_val) {

                if(new_val)
                {
                    this.new_item.slug = this.$vaah.strToSlug(new_val);
                    this.updateNewItem();
                }

            }
        },
        'new_item.vh_taxonomy_type_id': {
            deep: true,
            handler(new_val, old_val) {

                if(!new_val){
                    this.type_parent_id = null;
                    this.new_item.parent = null;
                }

            }
        }
    },
    mounted() {

        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        this.resetActiveItem();
        //----------------------------------------------------
        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
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

            this.updateView();
            this.getAssets();

        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        resetActiveItem: function()
        {
            this.update('active_item', null);
        },
        //---------------------------------------------------------------------
        create: function (action) {
            this.is_btn_loading = true;

            //  this.$Progress.start();

            this.params = {
                new_item: this.new_item,
                action: action
            };

            let url = this.ajax_url+'/create';
            this.$vaah.ajax(url, this.params, this.createAfter);
        },
        //---------------------------------------------------------------------
        createAfter: function (data, res) {
            this.is_btn_loading = false;
            this.$Progress.finish();

            if(data)
            {

                this.$emit('eReloadList');

                if(this.local_action === 'save-and-close')
                {
                    this.saveAndClose()
                }

                if(this.local_action === 'save-and-new')
                {
                    this.saveAndNew()
                }

                if(this.local_action === 'save-and-clone')
                {
                    this.saveAndClone()
                }

            }


        },
        //---------------------------------------------------------------------
        updateNewItem: function()
        {
            this.update('new_item', this.new_item);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        setLocalAction: function (action) {
            this.local_action = action;
            this.create();
        },
        //---------------------------------------------------------------------
        saveAndClose: function () {
            this.update('active_item', null);
            this.resetNewItem();
            this.$router.push({name:'taxonomies.list'});
        },
        //---------------------------------------------------------------------
        saveAndNew: function () {
            this.update('active_item', null);
            this.resetNewItem();
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
            this.$router.push({name:'taxonomies.create'});
        },
        //---------------------------------------------------------------------
        getNewItem: function()
        {
            let new_item = {
                vh_taxonomy_type_id: null,
                parent: null,
                name: null,
                slug: null,
                notes: null,
                is_active: null,
            };
            return new_item;
        },
        //---------------------------------------------------------------------
        resetNewItem: function()
        {
            let new_item = this.getNewItem();
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        fillNewItem: function () {

            let new_item = {
                vh_taxonomy_type_id: null,
                parent: null,
                name: null,
                slug: null,
                notes: null,
                is_active: null,
            };

            for(let key in new_item)
            {
                new_item[key] = this.new_item[key];
            }
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        onSelectType: function(type)
        {
            if(type.parent_id){
                this.type_parent_id = type.parent_id;
            }else{
                this.type_parent_id = null;
                this.new_item.parent = null;
            }
        },
        //---------------------------------------------------------------------
        addType: function()
        {
            this.$Progress.start();

            this.params = this.taxo_type;

            let url = this.ajax_url+'/createTaxonomyType';
            this.$vaah.ajax(url, this.params, this.addTypeAfter);
        },
        //---------------------------------------------------------------------
        addTypeAfter: function(data, res)
        {
            this.$Progress.finish();

            if(res.data.status === 'success'){

                this.$refs.text_view.getList();

                this.taxo_type= {
                    parent_id:null,
                    name:null
                };

                this.update('assets_is_fetching', false);

                this.getAssets();

            }
        },
        //---------------------------------------------------------------------


        //---------------------------------------------------------------------
        normalizer: function (node) {

            let data = {
                label: node.name,
            };

            if(node.children && node.children.length === 0){
                delete node.children;
            }

            return data;
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
