<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
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

import { useConfirm } from "openvue/useconfirm";

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
         <Panel class="vc-dense" v-if="store.assets">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div v-if="store.assets && store.assets.language_strings">
                        <h1 class="mr-1 vaah-type-title">{{store.assets.language_strings.general_settings_title}}</h1>
                     </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button size="small" :label="store.assets.language_strings.expand_all" icon="pi pi-angle-double-down" class=" mr-2" @click="store.expandAll"></Button>
                    <Button size="small" :label="store.assets.language_strings.collapse_all" icon="pi pi-angle-double-up" class="" @click="store.collapseAll"></Button>
                </div>
            </template>

            <Accordion :multiple="true" :value="store.active_index" id="accordionTabContainer" class="my-2">
                <AccordionPanel :value="0">
                    <AccordionHeader>                        <div class="w-full">
                            <div>
                                <h2 class="vaah-type-section">{{ store.assets.language_strings.site_settings }}</h2>
                                <p class="vaah-type-secondary">{{ store.assets.language_strings.site_settings_message }}</p>
                            </div>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <SiteSettings />
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="1">
                    <AccordionHeader>                        <div class="w-full">
                            <h2 class="vaah-type-section">{{ store.assets.language_strings.securities }}</h2>
                            <p class="vaah-type-secondary">{{ store.assets.language_strings.securities_message }}</p>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <Securities />
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="2">
                    <AccordionHeader>                        <div class="w-full">
                            <h2 class="vaah-type-section">{{ store.assets.language_strings.date_and_time }}</h2>
                            <p class="vaah-type-secondary">{{ store.assets.language_strings.global_date_and_time_settings }}</p>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <DateTime />
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="3">
                    <AccordionHeader>                        <div class="w-full">
                            <h2 class="vaah-type-section">{{ store.assets.language_strings.social_media_and_links }}</h2>
                            <p class="vaah-type-secondary">{{ store.assets.language_strings.static_links_management }}</p>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <SocialMediaLink />
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="4">
                    <AccordionHeader>                        <div class="w-full">
                            <h2 class="vaah-type-section">{{ store.assets.language_strings.scripts }}</h2>
                            <p class="vaah-type-secondary">{{ store.assets.language_strings.scripts_message }}</p>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <Script />
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="5">
                    <AccordionHeader>                        <div class="w-full">
                            <h2 class="vaah-type-section">{{ store.assets.language_strings.meta_tags }}</h2>
                            <p class="vaah-type-secondary">{{ store.assets.language_strings.global_meta_tags }}</p>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <MetaTags />
                
                    </AccordionContent>
                </AccordionPanel>
            </Accordion>

        </Panel>
    </div>
</template>
