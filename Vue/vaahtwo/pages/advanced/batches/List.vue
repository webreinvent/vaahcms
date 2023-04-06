<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useBatchStore} from '../../../stores/advanced/store-batches'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useBatchStore();
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
        <div :class="'col-'+store.list_view_width">
            <Panel>
                <template class="p-1" #header>
                    <div class="flex flex-row w-full">
                        <div class="w-full">
                            <b class="mr-1">Batches</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total">
                            </Badge>
                        </div>

                        <div>
                            <Button class="p-button-sm"
                                    icon="pi pi-refresh"
                                    @click="store.sync"
                                    data-testid="batches-list-refresh"
                                    :loading="store.is_btn_loading"
                            />
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
