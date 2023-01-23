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
                <template #header>
                    <div class="flex justify-content-between align-items-center w-full">
                        <h5 class="font-semibold text-lg">
                            Modules
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total">
                            </Badge>
                        </h5>
                        <div class="p-inputgroup justify-content-end">
                            <Button class="p-button-sm"
                                    tag="router-link"
                                    @click="store.setSixColumns()"
                                    icon="pi pi-plus"
                                    label="Install"
                                    data-testid="modules-list-action-check_updates"
                                    v-if="store.hasPermission('can-install-theme')">
                            </Button>
                            <Button class="p-button-sm"
                                    :loading="store.is_fetching_updates"
                                    @click="store.checkUpdate()"
                                    icon="pi pi-download"
                                    label="Check Updates"
                                    data-testid="modules-list-action-check_updates"
                                    v-if="store.hasPermission('can-update-theme')">
                            </Button>
                            <Button class="p-button-sm"
                                    @click="store.sync()"
                                    :loading="store.is_btn_loading"
                                    data-testid="modules-list-action-refresh"
                                    icon="pi pi-refresh">
                            </Button>
                        </div>
                    </div>
                </template>
                <template class="p-1" #content>
                    <div class="flex flex-row w-full">
                        <div class="w-6 flex align-items-center">
                            <div>
                                <b class="font-semibold text-lg mr-1">Modules</b>
                            </div>
                        </div>
                        <div class="w-6 justify-content-end">
                            <div class="">
                                <span class="p-buttonset flex justify-content-end">
                                    <Button class="p-button-sm"
                                             tag="router-link"
                                             @click="store.setSixColumns()"
                                             icon="pi pi-plus"
                                             label="Install"
                                             v-if="store.hasPermission('can-install-theme')">
                                    </Button>

                                    <Button class="p-button-sm"
                                            :loading="store.is_fetching_updates"
                                            @click="store.checkUpdate()"
                                            icon="pi pi-download"
                                            label="Check Updates"
                                            v-if="store.hasPermission('can-update-theme')">
                                    </Button>

                                    <Button class="p-button-sm"
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
