import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import DatePicker from '../../vaahvue/reusable/DatePicker.vue'
import AutoComplete from '../../vaahvue/reusable/AutoComplete.vue'
import FileUploader from '../../vaahvue/reusable/FileUploader.vue'

let namespace = 'media';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        new_item() {return this.$store.getters[namespace+'/state'].new_item},
        new_item_errors() {return this.$store.getters[namespace+'/state'].new_item_errors},
    },
    components:{
        ...GlobalComponents,
        DatePicker,
        'AutoCompleteTimeZone': AutoComplete,
        'AutoCompleteCountry': AutoComplete,
        'MediaUploader': FileUploader,
    },
    data()
    {
        return {
            is_content_loading: false,
            is_btn_loading: null,
            labelPosition: 'on-border',
            params: {},
            local_action: null,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView()
        },
        'new_item.download_url': {
            deep: true,
            handler(new_val, old_val) {
                let slug = this.$vaah.strToSlug(new_val);
                this.new_item.download_url =  slug;
                this.new_item.downloadable_slug_available =  null;
            }
        },

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
            if(!this.hasPermission('can-create-users'))
            {
                this.update('active_item', null);
                this.$router.push({name: 'user.list'});
                this.$vaah.toastErrors(['Permission denied']);
            }
            this.updateView();
            this.getAssets();
        },
        //---------------------------------------------------------------------
        serverConfig: function()
        {
            this.server = {
                url: this.root.assets.urls.upload,
                process:{
                    method: 'POST',
                    timeout: 7000,
                    onload: function (response) {
                        console.log('--->onload', response);
                    },
                    onerror: function (response) {
                        console.log('--->onerror', response);
                    },
                    ondata: function (formData) {
                        console.log('--->formData', formData);
                        return formData;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('#_token').attr('content'),
                        'Upload-Name': 'media'
                    },
                }



            };
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
        isDownloadableSlugAvailable: function () {
            this.$Progress.start();
            this.new_item.downloadable_slug_available = null;
            this.update('new_item', this.new_item);
            let params = {
                download_url: this.new_item.download_url
            };
            let url = this.ajax_url+'/downloadable/slug/available';
            this.$vaah.ajax(url, params, this.isDownloadableSlugAvailableAfter);
        },
        //---------------------------------------------------------------------
        isDownloadableSlugAvailableAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.new_item.downloadable_slug_available = data;
                this.update('new_item', this.new_item);
            }

        },
        //---------------------------------------------------------------------
        create: function (action) {
            this.is_btn_loading = true;

            //  this.$Progress.start();

            this.params = this.new_item;

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
        updateMediaToNewItem: function(media)
        {
            for(let index in media)
            {
                if(index == 'name' && this.new_item[index])
                {
                    continue;
                }
                this.new_item[index] = media[index];
            }

            this.update('new_item', this.new_item);
        },
        //---------------------------------------------------------------------
        updateNewItem: function(media)
        {
            this.update('new_item', this.new_item);
            console.log('--->', this.new_item);
        },
        //---------------------------------------------------------------------
        setLocalAction: function (action) {
            this.local_action = action;
            this.create();
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
        },
        //---------------------------------------------------------------------
        saveAndClone: function () {
            this.fillNewItem();
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
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
