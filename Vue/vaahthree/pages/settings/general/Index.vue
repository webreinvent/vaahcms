<script setup>
import { onMounted } from "vue";
import { useRoute } from 'vue-router';
import { useGeneralStore } from "../../../stores/settings/store-general_setting";
import { useRootStore } from "../../../stores/root";
import { vaah } from '../../../vaahvue/pinia/vaah';
import SiteSettings from './components/SiteSettings.vue';
import Securities from './components/Securities.vue';
import DateTime from './components/DateTime.vue';
import SocialMediaLink from './components/SocialMediaLink.vue';
import Script from './components/Scripts.vue';
import MetaTags from './components/MetaTags.vue'
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
         <Panel class="is-small" v-if="store.assets">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div v-if="store.assets && store.assets.language_strings">
                        <b class="mr-1">{{store.assets.language_strings.general_settings_title}}</b>
                     </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button :label="store.assets.language_strings.expand_all" icon="pi pi-angle-double-down" class="p-button-sm mr-2"
                            @click="store.expandAll"></Button>
                    <Button :label="store.assets.language_strings.collapse_all" icon="pi pi-angle-double-up" class="p-button-sm"
                            @click="store.collapseAll"></Button>
                </div>
            </template>

            <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer" class="my-2">
                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <div>
                                <h5 class="font-semibold text-sm">{{ store.assets.language_strings.site_settings }}</h5>
                                <p class="text-color-secondary text-xs">{{ store.assets.language_strings.site_settings_message }}</p>
                            </div>
                        </div>
                    </template>

                    <SiteSettings />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{ store.assets.language_strings.securities }}</h5>
                            <p class="text-color-secondary text-xs">{{ store.assets.language_strings.securities_message }}</p>
                        </div>
                    </template>

                    <Securities />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{ store.assets.language_strings.date_and_time }}</h5>
                            <p class="text-color-secondary text-xs">{{ store.assets.language_strings.global_date_and_time_settings }}</p>
                        </div>
                    </template>

                    <DateTime />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{ store.assets.language_strings.social_media_and_links }}</h5>
                            <p class="text-color-secondary text-xs">{{ store.assets.language_strings.static_links_management }}</p>
                        </div>
                    </template>

                    <SocialMediaLink />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{ store.assets.language_strings.scripts }}</h5>
                            <p class="text-color-secondary text-xs">{{ store.assets.language_strings.scripts_message }}</p>
                        </div>
                    </template>

                    <Script />
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <h5 class="font-semibold text-sm">{{ store.assets.language_strings.meta_tags }}</h5>
                            <p class="text-color-secondary text-xs">{{ store.assets.language_strings.global_meta_tags }}</p>
                        </div>
                    </template>

                    <MetaTags />
                </AccordionTab>
            </Accordion>

        </Panel>
    </div>
</template>
