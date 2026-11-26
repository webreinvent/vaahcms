<script setup>
import {ref} from 'vue';
import { useMediaStore } from '../../../stores/store-media'
import axios from 'axios';
/**----------------------
 * Props
 */

const upload_refs = ref(null);
const is_media_uploading = ref(false);
const store = useMediaStore();

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
        default: 5000000
    },
    file_type_accept:{
        type: String,
        default: null
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

/**----------------------
 * Methods
 */

/**
 * M6-T1 — the v4 upload path.
 *
 * OpenVue v1's FileUpload has no `uploadHandler` prop: with `customUpload`
 * the component asks the app to perform the upload itself through its
 * `uploader` event (`{files}`), and the `upload` event only fires on the
 * built-in XHR path — which would POST to `url` without the `folder_path`
 * / `file_name` fields and would swallow the response shape the store
 * needs. The v3 code read the component's internals
 * (`upload_refs.value.files`) instead of the event payload; the payload is
 * the documented contract, so the files come from the event now and the
 * pending list is reset through the component's own `clear()`.
 *
 * The axios POST itself is unchanged (D3): same URL, same multipart body,
 * same `store.updateMediaToNewItem()` hand-off.
 */
function uploadFiles(files) {

    if(!files || !files.length){
        return;
    }

    /**
     * Reset the pending list *before* the (async) upload, so the uploader
     * does not keep showing a file that is already on its way. `clear()`
     * also empties the native file input, so the same file can be picked
     * again — the v3 code left the input's value in place, which silently
     * swallowed the second pick of the same file.
     */
    upload_refs.value?.clear();

    files.forEach(async (file) => {
        if(!file){
            return;
        }

        is_media_uploading.value = true;
        let formData = new FormData();
        formData.append("file", file);
        formData.append('folder_path', props.folderPath);
        formData.append('file_name', props.fileName);
        axios.post(props.uploadUrl, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res=>{
            if(res && res.data && res.data.data){
                is_media_uploading.value = false;
                store.updateMediaToNewItem(res.data.data);
            }
        }).catch(()=>{
            /**
             * M6-T1 — the progress bar was only reset on success, so a
             * failed upload (413, 500, a dropped connection) left it
             * spinning for good and the rejection was unhandled. The
             * form shows the failure through the app's own error
             * banner.
             */
            is_media_uploading.value = false;
            store.has_error_on_upload = true;
        });

    })

}

/**
 * `select` is the v4 event that carries the picked files. With
 * `auto_upload` the file goes up as soon as it is picked; without it the
 * app waits for the uploader's own Upload button, which asks for the
 * custom upload through the `uploader` event.
 */
function onFilesSelected(event){
    if(!props.auto_upload){
        return;
    }
    uploadFiles(event && event.files ? event.files : []);
}

function uploadFile(event){
    if(props.auto_upload){
        /**
         * The component already asked for the upload when it auto-selected
         * the file — the `select` event above handled it.
         */
        return;
    }
    uploadFiles(event && event.files ? event.files : []);
}

function removeFile(e){

     // store.item[props.store_label] = null;

}


</script>

<template>
    <ProgressBar v-if="is_media_uploading"
                 mode="indeterminate" style="height: 6px"></ProgressBar>
    <FileUpload name="file"
                :auto="auto_upload"
                ref="upload_refs"
                :mode="is_basic?'basic':'advanced'"
                :multiple="can_select_multiple"
                :customUpload="true"
                :accept="props.file_type_accept"
                @click="store.openUploader($event)"
                @select="onFilesSelected"
                @uploader="uploadFile"
                @remove-uploaded-file="removeFile"
                @clear="removeFile"
                :showUploadButton="!auto_upload"
                :showCancelButton="!auto_upload"
                :maxFileSize="props.max_file_size"
    >
        <template #empty>
            <!-- M6-T1 — the hint was `text-sm text-gray-600`: 12.25px is off
                 the type scale and `text-gray-600` resolves to a primitive
                 palette token, which does not flip in dark mode. It is a
                 13px muted line now. -->
            <p class="media-upload-hint">
                Drag and drop files to here to upload.
            </p>
        </template>
    </FileUpload>


</template>

<style scoped>
.media-upload-hint {
    margin: 0;
    text-align: center;
    font-size: 13px;
    line-height: 1.4;
    color: var(--p-text-muted-color);
}
</style>
