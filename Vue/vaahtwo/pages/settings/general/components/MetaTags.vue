<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";

const store = useGeneralStore();
</script>

<template>
    <div v-if="store && store.assets">
        <div class="grid">
            <div class="col-12" v-if="store.meta_tag" v-for="(item,index) in store.meta_tag">
                <div class="p-1 vaah-type-caption mb-1" :id="'gm-meta-tag-'+index">{{item.label}}</div>

                <InputGroup>
                    <Select :aria-labelledby="'gm-meta-tag-'+index" size="small" v-model="item.value.attribute" :options="store.assets.vh_meta_attributes" optionLabel="name" optionValue="slug" data-testid="general-metatags_attributes" :placeholder="store.assets.language_strings.meta_tag_select_any" inputClass="" class="vc-dense" />

                    <InputText :aria-labelledby="'gm-meta-tag-'+index" size="small" v-model="item.value.attribute_value" data-testid="general-metatags_attributes_value" class="" />

                    <Button label="Content" disabled="" />

                    <InputText :aria-labelledby="'gm-meta-tag-'+index" size="small" v-model="item.value.content" data-testid="general-metatags_attributes_content" class="" />

                    <Button size="small" icon="pi pi-trash" aria-label="Remove meta tag" data-testid="general-remove_tag" @click="store.removeMetaTags(item)" class="" />
                </InputGroup>
            </div>

            <div class="col-12 md:col-8">
                <InputGroup>
                    <Button size="small" icon="pi pi-plus" data-testid="general-add_newtag" @click="store.addMetaTags" :label="store.assets.language_strings.add_meta_tags_button" class="" />

                    <Button size="small" :label="store.assets.language_strings.meta_tag_save_button" @click="store.storeTags" data-testid="general-meta_tag-save" class="" />

                    <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-meta_tag_copy" @click="store.getCopy('meta_tags')" class="" />
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <InputGroup>
                    <Select size="small" v-model="store.tag_type" :options="[ {name:'Google Webmaster',value:'google-webmaster'}, {name:'Open Graph (Facebook)',value:'open-graph'}, ]" data-testid="general-gegnerate_tag" optionLabel="name" optionValue="value" :placeholder="store.assets.language_strings.meta_tag_select_type" inputClass="" class="vc-dense" />

                    <Button size="small" :label="store.assets.language_strings.meta_tag_generate_button" @click="store.generateTags" class="" />
                </InputGroup>
            </div>
        </div>
    </div>
</template>
