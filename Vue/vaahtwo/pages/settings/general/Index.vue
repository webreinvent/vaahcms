<script setup>
import { onMounted } from "vue";
import { useRoute } from 'vue-router';
import { useGeneralStore } from "../../../stores/settings/store-general_setting";
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah';
import SiteSettings from './components/SiteSettings.vue';
import Securities from './components/Securities.vue';
import DateTime from './components/DateTime.vue';
import SocialMediaLink from './components/SocialMediaLink.vue';
import Script from './components/Scripts.vue';
import MetaTags from './components/MetaTags.vue'

const store = useGeneralStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});
</script>

<template>
    <div>
         <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div>
                        <b class="mr-1">General Settings</b>
                     </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button label="Expand all" icon="pi pi-angle-double-down" class="p-button-sm mr-2"
                            @click="store.expandAll"></Button>
                    <Button label="Collapse all" icon="pi pi-angle-double-up" class="p-button-sm"
                            @click="store.collapseAll"></Button>
                </div>
            </template>

            <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer" class="my-2">
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
                            <h5 class="font-semibold text-sm">Securities</h5>
                            <p class="text-color-secondary text-xs">Enable and choose multiple methods of authentication</p>
                        </div>
                    </template>

                    <Securities />
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

                    <SocialMediaLink />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">Scripts</h5>
                            <p class="text-color-secondary text-xs">Add scripts of Google Analytics and other tracking scripts.</p>
                        </div>
                    </template>

                    <Script />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">Meta Tags</h5>
                            <p class="text-color-secondary text-xs">Global meta tags.</p>
                        </div>
                    </template>

                    <MetaTags />
                </AccordionTab>
            </Accordion>

        </Panel>
    </div>
</template>
