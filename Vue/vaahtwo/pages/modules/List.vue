<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useModuleStore} from '../../stores/store-modules';
import {useRootStore} from "../../stores/root";

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
const store = useModuleStore();
const route = useRoute();

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
});

</script>
<template>
    <div class="grid" v-if="store.assets">
        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="modules-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.module_title}}</b>
                            <Badge v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <!-- UT-17d (M6-T4a Batch 5) — the screen's ONE primary
                             action (install a module); every other control on
                             the page is neutral or ghost. -->
                        <Button size="small" class="vaah-btn-primary" tag="router-link" @click="store.setSixColumns()" icon="pi pi-plus" :label="store.assets.language_strings.install_button" data-testid="modules-list-action-install" v-if="store.hasPermission('can-install-module')" />

                        <Button size="small" class="" :loading="store.is_fetching_updates" @click="store.checkUpdate()" icon="pi pi-download" :label="store.assets.language_strings.check_updates_button" data-testid="modules-list-action-check_updates" v-if="store.hasPermission('can-update-module')" />

                        <Button size="small" class="" aria-label="Reload modules" @click="store.sync()" :loading="store.is_btn_loading" data-testid="modules-list-action-refresh" icon="pi pi-refresh" v-tooltip.top="store.assets.language_strings.toolkit_text_reload" />
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

/* UT-108 — the panel title and its count badge are one centred row. The
   badge is 19.3px tall against a 17px line of 14px text, so on the text
   baseline it hung 2.6px below the title instead of sitting level with it. */
.modules-list-heading {
    /* UT-129 — the panel title is the screen's single top-level
       heading, so it is an <h1>; the UA's h1 size and weight are pinned
       back to what the <div> inherited, so the rendering is unchanged. */
    font-size: inherit;
    font-weight: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>
