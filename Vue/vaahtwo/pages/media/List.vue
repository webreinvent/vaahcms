<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useMediaStore} from '../../stores/store-media'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useMediaStore();
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
    await store.setPageTitle();
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

        <div class="col-12">
            <div class="grid m-0">

                <div class="col">
                    <div class="p-fieldset card p-3">
                        <div class="flex align-items-center">
                            <div class="mr-2">
                                <span class="p-3 border-circle bg-blue-50">
                                     <i class="text-blue-400 pi pi-file"></i>
                                </span>
                            </div>

                            <div class="flex flex-column align-items-start">
                                <p class="text-sm font-semibold">Total Medias</p>
                                <h6 v-if="store.list" class="text-xl font-semibold">
                                    {{ store.list.total}}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="p-fieldset card p-3">
                        <div class="flex align-items-center">
                            <div class="mr-2"><span class="p-3 border-circle bg-blue-50">
                                 <i class="text-blue-400 pi pi-upload"></i>
                            </span></div>

                            <div class="flex flex-column align-items-start">
                                <p class="text-sm font-semibold">Total File Size</p>
                                <h6 v-if="store.list" class="text-xl font-semibold">
                                    {{ store.total_file_size }} MB
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="p-fieldset card p-3">
                        <div class="flex align-items-center">
                            <div class="mr-2">
                                <span class="p-3 border-circle bg-blue-50">
                                     <i class="text-blue-400 pi pi-trash"></i>
                                </span>
                            </div>

                            <div class="flex flex-column align-items-start">
                                <p class="text-sm font-semibold">Trashed File Size</p>
                                <h6 v-if="store.list" class="text-xl font-semibold">
                                    {{ store.trashed_file_size}} MB
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div :class="'col-'+store.list_view_width">
            <Panel class="is-small">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <div>
                            <b class="mr-1">Media</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <span class="p-buttonset">
                        <Button data-testid="media-list-create"
                                @click="store.toForm()"
                                icon="pi pi-plus"
                                label="Create"
                                class="p-button-sm"
                                v-if="store.hasPermission('can-create-media')"
                        />

                        <Button data-testid="media-list-reload"
                                @click="store.reload()"
                                :loading="store.is_btn_loading"
                                icon="pi pi-refresh"
                                class="p-button-sm"
                        />
                    </span>
                </template>

                <Actions/>

                <br/>

                <Table/>
            </Panel>
        </div>

        <RouterView/>
    </div>
</template>
