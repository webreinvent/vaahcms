<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useUserStore} from '../../stores/store-users'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useUserStore();
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
    <div class="grid">
        <div :class="'col-'+store.list_view_width">
            <Panel class="is-small">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <div >
                            <b class="mr-1">Users</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <div class="p-inputgroup">
                        <Button class="p-button-sm"
                                label="Create"
                                icon="pi pi-plus"
                                @click="store.toForm()"
                                data-testid="user-create"
                                v-if="store.hasPermission('can-create-users')"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-refresh"
                                :loading="store.is_btn_loading"
                                data-testid="user-list_refresh"
                                @click="store.sync()"
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
