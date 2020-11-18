import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker'
import AutoComplete from '../../vaahvue/reusable/AutoComplete'

let namespace = 'media';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        item() {return this.$store.getters[namespace+'/state'].active_item},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        return {
            is_content_loading: false,
            is_btn_loading: null,
            labelPosition: 'on-border',
            params: {},
            local_action: null,
            downloadable_slug_available: null,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView()
        },
        'item.download_url': {
            deep: true,
            handler(new_val, old_val) {
                let slug = this.$vaah.strToSlug(new_val);
                this.item.download_url =  slug;
                this.downloadable_slug_available =  null;
            }
        },
        'item.is_downloadable': {
            deep: true,
            handler(new_val, old_val) {

                if(!new_val)
                {
                    this.item.download_url =  '';
                    this.downloadable_slug_available =  null;
                }


            }
        },
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

            if(data && data.item)
            {
                console.log('--->data.item', data);
                this.update('active_item', data.item);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'media.list'});
            }
        },
        //---------------------------------------------------------------------
        isDownloadableSlugAvailable: function () {
            this.$Progress.start();
            this.downloadable_slug_available = null;
            let params = {
                download_url: this.item.download_url
            };
            let url = this.ajax_url+'/downloadable/slug/available';
            this.$vaah.ajax(url, params, this.isDownloadableSlugAvailableAfter);
        },
        //---------------------------------------------------------------------
        isDownloadableSlugAvailableAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.downloadable_slug_available = data;
                this.update('item', this.item);
            }
        },
        //---------------------------------------------------------------------
        updateNewItem: function()
        {
            this.update('item', this.item);
        },
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        store: function () {
            this.$Progress.start();

            let params = this.item;

            console.log('--->params', params);

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
            this.$router.push({name:'media.list'});
        },
        //---------------------------------------------------------------------
        saveAndNew: function () {
            this.update('active_item', null);
            this.resetNewItem();
            this.$router.push({name:'media.create'});
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
            this.update('active_item', null);
            this.$router.push({name:'media.create'});
        },
        //---------------------------------------------------------------------
        getNewItem: function()
        {
            let new_item = {
                uploaded_file_name: null,
                name: null,
                mime_type: null,
                path: null,
                url: null,
                size: null,
                title: null,
                caption: null,
                alt_text: null,
                is_downloadable: false,
                download_url: '',
                download_requires_login: false,
                downloadable_slug_available: null,
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
                uploaded_file_name: null,
                name: null,
                mime_type: null,
                path: null,
                url: null,
                size: null,
                title: null,
                caption: null,
                alt_text: null,
                is_downloadable: false,
                download_url: '',
                download_requires_login: false,
                downloadable_slug_available: null,
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
    }
}
