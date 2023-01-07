<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import { useLogStore } from '../../../stores/store-logs'

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

        <Panel v-if="store && store.item">

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
                <Button icon="pi pi-trash" @click="store.clearFile(store.item)"
                        class="p-button-sm p-button-rounded p-button-text" />
                <Button icon="pi pi-download" @click="store.downloadFile(store.item)"
                        class="p-button-sm p-button-rounded p-button-text" />
                <Button icon="pi pi-refresh" @click="store.getItem(store.item.name)"
                        class="p-button-sm p-button-rounded p-button-text" />
                <Button icon="pi pi-times" @click="store.toList()"
                        class="p-button-sm p-button-rounded p-button-text" />
            </template>

            <div class="card">
                <TabView>
                    <TabPanel header="Logs">
                        <table v-if="store.item.logs" class="p-datatable">
                            <tr v-for="log in store.item.logs">
                                <td>

                                    <div class="level is-marginless">

                                        <div class="level-left">

                                            <div class="level-item">
                                                <Tag class="mr-2" value="TYPE"></Tag>
                                                <Tag class="mr-2" severity="danger" :value="log.type"></Tag>
                                            </div>

                                            <div class="level-item">
                                                <Tag class="mr-2" severity="info" value="TIME"></Tag>
                                                <Tag class="mr-2" severity="danger"
                                                     :value="log.timestamp+'/'+log.ago"></Tag>

                                            </div>

                                            <div class="level-item">
                                                <Tag class="mr-2" severity="info" value="ENV"></Tag>
                                                <Tag class="mr-2" severity="danger"
                                                     :value="log.env"></Tag>
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
