<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useModuleStore} from '../../stores/store-modules';
import {useRootStore} from "../../stores/root";

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
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
                        <div v-if="store.assets && store.assets.language_strings">
                            <b class="mr-1">{{store.assets.language_strings.module_title}}</b>
                            <Badge v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <div class="p-inputgroup">
                        <Button class="p-button-sm"
                                tag="router-link"
                                @click="store.setSixColumns()"
                                icon="pi pi-plus"
                                :label="store.assets.language_strings.install_button"
                                data-testid="modules-list-action-install"
                                v-if="store.hasPermission('can-install-module')"
                        />

                        <Button class="p-button-sm"
                                :loading="store.is_fetching_updates"
                                @click="store.checkUpdate()"
                                icon="pi pi-download"
                                :label="store.assets.language_strings.check_updates_button"
                                data-testid="modules-list-action-check_updates"
                                v-if="store.hasPermission('can-update-module')"
                        />

                        <Button class="p-button-sm"
                                @click="store.sync()"
                                :loading="store.is_btn_loading"
                                data-testid="modules-list-action-refresh"
                                icon="pi pi-refresh"
                                v-tooltip.top="store.assets.language_strings.toolkit_text_reload"
                        />
                    </div>
                </template>

                 <Actions v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                 />
                <Table/>

            </Panel>
        </div>

        <RouterView/>

    </div>


</template>
