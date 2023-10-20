<script setup>
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

        <Panel v-if="store && store.item" class="is-small">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        Log
                        <span v-if="store.item.name">
                           :  {{store.item.name}}
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <Button icon="pi pi-trash"
                        @click="store.confirmClearFile(store.item)"
                        data-testid="logs-item_clear_file"
                        class="p-button-sm p-button-rounded p-button-text"
                        v-tooltip.top=" 'Clear File' "
                />

                <Button icon="pi pi-download"
                        @click="store.downloadFile(store.item)"
                        data-testid="logs-item_download_file"
                        class="p-button-sm p-button-rounded p-button-text"
                        v-tooltip.top=" 'Download File' "
                />

                <Button icon="pi pi-refresh"
                        @click="store.getItem(store.item.name)"
                        data-testid="logs-item_refresh"
                        class="p-button-sm p-button-rounded p-button-text"
                        v-tooltip.top=" 'Reload' "
                />

                <Button icon="pi pi-times"
                        @click="store.toList()"
                        data-testid="logs-item_close"
                        class="p-button-sm p-button-rounded p-button-text"
                        v-tooltip.top=" 'Close' "
                />
            </template>

            <div class="card overflow-hidden">
                <TabView class="is-small tab-panel-has-no-padding">
                    <TabPanel header="Logs">
                        <DataTable
                            :value="store.item.logs"
                            class="p-datatable-sm p-datatable-hoverable-rows"
                            stripedRows
                            responsiveLayout="scroll"
                        >
                            <Column field="type" header="Type">
                                <template #body="prop">
                                    <div
                                        class="flex align-items-center gap-2"
                                        :class="{
                                            'text-success': prop.data.type.toLowerCase() === 'success',
                                            'text-info': prop.data.type.toLowerCase() === 'info' || prop.data.type.toLowerCase() === 'debug',
                                            'text-warning': prop.data.type.toLowerCase() === 'warning',
                                            'text-danger': prop.data.type.toLowerCase() === 'error'
                                        }"
                                    >
                                        <i :class="{
                                            'fa-solid fa-circle-info': prop.data.type.toLowerCase() === 'info' || prop.data.type.toLowerCase() === 'debug',
                                            'fa-solid fa-circle-exclamation': prop.data.type.toLowerCase() === 'error',
                                            'fa-solid fa-circle-check': prop.data.type.toLowerCase() === 'success',
                                            'fa-solid fa-triangle-exclamation': prop.data.type.toLowerCase() === 'warning',
                                        }"></i>
                                        <span>
                                        {{ prop.data.type.charAt(0).toUpperCase() + prop.data.type.substring(1).toLowerCase() }}
                                    </span>
                                    </div>
                                </template>
                            </Column>
                            <Column field="timestamp" header="Time">
                                <template #body="prop">
                                    <span class="timestamp white-space-nowrap font-medium">{{ prop.data.timestamp }}</span>
                                </template>
                            </Column>
                            <Column field="env" header="Env">
                                <template #body="prop">
                                    <span class="white-space-nowrap">{{ prop.data.env }}</span>
                                </template>
                            </Column>
                            <Column field="message" header="Message">
                                <template #body="prop">
                                    <p class="w-20rem max-w-20rem overflow-hidden white-space-nowrap text-overflow-ellipsis">{{ prop.data.message }}</p>
                                </template>
                            </Column>
                            <Column field="ago" header="">
                                <template #body="prop">
                                    <span class="white-space-nowrap">{{ prop.data.ago }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>

                    <TabPanel header="Raw">
                        <small v-if="store.item.content"
                            style="max-height: 768px; overflow: auto;"
                            v-html="store.item.content"></small>
                    </TabPanel>
                </TabView>
            </div>
        </Panel>
    </div>
</template>
