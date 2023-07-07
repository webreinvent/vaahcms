<script setup>
import {onMounted, ref} from "vue";
import { useMediaStore } from '../../stores/store-media'
import {useRoute} from 'vue-router';
import { vaah } from "../../vaahvue/pinia/vaah";
import FileUploader from "./components/FileUploader.vue";
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'

const store = useMediaStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    store.getFormMenu();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

</script>
<template>
    <div class="col-6">
        <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold text-sm">
                        <span v-if="store.item && store.item.id">
                            {{ store.item.name }}
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>
                </div>
            </template>
            <template #icons>
                <div class="p-inputgroup">
                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            :label=" '#' + store.item.id "
                            data-testid="media-id"
                            @click="useVaah.copy(store.item.id)"
                    />

                    <Button label="Save"
                            v-if="store.item && store.item.id"
                            data-testid="media-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"
                            class="p-button-sm"
                    />

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            data-testid="media-create-and-new"
                            icon="pi pi-save"
                            class="p-button-sm"
                    />

                    <!--form_menu-->
                    <Button v-if="store.hasPermission('can-manage-media') || store.hasPermission('can-update-media')"
                            class="p-button-sm"
                            icon="pi pi-angle-down"
                            type="button"
                            data="media-form-menu"
                            aria-haspopup="true"
                            @click="toggleFormMenu"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button class="p-button-sm"
                            v-if="store.item && store.item.id"
                            icon="pi pi-eye"
                            data-testid="media-to-view"
                            @click="store.toView(store.item)"
                    />

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="media-to-list"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div v-if="store.item" class="form mt-3">

                <VhField label="Name">
                    <InputText class="w-full" v-model="store.item.name" data-testid="media_name" />
                </VhField>


                    <div v-if="!store.item.id" class="field mb-4 relative">
                        <FileUploader placeholder="Upload Avatar"
                                      :is_basic="false"
                                      data-testid="media-form_upload_file"
                                      :auto_upload="true"
                                      :uploadUrl="store.ajax_url + '/upload'" >
                        </FileUploader>
                    </div>

                    <div v-if="!store.item.id &&
                     (store.has_error_on_upload || store.item.url)" class="field mb-4">
                        <div class="p-fileupload-content"><!----><!---->
                            <div v-if="store.has_error_on_upload"  class="p-message p-component p-message-error"
                                 role="alert" aria-live="assertive"
                                 aria-atomic="true">
                                <div class="p-message-wrapper">
                                    <span class="p-message-icon pi pi-times-circle"></span>
                                    <div class="p-message-text">
                                        Invalid file size,
                                        file size should be smaller than 5 MB.
                                    </div>
                                    <button class="p-message-close p-link"
                                            @click="store.has_error_on_upload = false"
                                            aria-label="Close"
                                            type="button">
                                        <i class="p-message-close-icon pi pi-times"></i>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                            <div v-if="store.item.url" class="p-fileupload-file">
                                <img role="presentation"
                                     class="p-fileupload-file-thumbnail mr-2"
                                     :alt="store.item.name"
                                     :src="store.item.type === 'image'?store.item.url:
                                     store.file_image_url"
                                     width="50">
                                <div class="p-fileupload-file-details">
                                    <div class="p-fileupload-file-name">{{ store.item.name }}</div>
                                    <span v-if="store.item.size_for_humans"
                                          class="p-fileupload-file-size">
                                        {{ store.item.size_for_humans }}
                                    </span>
                                </div>
                                <div class="p-fileupload-file-actions">
                                    <button class="p-button p-component p-button-icon-only
                                    p-fileupload-file-remove p-button-text
                                    p-button-danger p-button-rounded"
                                            @click="store.item.url = null"
                                            type="button"><!---->
                                        <span class="pi pi-times p-button-icon"></span>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div><!---->
                        </div>
                    </div>

                <VhField label="Title">
                    <InputText class="w-full"  v-model="store.item.title" data-testid="media_title" />
                </VhField>

                <VhField label="Alternate Text">
                    <InputText class="w-full"  v-model="store.item.alt_text" data-testid="media_alternate_text" />
                </VhField>

                <VhField label="Caption">
                    <InputText class="w-full"  v-model="store.item.caption" data-testid="media_alternate_text" />
                </VhField>
                <VhField label="Caption">
                    <InputText class="w-full"  v-model="store.item.caption" data-testid="media_alternate_text" />
                </VhField>

                <VhField label=" Is this a downloadable media?">
                    <SelectButton
                        v-model="store.item.is_downloadable"
                        :options="store.download_options"
                        option-value="value"
                        option-label="label"
                    />
                </VhField>

                <VhField label="Download Url" v-if="store.item.is_downloadable">


                    <div class="p-inputgroup flex-1">
                        <Button data-testid="media-copy_download_url"
                                @click="store.copyDownloadUrl()"
                                icon="pi pi-copy"
                                v-tooltip.top=" 'Copy Download Link' "
                                class="p-button-sm"
                                :disabled="!store.item.download_url"
                        />
                        <InputText class="w-full p-inputtext-sm border-noround"   v-model="store.item.download_url" data-testid="media_alternate_text" />
                        <Button v-if="store.downloadable_slug_available"
                                data-testid="media-list-check_url_availability"
                                @click="store.isDownloadableSlugAvailable"
                                class="p-button-success p-button-sm"
                                icon="pi pi-check"
                                v-tooltip.top=" 'Download URL Available' "
                        />

                        <Button v-else
                                data-testid="media-list-check_url_availability"
                                @click="store.isDownloadableSlugAvailable"
                                icon="pi pi-question"
                                :disabled="!store.item.download_url"
                                class="p-button-sm"
                                v-tooltip.top=" 'Check Availability' "
                        />
                    </div>
                </VhField>


                <span class="p-float-label" v-if="store.item.is_downloadable">
                        <span class="p-buttonset">
                            <span class="p-float-label">
                                <InputText id="download_url" class="col-9 p-inputtext-sm"
                                           v-model="store.item.download_url"
                                />

                                <label for="download_url">Download Url</label>




                            </span>
                        </span>
                    </span>

                    <span class="p-float-label" v-if="store.item.is_downloadable && store.item.download_url">
                        {{ store.assets.download_url+store.item.download_url }}
                    </span>
                </div>

        </Panel>
    </div>
</template>
