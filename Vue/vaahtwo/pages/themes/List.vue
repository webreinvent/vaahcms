<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useThemeStore} from '../../stores/store-themes'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useThemeStore();
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

                    <div class="flex flex-row">
                        <div >
                            <b class="mr-1">Themes</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total">
                            </Badge>
                        </div>
                        <div class="flex">
                            <span class="p-buttonset flex justify-content-end">
                                 <Button type="is-light"
                                          tag="router-link"
                                          @click="store.setSixColumns()"
                                          icon="pi pi-plus"
                                          label="Install">
                                </Button>

                                <Button type="is-light"
                                          :loading="store.is_fetching_updates"
                                          @click="store.checkUpdate()"
                                          icon="pi pi-cloud-download"
                                          label="Check Updates">
                                </Button>

                                <Button type="is-light"
                                          @click="store.sync()"
                                          :loading="store.is_btn_loading"
                                          icon="pi pi-refresh">
                                </Button>
                            </span>
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
