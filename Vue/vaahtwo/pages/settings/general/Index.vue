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
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
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
                        <b class="mr-1">{{root.assets.language_string.general_settings.heading}}</b>
                     </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button :label="root.assets.language_string.general_settings.expand_all"
                            icon="pi pi-angle-double-down" class="p-button-sm mr-2"
                            @click="store.expandAll"></Button>
                    <Button :label="root.assets.language_string.general_settings.collapse_all"
                            icon="pi pi-angle-double-up" class="p-button-sm"
                            @click="store.collapseAll"></Button>
                </div>
            </template>

            <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer" class="my-2">
                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <div>
                                <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.site_settings}}</h5>
                                <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.site_settings_message}}</p>
                            </div>
                        </div>
                    </template>

                    <SiteSettings />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.securities}}</h5>
                            <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.securities_message}}</p>
                        </div>
                    </template>

                    <Securities />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.date_and_time}}</h5>
                            <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.global_date_and_time_settings}}</p>
                        </div>
                    </template>

                    <DateTime />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.social_media_and_links}}</h5>
                            <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.static_links_management}}</p>
                        </div>
                    </template>

                    <SocialMediaLink />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.scripts}}</h5>
                            <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.scripts_message}}</p>
                        </div>
                    </template>

                    <Script />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{root.assets.language_string.general_settings.meta_tags}}</h5>
                            <p class="text-color-secondary text-xs">{{root.assets.language_string.general_settings.global_meta_tags}}</p>
                        </div>
                    </template>

                    <MetaTags />
                </AccordionTab>
            </Accordion>

        </Panel>
    </div>
</template>
