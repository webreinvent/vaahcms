<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useModuleStore} from '../../stores/store-modules'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useModuleStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();


onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);

    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.watchRoutes(route);

    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});

</script>
<template>

    <div class="grid" v-if="store.assets">

        <div :class="'col-'+store.list_view_width">
            <Panel>

                <template class="p-1" #header>
                    <div class="flex flex-row w-full">
                        <div class="w-6">
                            <div >
                                <b class="mr-1">Modules</b>
                                <Badge v-if="store.list && store.list.total > 0"
                                       :value="store.list.total">
                                </Badge>
                            </div>
                        </div>
                        <div class="w-6 justify-content-end">
                            <div class="">
                                <span class="p-buttonset flex justify-content-end">
                                     <Button class="p-button-outlined"
                                             tag="router-link"
                                             @click="store.setSixColumns()"
                                             icon="pi pi-plus"
                                             label="Install">
                                    </Button>

                                    <Button class="p-button-outlined"
                                            :loading="store.is_fetching_updates"
                                            @click="store.checkUpdate()"
                                            icon="pi pi-cloud-download"
                                            label="Check Updates">
                                    </Button>

                                    <Button class="p-button-outlined"
                                            @click="store.sync()"
                                            :loading="store.is_btn_loading"
                                            icon="pi pi-refresh">
                                    </Button>
                                </span>
                            </div>
                        </div>
                    </div>
                </template>

                <Actions/>

                <br/>

                <Table/>

            </Panel>
        </div>

        <RouterView/>

    </div>


</template>
