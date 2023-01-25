<script setup>
import {onMounted, ref, watch} from "vue";
import { useMediaStore } from '../../stores/store-media'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
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
                    <div class="field mb-4 relative">
                        <FileUpload url="./upload">
                            <template #empty class="absolute">
                                <p class="text-center text-sm text-gray-600">
                                    Drag and drop files to here to upload.
                                </p>
                            </template>
                        </FileUpload>
                        <FileUpload mode="basic"
                                    v-model="store.item.url"
                                    accept="image/*"
                                    :maxFileSize="1000000"
                                    @select="store.upload($event,store.item)"
                                    class="p-button-text"
                                    style="height: 55px;width: 100%;border: 2px dashed #bfbfbf"/>

                    </div>
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
                        option-value="value ? true : false"
                        option-label="label">
                    </SelectButton>
                </div>
            </template>
        </Card>
    </div>
</template>
