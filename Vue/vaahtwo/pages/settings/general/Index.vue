<script setup>
import { onMounted } from "vue";
import { useRoute } from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah';
import SiteSettings from './components/SiteSettings.vue';
import DateTime from './components/DateTime.vue';

import { useGeneralStore } from "../../../stores/settings/store-general_setting";

const store = useGeneralStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});
</script>
<template>
    <div>
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h5 class="font-semibold text-lg">General Settings</h5>
                    <div>
                        <Button label="Expand all" class="p-button-sm mr-2" @click="store.expandAll"></Button>
                        <Button label="Collapse all" class="p-button-sm" @click="store.collapseAll"></Button>
                    </div>
                </div>
            </template>

            <template #content>
                <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer">
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <div>
                                    <h5 class="font-semibold text-sm">Site Settings</h5>
                                    <p class="text-color-secondary text-xs">After a successful password update, you will be redirected to
                                        the login page where you can log in with your new password.</p>
                                </div>
                            </div>
                        </template>

                        <SiteSettings />
                    </AccordionTab>

                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Date & Time</h5>
                                <p class="text-color-secondary text-xs">Global date and time settings.</p>
                            </div>
                        </template>

                        <DateTime />
                    </AccordionTab>

                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Social Media & Links</h5>
                                <p class="text-color-secondary text-xs">Static links management.</p>
                            </div>
                        </template>

                        <div class="grid">
                            <div class="col-12 md:col-4" v-for="(item,index) in store.social_media_links">
                                <h5 class="p-1 text-xs mb-1">{{ vaah().toLabel(item.label) }}</h5>
                                <div class="p-inputgroup p-fluid">
                                    <span class="p-input-icon-left">
                                        <i :class="item.icon?'pi z-5 '+item.icon:'pi z-5 pi-link'"/>
                                        <InputText type="text"
                                                   :data-testid="'general-'+item.label+'field'"
                                                   v-model="item.value"
                                                   :placeholder="'Enter ' + item.label + ' Link'"
                                                   class="w-full p-inputtext-sm"
                                        />
                                    </span>

                                    <Button icon="pi pi-copy"
                                            data-testid="general-link_copy"
                                            :disabled="!item.id"
                                            @click="store.getCopy(item.key)"
                                            class=" p-button-sm"
                                    />

                                    <Button icon="pi pi-trash"
                                            data-testid="general-link_remove"
                                            @click="store.removeVariable(item)"
                                            class="p-button-danger p-button-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid mt-5">
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <InputText v-model="store.add_link"
                                               data-testid="general-add_link_field"
                                               icon= "pi pi-link"
                                               v-if="store.show_link_input"
                                               class="p-inputtext-sm"
                                    />

                                    <Button label="Add Link"
                                            icon="pi pi-plus"
                                            class="p-button-sm"
                                            data-testid="general-add_link_btn"
                                            :disabled="!store.add_link"
                                            @click="store.addLinkHandler"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-8">
                                <div class="p-inputgroup justify-content-end">
                                    <Button label="Save"
                                            icon="pi pi-save"
                                            data-testid="general-link_save"
                                            @click="store.storeLinks()"
                                            class="p-button-sm"
                                    />
                                </div>
                            </div>
                        </div>
                    </AccordionTab>

                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Scripts</h5>
                                <p class="text-color-secondary text-xs">Add scripts of Google Analytics and other tracking scripts.</p>
                            </div>
                        </template>

                        <div class="grid">
                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 text-xs mb-1">After head tag start (&lt;head&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_after_head_start"
                                              :autoResize="true"
                                              data-testid="general-script_head_start"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_head_start_copy"
                                            @click="store.getCopy('script_after_head_start')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After head tag close (&lt;/head&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_before_head_close"
                                              :autoResize="true"
                                              data-testid="general-script_head_close"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_head_close_copy"
                                            @click="store.getCopy('script_before_head_close')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 text-xs mb-1">After body tag start (&lt;body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_after_body_start"
                                              :autoResize="true"
                                              data-testid="general-script_body_start"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_body_start_copy"
                                            @click="store.getCopy('script_after_body_start')"
                                            class="has-max-height"/>
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After body tag close (&lt;/body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_before_body_close"
                                              :autoResize="true"
                                              data-testid="general-script_body_close"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_body_close_copy"
                                            @click="store.getCopy('script_before_body_close')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid mt-5">
                            <div class="col-12">
                                <div class="p-inputgroup justify-content-end">
                                    <Button label="Save"
                                            icon="pi pi-save"
                                            data-testid="general-script_save"
                                            @click="store.storeScript()"
                                            class="p-button-sm"
                                    />
                                </div>
                            </div>
                        </div>
                    </AccordionTab>

                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Meta Tags</h5>
                                <p class="text-color-secondary text-xs">Global meta tags.</p>
                            </div>
                        </template>

                        <div class="grid">
                            <div class="col-12" v-if="store.meta_tag" v-for="(item,index) in store.meta_tag">
                                <h5 class="p-1 text-xs mb-1">Meta Tag</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="item.value.attribute"
                                              :options="store.assets.vh_meta_attributes"
                                              optionLabel="name"
                                              optionValue="slug"
                                              data-testid="general-metatags_attributes"
                                              placeholder="Select any"
                                    />

                                    <InputText v-model="item.value.attribute_value"
                                               data-testid="general-metatags_attributes_value"
                                               class="p-inputtext-sm"
                                    />
                                    <Button label="Content" disabled="" />
                                    <InputText v-model="item.value.content"
                                               data-testid="general-metatags_attributes_content"></InputText>
                                    <Button icon="pi pi-trash"
                                            data-testid="general-remove_tag"
                                            @click="store.removeMetaTags(item)"/>
                                </div>
                            </div>
                            <div class="col-12 md:col-8">
                                <div class="p-inputgroup">
                                    <Button icon="pi pi-plus"
                                            data-testid="general-add_newtag"
                                            @click="store.addMetaTags"
                                            label="Add Meta Tag"></Button>
                                    <Button label="Save"
                                            @click="store.storeTags"
                                            data-testid="general-meta_tag-save" ></Button>
                                    <Button icon="pi pi-copy"
                                            data-testid="general-meta_tag_copy"
                                            @click="store.getCopy('meta_tags')"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.tag_type"
                                              :options="[
                                                  {name:'Google Webmaster',value:'google-webmaster'},
                                                  {name:'Open Graph (Facebook)',value:'open-graph'},
                                              ]"
                                              data-testid="general-gegnerate_tag"
                                              optionLabel="name"
                                              optionValue="value"
                                              placeholder="Select a type"/>
                                    <Button label="Generate" @click="store.generateTags"></Button>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                </Accordion>
            </template>
        </Card>
    </div>
</template>
