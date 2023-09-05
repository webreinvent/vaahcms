<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";

const store = useGeneralStore();
</script>

<template>
    <div v-if="store">
        <div class="grid">
            <div class="col-12" v-if="store.meta_tag" v-for="(item,index) in store.meta_tag">
                <h5 class="p-1 text-xs mb-1">{{item.label}}</h5>

                <div class="p-inputgroup">
                    <Dropdown v-model="item.value.attribute"
                              :options="store.assets.vh_meta_attributes"
                              optionLabel="name"
                              optionValue="slug"
                              data-testid="general-metatags_attributes"
                              placeholder="Select any"
                              inputClass="p-inputtext-sm"
                              class="is-small"
                    />

                    <InputText v-model="item.value.attribute_value"
                               data-testid="general-metatags_attributes_value"
                               class="p-inputtext-sm"
                    />

                    <Button label="Content" disabled="" />

                    <InputText v-model="item.value.content"
                               data-testid="general-metatags_attributes_content"
                               class="p-inputtext-sm"
                    />

                    <Button icon="pi pi-trash"
                            data-testid="general-remove_tag"
                            @click="store.removeMetaTags(item)"
                            class="p-button-sm"
                    />
                </div>
            </div>

            <div class="col-12 md:col-8">
                <div class="p-inputgroup">
                    <Button icon="pi pi-plus"
                            data-testid="general-add_newtag"
                            @click="store.addMetaTags"
                            label="Add Meta Tag"
                            class="p-button-sm"
                    />

                    <Button label="Save"
                            @click="store.storeTags"
                            data-testid="general-meta_tag-save"
                            class="p-button-sm"
                    />

                    <Button icon="pi pi-copy"
                            data-testid="general-meta_tag_copy"
                            @click="store.getCopy('meta_tags')"
                            class="p-button-sm"
                    />
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
                              placeholder="Select a type"
                              inputClass="p-inputtext-sm"
                              class="is-small"
                    />

                    <Button label="Generate"
                            @click="store.generateTags"
                            class="p-button-sm"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
