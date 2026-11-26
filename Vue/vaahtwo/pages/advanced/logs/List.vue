<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref} from "vue";
import {useRoute} from 'vue-router';
import {useLogStore} from '../../../stores/advanced/store-logs'
import { useRootStore } from "../../../stores/root";
import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useLogStore();
const route = useRoute();
const root = useRootStore();

import { useConfirm } from "openvue/useconfirm";
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
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="logs-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b class="mr-1">{{store.assets.language_strings.logs}}</b>
                            <Badge v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <Button size="small" icon="pi pi-refresh" aria-label="Refresh logs" @click="store.reload()" class="" data-testid="logs-list_refresh" :loading="store.is_btn_loading" />

                        <Button size="small" icon="pi pi-ellipsis-v" aria-label="More options" class="" @click="toggleItemMenu" aria-controls="menu_items_state" data-testid="logs-toggle_menu_items" />

                        <Menu ref="menu_items"
                              :model="store.menu_items"
                              :popup="true"
                        />
                    </InputGroup>
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

<style scoped>
/* UT-129 (UAT sweep) — the panel title is the screen's single top-level
   heading, so it is an <h1>; the UA's h1 size and weight are pinned back to
   what the <div> inherited, so the rendering is unchanged. */
.logs-list-heading {
    font-size: inherit;
    font-weight: inherit;
}
</style>
