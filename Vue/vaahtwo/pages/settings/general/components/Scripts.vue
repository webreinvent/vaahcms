<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";

const store = useGeneralStore();
</script>

<template>
    <div v-if="store">
        <div class="grid">
            <div class="col-12 md:col-6 pr-3">
                <h5 class="p-1 text-xs line-height-2">After head tag start (&lt;head&gt;)</h5>

                <div class="p-inputgroup">
                    <Textarea v-model="store.script_tag.script_after_head_start"
                              :autoResize="true"
                              data-testid="general-script_head_start"
                              class="w-full p-inputtext-sm"
                              placeholder="After head tag start (&lt;head&gt;)"
                    />

                    <Button icon="pi pi-copy"
                            data-testid="general-script_head_start_copy"
                            @click="store.getCopy('script_after_head_start')"
                    />
                </div>
            </div>

            <div class="col-12 md:col-6 pl-3">
                <h5 class="p-1 text-xs line-height-2">Before head tag close (&lt;/head&gt;)</h5>

                <div class="p-inputgroup">
                    <Textarea v-model="store.script_tag.script_before_head_close"
                              :autoResize="true"
                              data-testid="general-script_head_close"
                              class="w-full p-inputtext-sm"
                              placeholder="Before head tag close (&lt;/head&gt;)"
                    />

                    <Button icon="pi pi-copy"
                            data-testid="general-script_head_close_copy"
                            @click="store.getCopy('script_before_head_close')"
                    />
                </div>
            </div>

            <div class="col-12 md:col-6 pr-3">
                <h5 class="p-1 text-xs line-height-2">After body tag start (&lt;body&gt;)</h5>
                <div class="p-inputgroup">
                    <Textarea v-model="store.script_tag.script_after_body_start"
                              :autoResize="true"
                              data-testid="general-script_body_start"
                              class="w-full p-inputtext-sm"
                              placeholder="After body tag start (&lt;body&gt;)"
                    />

                    <Button icon="pi pi-copy"
                            data-testid="general-script_body_start_copy"
                            @click="store.getCopy('script_after_body_start')"
                    />
                </div>
            </div>

            <div class="col-12 md:col-6 pl-3">
                <h5 class="p-1 text-xs line-height-2">Before body tag close (&lt;/body&gt;)</h5>

                <div class="p-inputgroup">
                    <Textarea v-model="store.script_tag.script_before_body_close"
                              :autoResize="true"
                              data-testid="general-script_body_close"
                              class="w-full p-inputtext-sm"
                              placeholder="Before body tag close (&lt;/body&gt;)"
                    />

                    <Button icon="pi pi-copy"
                            data-testid="general-script_body_close_copy"
                            @click="store.getCopy('script_before_body_close')"
                    />
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="col-12">
                <Divider class="my-3"/>
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
    </div>
</template>
