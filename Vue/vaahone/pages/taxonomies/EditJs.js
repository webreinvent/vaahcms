let namespace = 'taxonomies';
import AutoCompleteParents from './partials/AutoCompleteParents';
// import the component
import TreeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
    props: ['id'],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        item() {return this.$store.getters[namespace+'/state'].active_item},
    },
    components:{
        AutoCompleteParents,
        TreeSelect,
    },
    data()
    {
        return {
            namespace: namespace,
            is_content_loading: false,
            is_type_modal_active: false,
            is_btn_loading: null,
            type_parent_id: null,
            labelPosition: 'on-border',
            params: {},
            local_action: null,
            title: null,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView()
        },
        id(new_val, old_val) {

            if(new_val && new_val != old_val){
                this.getItem();
            }

        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
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
        updateItem: function()
        {
            this.update('active_item', this.item);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.is_content_loading = true;

            if(this.item){
                this.title = this.item.name;

                if(this.item.parent){
                    this.type_parent_id = this.item.parent.id;
                }
            }

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

            if(data)
            {
                this.title = data.name;

                if(data.type){
                    this.type_parent_id = data.type.parent_id;
                }

                this.update('active_item', data);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'taxonomies.list'});
            }
        },
        //---------------------------------------------------------------------
        store: function () {
            this.$Progress.start();

            let params = {
                item: this.item,
            };

            let url = this.ajax_url+'/store/'+this.item.id;
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {

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
        setLocalAction: function (action) {
            this.local_action = action;
            this.store();
        },
        //---------------------------------------------------------------------
        saveAndClose: function () {
            this.update('active_item', null);
            this.$router.push({name:'taxonomies.list'});
        },
        //---------------------------------------------------------------------
        saveAndNew: function () {
            this.update('active_item', null);
            this.resetNewItem();
            this.$router.push({name:'taxonomies.create'});
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
            this.update('active_item', null);
            this.$router.push({name:'taxonomies.create'});
        },
        //---------------------------------------------------------------------
        getNewItem: function()
        {
            let new_item = {
                name: null,
                slug: null,
                is_active: null,
                details: null,
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
                name: null,
                slug: null,
                is_active: null,
                details: null,
            };

            for(let key in new_item)
            {
                new_item[key] = this.item[key];
            }
            this.update('new_item', new_item);
        },
        //---------------------------------------------------------------------
        onInputName: function (name) {

            if(name)
            {
                this.item.slug = this.$vaah.strToSlug(name);
                this.updateItem();
            }
        },

        //---------------------------------------------------------------------
        onSelectType: function(type)
        {
            this.item.parent = null;
            if(type.parent_id){
                this.type_parent_id = type.parent_id;
            }else{
                this.type_parent_id = null;

            }
        },

        //---------------------------------------------------------------------
        onInput: function(n)
        {
            this.type_parent_id = null;
            this.item.parent = null;

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
        resetActiveItem: function () {
            this.update('active_item', null);
            this.$router.push({name:'taxonomies.list'});
        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
    }
}
