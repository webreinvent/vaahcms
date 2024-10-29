<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useRoleStore} from '../../stores/store-roles'
import { useConfirm } from "primevue/useconfirm"
import {useRootStore} from "../../stores/root";

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useRoleStore();
const root = useRootStore();
const route = useRoute();
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
                        <div v-if="store.assets && store.assets.language_strings">
                            <b class="mr-1">{{store.assets.language_strings.roles_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </div>
                    </div>
                </template>

                <template #icons>
                    <div class="p-inputgroup" v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions">
                        <Button class="p-button-sm"
                                :label="root.assets.language_strings.crud_actions.create_button"
                                icon="pi pi-plus"
                                @click="store.toForm()"
                                data-testid="role-create"
                                v-if="store.hasPermission('can-create-roles')"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-refresh"
                                :loading="store.is_btn_loading"
                                @click="store.sync()"
                                data-testid="role-list_refresh"
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
