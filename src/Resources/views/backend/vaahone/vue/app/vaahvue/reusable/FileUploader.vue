<template>

    <div v-if="root_assets">
        <file-pond
            :name="file_name"
            :ref="uid"
            :id="uid"
            :class-name="custom_class"
            :label-idle="label"
            :allow-multiple="allow_multiple"
            allowImageEdit="true"
            allowImageCrop="true"
            :imageCropAspectRatio="aspect_ratio"
            :accepted-file-types="allowed_types"
            :server="server"
            :onprocessfile="onFileProcessed"
            v-bind:files="files"
            v-on:init="handleFilePondInit()"/>
        <p class="help">Maximum size allowed is {{max_size}}MB. File Types: {{allowed_types}}</p>
    </div>


</template>

<script>
import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default {
    props: {
        upload_url: {
            type: String,
            default: null
        },
        folder_path: {
            type: String,
            default: 'public/media'
        },
        file_name: {
            type: String,
            default: 'file'
        },
        uid: {
            type: String,
            default: function () {
                return 'uid'+Date.now();
            }
        },
        custom_class: {
            type: String,
            default: function () {
                return 'file_uploader';
            }
        },
        label: {
            type: String,
            default: function () {
                return 'Drop your files here or click to upload.';
            }
        },
        icon: {
            type: String,
            default: "search"
        },
        aspect_ratio: {
            type: String,
            default: null
        },
        allow_multiple: {
            type: Boolean,
            default: false
        },
        allowed_types: {
            type: String,
            default: 'image/jpeg, image/png'
        },
        max_size: {
            type: Number,
            default: 2
        },

    },
    computed:{
        root_assets() {return this.$store.getters['root/state'].assets},
    },
    components:{

    },
    data()
    {
        let obj = {
            server: {},
            url: null,
            pond: null,
            files: []
        };

        return obj;
    },
    created() {
    },
    mounted(){

        this.onLoad();

    },
    watch: {

    },
    methods: {

        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.serverConfig();
        },
        //---------------------------------------------------------------------
        serverConfig: function()
        {

            if(this.upload_url)
            {
                this.url = this.upload_url;
            } else
            {
                this.url =  this.root_assets.urls.upload;
            }

            self = this;

            this.server = {
                url: this.url,
                process:{
                    method: 'POST',
                    timeout: 7000,
                    onload: function (data) {
                        data = JSON.parse(data);
                        if(data && data.data)
                        {
                            self.afterUpload(data.data);
                        }
                        let res = {
                            data: data
                        };
                        Vaah.processResponse(res);
                    },
                    onerror: function (error) {
                        Vaah.processError(error);
                    },
                    ondata: function (formData) {
                        formData.append('folder_path', self.folder_path);
                        formData.append('file_name', self.file_name);
                        return formData;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('#_token').attr('content')
                    },
                }
            };
        },
        //---------------------------------------------------------------------
        handleFilePondInit: function () {
            this.pond = this.$refs[this.uid];
        },
        //---------------------------------------------------------------------
        afterUpload: function (data) {
            this.$emit('afterUpload', data);
        },
        //---------------------------------------------------------------------
        onFileProcessed: function (error, file) {
            if(!error)
            {
                this.pond.removeFile(file.id);
            }
        }
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
</script>

