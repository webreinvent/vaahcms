<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";

const store = useGeneralStore();
</script>

<template>
    <div v-if="store && store.assets">
        <div class="grid">
            <div class="col-12 md:col-6 pr-3">
                <div class="p-1 vaah-type-caption mb-1" id="gsc-after-head-tag-start">{{ store.assets.language_strings.after_head_tag_start }}</div>

                <InputGroup>
                    <Textarea aria-labelledby="gsc-after-head-tag-start" v-model="store.script_tag.script_after_head_start"
                              :autoResize="true"
                              data-testid="general-script_head_start"
                              class="w-full"
                    />

                    <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                            data-testid="general-script_head_start_copy"
                            @click="store.getCopy('script_after_head_start')"
                    />
                </InputGroup>
            </div>

            <div class="col-12 md:col-6 pl-3">
                <div class="p-1 vaah-type-caption mb-1" id="gsc-before-head-tag-close">{{ store.assets.language_strings.before_head_tag_close }}</div>

                <InputGroup>
                    <Textarea aria-labelledby="gsc-before-head-tag-close" v-model="store.script_tag.script_before_head_close"
                              :autoResize="true"
                              data-testid="general-script_head_close"
                              class="w-full"
                    />

                    <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                            data-testid="general-script_head_close_copy"
                            @click="store.getCopy('script_before_head_close')"
                    />
                </InputGroup>
            </div>

            <div class="col-12 md:col-6 pr-3">
                <div class="p-1 vaah-type-caption mb-1" id="gsc-after-body-tag-start">{{ store.assets.language_strings.after_body_tag_start }}</div>
                <InputGroup>
                    <Textarea aria-labelledby="gsc-after-body-tag-start" v-model="store.script_tag.script_after_body_start"
                              :autoResize="true"
                              data-testid="general-script_body_start"
                              class="w-full"
                    />

                    <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                            data-testid="general-script_body_start_copy"
                            @click="store.getCopy('script_after_body_start')"
                    />
                </InputGroup>
            </div>

            <div class="col-12 md:col-6 pl-3">
                <div class="p-1 vaah-type-caption mb-1" id="gsc-before-body-tag-close">{{ store.assets.language_strings.before_body_tag_close }}</div>

                <InputGroup>
                    <Textarea aria-labelledby="gsc-before-body-tag-close" v-model="store.script_tag.script_before_body_close"
                              :autoResize="true"
                              data-testid="general-script_body_close"
                              class="w-full"
                    />

                    <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                            data-testid="general-script_body_close_copy"
                            @click="store.getCopy('script_before_body_close')"
                    />
                </InputGroup>
            </div>
        </div>

        <div class="grid">
            <div class="col-12">
                <Divider class="my-3"/>
                <InputGroup class="justify-content-end">
                    <Button size="small" :label="store.assets.language_strings.scripts_save_button" icon="pi pi-save" data-testid="general-script_save" @click="store.storeScript()" class="" />
                </InputGroup>
            </div>
        </div>
    </div>
</template>
