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
                    <TieredMenu :model="store.menu_options" ref="menu" :popup="true">
                    </TieredMenu>
                </div>
            </template>
            <template #content>
                <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full" v-model="store.item.name"></InputText>
                        <label for="name">Name</label>
                    </span>
                    <div v-if="!store.item.id" class="field mb-4 relative">
                        <FileUpload mode="basic"
                                    v-model="store.item.url"
                                    accept="image/*"
                                    :maxFileSize="1000000"
                                    @select="store.upload($event,store.item)"
                                    class="p-button-text"
                                    style="height: 55px;width: 100%;border: 2px dashed #bfbfbf"
                                    chooseLabel="Drag and drop files to here to upload."
                                    data-testid="media-table-upload-image"
                                    :customUpload="true"/>

                        <div v-if="store.item.full_url" class="mt-2">
                            <img :src="store.item.full_url" alt=""
                                 style="max-height: 100px;"
                            />
                        </div>

                        <div v-if="store.item.full_url" class="p-inputgroup">
                            <Button class="p-button-tiny p-button-text"
                                    data-testid="media-table-open-image"
                                    v-tooltip.top="'Open Image'"
                                    icon="pi pi-external-link"
                                    value="Open"
                                    url="store.item.full_url"
                                    @click="store.openImage(store.item.full_url)"
                                    target="_blank"/>

                            <Button class="p-button p-button-danger"
                                    data-testid="media-table-remove-image"
                                    label="Remove"
                                    v-tooltip.top="'Remove'"
                                    @click="store.resetItem"
                                    icon="pi pi-trash" />
                        </div>
                    </div>

                    <span class="p-float-label row" v-if="store.item.full_url">
                        <InputText id="title"
                                   class="col-11"
                                   v-model="store.item.original_name"
                                   :disabled="true">
                        </InputText>
                        <label for="title">Uploaded File Name</label>
                        <Button class="p-button p-button-danger col-1"
                                data-testid="media-table-remove-original_name"
                                v-tooltip.top="'Remove'"
                                @click="store.resetItem"
                                icon="pi pi-trash" />
                    </span>

                    <span class="p-float-label">
                        <InputText id="title" class="w-full" v-model="store.item.title"></InputText>
                        <label for="title">Title</label>
                    </span>
                    <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"  v-model="store.item.alt_text"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </span>
                    <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full" v-model="store.item.caption"></Textarea>
                        <label for="caption">Caption</label>
                    </span>
                    <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                    <SelectButton
                        v-model="store.item.is_downloadable"
                        :options="store.download_options"
                        option-value="value"
                        option-label="label">
                    </SelectButton>
                </div>
            </template>
        </Card>
    </div>
</template>
