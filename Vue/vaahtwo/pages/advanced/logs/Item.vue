<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import { useLogStore } from '../../../stores/advanced/store-logs'

import VhViewRow from '../../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useLogStore();
const route = useRoute();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.name)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if(!store.item || Object.keys(store.item).length < 1)
    {
        await store.getItem(route.params.name);
    }

    /**
     * Watch if url record id is changed, if changed
     * then fetch the new records from database
     */

});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

</script>
<template>

    <div class="col-7" >

        <Panel v-if="store && store.item" class="vc-dense">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{ store.assets.language_strings.view_log_file }}
                        <span v-if="store.item.name">
                           :  {{store.item.name}}
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <div  v-if="store.assets
                           && store.assets.language_strings
                           "
                >
                <Button size="small" icon="pi pi-trash" aria-label="Clear file" @click="store.confirmClearFile(store.item)" data-testid="logs-item_clear_file" class=" p-button-rounded p-button-text" v-tooltip.top="store.assets.language_strings.toolkit_text_clear_file" />

                <Button size="small" icon="pi pi-download" aria-label="Download file" @click="store.downloadFile(store.item)" data-testid="logs-item_download_file" class=" p-button-rounded p-button-text" v-tooltip.top="store.assets.language_strings.toolkit_text_download_file" />

                <Button size="small" icon="pi pi-refresh" aria-label="Reload file" @click="store.getItem(store.item.name)" data-testid="logs-item_refresh" class=" p-button-rounded p-button-text" v-tooltip.top="store.assets.language_strings.toolkit_text_reload" />

                <Button size="small" icon="pi pi-times" aria-label="Close" @click="store.toList()" data-testid="logs-item_close" class=" p-button-rounded p-button-text" v-tooltip.top="store.assets.language_strings.toolkit_text_close" />
                </div>
            </template>
            <div class="card overflow-hidden">
                                <Tabs value="0" class="vc-dense tab-panel-has-no-padding">
                    <TabList>
                        <Tab value="0">Logs</Tab>
                        <Tab value="1">Raw</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="0">

                        <table v-if="store.item.logs" class="p-datatable">
                            <tr v-for="log in store.item.logs">
                                <td>
                                    <div class="level is-marginless">
                                        <div class="level-left">
                                            <div class="level-item">
                                                <Tag class="mb-2 bg-black-alpha-90 border-noround vc-text-12 line-height-3">TYPE</Tag>
                                                <Tag class="mr-2 mb-2 border-noround" :value="log.type"></Tag>
                                            </div>

                                            <div class="level-item">
                                                <Tag class="mb-2 bg-black-alpha-90 border-noround line-height-3">TIME</Tag>
                                                <Tag class="mr-2 mb-2 border-noround" severity="danger"
                                                     :value="log.timestamp+'/'+log.ago"></Tag>
                                            </div>

                                            <div class="level-item">
                                                <Tag class="mb-2 bg-black-alpha-90 border-noround"
                                                     value="ENV"
                                                />

                                                <Tag class="mr-2 mb-2 border-noround"
                                                     :value="log.env"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <small>
                                        {{log.message}}
                                    </small>
                                </td>
                            </tr>
                        </table>
                                            </TabPanel>
                        <TabPanel value="1">

                        <small v-if="store.item.content"
                            style="max-height: 768px; overflow: auto;"
                            v-html="store.item.content"></small>
                                            </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </Panel>
    </div>
</template>
