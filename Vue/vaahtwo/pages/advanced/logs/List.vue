<script setup>
import {onMounted, ref} from "vue";
import {useRoute} from 'vue-router';
import {useLogStore} from '../../../stores/advanced/store-logs'
import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useLogStore();
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

    await store.getMenuItems();
});

//--------toggle item menu--------//
const menu_items = ref();

const toggleItemMenu = (event) => {
    menu_items.value.toggle(event);
};
//--------toggle item menu--------//

</script>

<template>
    <div class="grid" v-if="store.assets">
        <div class='col-5'>
            <Panel class="is-small">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <div >
                            <b class="mr-1">Logs</b>

                            <Badge class="is-small" v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <div class="p-inputgroup">
                        <Button icon="pi pi-refresh"
                                @click="store.reload()"
                                class="p-button-sm"
                                data-testid="logs-list_refresh"
                                :loading="store.is_btn_loading"
                        />

                        <Button icon="pi pi-ellipsis-v"
                                class="p-button-sm"
                                @click="toggleItemMenu"
                                aria-controls="menu_items_state"
                                data-testid="logs-toggle_menu_items"
                        />

                        <Menu ref="menu_items"
                              :model="store.menu_items"
                              :popup="true"
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
