<script setup>
import {onMounted, ref} from "vue";
import { useMediaStore } from '../../stores/store-media'
import {useRoute} from 'vue-router';
import { vaah } from "../../vaahvue/pinia/vaah";

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
        <Panel>
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
                    <Button class="p-button-sm"
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

            <div v-if="store.item" class="form">
                    <span class="p-float-label mt-2">
                        <InputText id="name" class="w-full p-inputtext-sm" v-model="store.item.name" />
                        <label for="name">Name</label>
                    </span>

                    <div v-if="!store.item.id" class="field mb-4 relative">
                        <FileUpload v-model="store.item.url"
                                    url="storage/media"
                                    :auto="true"
                                    @click="store.openUploader($event)"
                                    @select="store.upload($event,store.item)"
                                    @remove="store.upload($event,store.item)">
                            <template #empty>
                                <p class="text-center text-sm text-gray-600">Drag and drop files to here to upload.</p>
                            </template>
                        </FileUpload>
                    </div>

                    <span class="p-float-label">
                        <InputText id="title" class="w-full p-inputtext-sm" v-model="store.item.title" />
                        <label for="title">Title</label>
                    </span>

                    <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"
                                   v-model="store.item.alt_text"
                        />

                        <label for="alt-text">Alternate Text</label>
                    </span>

                    <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full" v-model="store.item.caption"></Textarea>
                        <label for="caption">Caption</label>
                    </span>

                    <span class="p-float-label">
                        <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                        <SelectButton
                            v-model="store.item.is_downloadable"
                            :options="store.download_options"
                            option-value="value"
                            option-label="label">
                        </SelectButton>
                    </span>

                    <span class="p-float-label" v-if="store.item.is_downloadable">
                        <span class="p-buttonset">
                            <span class="p-float-label">
                                <InputText id="download_url" class="col-9 p-inputtext-sm"
                                           v-model="store.item.download_url"
                                />

                                <label for="download_url">Download Url</label>

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

                                <Button data-testid="media-copy_download_url"
                                        @click="store.copyDownloadUrl()"
                                        icon="pi pi-copy"
                                        v-tooltip.top=" 'Copy Download Link' "
                                        class="p-button-sm"
                                        :disabled="!store.item.download_url"
                                />
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
