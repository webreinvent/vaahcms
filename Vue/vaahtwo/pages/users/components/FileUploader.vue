<script setup>
import {reactive, ref, watch } from 'vue';
import {vaah} from '../../../vaahvue/pinia/vaah'
import { useUserStore } from '../../../stores/store-users'
import axios from 'axios';
/**----------------------
 * Props
 */

const upload_refs = ref([])
const store = useUserStore();

const temp_setter = ref(store.reset_uploader);

const props = defineProps({
    uploadUrl: {
        type: String,
        required: true
    },
    folderPath: {
        type: String,
        default: 'public/media'
    },
    fileName: {
        type: String,
        default: null
    },
    maxFileSize:{
        type: Number,
        default: 1000000
    },
    file_limit:{
        type: Number,
        default: 5
    },
    can_select_multiple:{
        type: Boolean,
        default: false
    },
    is_basic:{
        type: Boolean,
        default: false
    },
    auto_upload:{
        type: Boolean,
        default: false
    },
    max_file_size:{
        type: Number,
        default: 1000000
    },
    file_type_accept:{
        type: String,
        default: 'image/*'
    },
    placeholder:{
        type: String,
        default: 'Upload Image'
    },
    store_label:{
        type: String,
        default: 'avatar'
    }
});


// watch(store.reset_uploader, async (new_val, old_val) => {
//     console.log('watch',new_val);
//     upload_refs.value.files = [];
//     upload_refs.value.uploadedFiles = [];
// })

/**----------------------
 * Data
 */
let files = reactive([]);
const emit = defineEmits();
/**----------------------
 * Methods
 */
function uploadFile(e){

    let uploaded_files = upload_refs.value.files;

    upload_refs.value.files = [];

    uploaded_files.forEach(async (file) => {
        let formData = new FormData();
        formData.append("file", file);
        formData.append('folder_path', props.folderPath);
        formData.append('file_name', props.fileName);
        axios.post(props.uploadUrl, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res=>{
            upload_refs.value.uploadedFiles[0] = file;
            store.storeAvatar(res.data.data);
        });
    })

}
function removeFile(e){

     // store.item[props.store_label] = null;

}

function selectFile (data){

    let temp_file = upload_refs.value.files[upload_refs.value.files.length-1];
    // store.item[props.store_label] = null;
    upload_refs.value.files = [];
    upload_refs.value.uploadedFiles = [];
    upload_refs.value.files[0] = temp_file;

}


</script>

<template>
    <FileUpload name="file"
                :auto="auto_upload"
                :accept="file_type_accept"
                ref="upload_refs"
                :mode="is_basic?'basic':'advanced'"
                :multiple="can_select_multiple"
                :customUpload="true"
                @select="selectFile"
                @uploader="uploadFile"
                @removeUploadedFile="removeFile"
                @clear="removeFile"
                :showUploadButton="!auto_upload"
                :showCancelButton="!auto_upload"
                :maxFileSize="max_file_size" >
        <template #empty>
            <div class="flex align-items-center justify-content-center flex-column">
                <p>{{ placeholder }}</p>
            </div>
        </template>
    </FileUpload>
</template>

