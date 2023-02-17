<script setup>
import {onMounted, ref} from "vue";
import { useMediaStore } from '../../stores/store-media'
import {useRoute} from 'vue-router';


const store = useMediaStore();
const route = useRoute();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    store.getFormMenu();
    await store.watchItem();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

</script>
<template>
    <div class="col-12 md:col-6">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="font-semibold text-lg">
                        <span v-if="store.item && store.item.id">
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </h5>
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Save"
                                v-if="store.item && store.item.id"
                                data-testid="media-save"
                                @click="store.itemAction('save')"
                                icon="pi pi-save"/>

                        <Button label="Create & New"
                                v-else
                                @click="store.itemAction('create-and-new')"
                                data-testid="media-create-and-new"
                                icon="pi pi-save"/>
                        <!--form_menu-->
                        <Button
                            type="button"
                            @click="toggleFormMenu"
                            data-testid="media-form-menu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"/>

                        <Menu ref="form_menu"
                              :model="store.form_menu_list"
                              :popup="true" />
                        <!--/form_menu-->

                        <Button class="p-button-primary"
                                v-if="store.item && store.item.id"
                                icon="pi pi-eye"
                                data-testid="media-to-view"
                                @click="store.toView(store.item)">
                        </Button>

                        <Button class="p-button-primary"
                                icon="pi pi-times"
                                data-testid="media-to-list"
                                @click="store.toList()">
                        </Button>
                    </div>
                    <TieredMenu :model="store.form_menu_list" ref="menu" :popup="true">
                    </TieredMenu>
                </div>
            </template>
            <template #content>
                <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full p-inputtext-sm" v-model="store.item.name" />
                        <label for="name">Name</label>
                    </span>
                    <div v-if="!store.item.id" class="field mb-4 relative">
                        <FileUpload v-model="store.item.url"
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
                                <InputText id="download_url" class="col-10 p-inputtext-sm"
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
                                        class="p-button-sm"
                                        v-tooltip.top=" 'Check Availability' "
                                />

                                <Button data-testid="media-copy_download_url"
                                        @click="store.copyDownloadUrl()"
                                        icon="pi pi-copy"
                                        v-tooltip.top=" 'Copy Download Link' "
                                        class="p-button-sm"
                                />
                            </span>
                        </span>
                    </span>

                    <span class="p-float-label" v-if="store.item.is_downloadable">
                        {{ store.assets.download_url+store.item.download_url }}
                    </span>
                </div>
            </template>
        </Card>
    </div>
</template>
