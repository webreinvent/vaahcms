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
            <Panel class="is-small">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <div >
                            <b class="mr-1">Themes</b>
                            <Badge v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <div class="p-inputgroup">
                        <Button tag="router-link"
                                v-if="store.hasPermission('can-install-theme')"
                                @click="store.setSixColumns()"
                                icon="pi pi-plus"
                                class="p-button-sm"
                                data-testid="themes-list-install"
                                label="Install"
                        />
                        <Button :loading="store.is_fetching_updates"
                                v-if="store.hasPermission('can-update-theme')"
                                @click="store.checkUpdate()"
                                icon="pi pi-download"
                                class="p-button-sm"
                                data-testid="themes-list-check_updated"
                                label="Check Updates"
                        />

                        <Button type="is-light"
                                @click="store.sync()"
                                :loading="store.is_btn_loading"
                                class="p-button-sm"
                                data-testid="themes-list-refresh"
                                icon="pi pi-refresh"
                                v-tooltip.top="'Reload'"
                        />
                    </div>
                </template>

                <Actions/>

             <Table/>

            </Panel>
        </div>

        <RouterView/>

    </div>


</template>
