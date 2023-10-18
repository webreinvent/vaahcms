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
                <TabView
                    :pt="{
                        panelContainer: {
                            class: 'p-0 pt-2'
                        },
                        tabpanel: {
                            headerAction: {
                                class: 'py-2'
                            }
                        }
                    }"
                >
                    <TabPanel class="vh-logs" header="test logs">
                        <DataTable
                            :value="store.item.logs"
                            tableStyle="max-width: 30rem"
                            :row-hover="true"
                            :pt="{
                                column: {
                                    headerCell: {
                                        class: 'p-2'
                                    },
                                    bodyCell: {
                                        class: 'p-2'
                                    }
                                }
                            }"
                        >
                            <Column field="type" header="Type">
                                <template #body="slotProps">
                                    <div
                                        class="flex align-items-center gap-2"
                                        :class="{
                                            'text-success': slotProps.data.type.toLowerCase() === 'success',
                                            'text-info': slotProps.data.type.toLowerCase() === 'info' || slotProps.data.type.toLowerCase() === 'debug',
                                            'text-warning': slotProps.data.type.toLowerCase() === 'warning',
                                            'text-danger': slotProps.data.type.toLowerCase() === 'error'
                                        }"
                                    >
                                        <i :class="{
                                            'fa-solid fa-circle-info': slotProps.data.type.toLowerCase() === 'info' || slotProps.data.type.toLowerCase() === 'debug',
                                            'fa-solid fa-circle-exclamation': slotProps.data.type.toLowerCase() === 'error',
                                            'fa-solid fa-circle-check': slotProps.data.type.toLowerCase() === 'success',
                                            'fa-solid fa-triangle-exclamation': slotProps.data.type.toLowerCase() === 'warning',
                                        }"></i>
                                        <span>
                                        {{ slotProps.data.type.charAt(0).toUpperCase() + slotProps.data.type.substring(1).toLowerCase() }}
                                    </span>
                                    </div>
                                </template>
                            </Column>
                            <Column field="timestamp" header="Time">
                                <template #body="slotProps">
                                    <span class="timestamp white-space-nowrap font-medium">{{ slotProps.data.timestamp }}</span>
                                </template>
                            </Column>
                            <Column field="env" header="Env">
                                <template #body="slotProps">
                                    <span class="white-space-nowrap">{{ slotProps.data.env }}</span>
                                </template>
                            </Column>
                            <Column field="message" header="Message">
                                <template #body="slotProps">
                                    <p class="w-18rem max-w-18rem overflow-hidden white-space-nowrap text-overflow-ellipsis">{{ slotProps.data.message }}</p>
                                </template>
                            </Column>
                            <Column field="ago" header="">
                                <template #body="slotProps">
                                    <span class="vh-ago white-space-nowrap">{{ slotProps.data.ago }}</span>
                                </template>
                            </Column>
                        </DataTable>
                    </TabPanel>

                    <TabPanel header="Logs">
                        <table v-if="store.item.logs" class="p-datatable">
                            <tr v-for="log in store.item.logs">
                                <td>
                                    <div class="level is-marginless">
                                        <div class="level-left">
                                            <div class="level-item">
                                                <Tag class="mb-2 bg-black-alpha-90 border-noround text-xs">TYPE</Tag>
                                                <Tag class="mr-2 mb-2 border-noround" :value="log.type"></Tag>
                                            </div>

                                            <div class="level-item">
                                                <Tag class="mb-2 bg-black-alpha-90 border-noround">TIME</Tag>
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
