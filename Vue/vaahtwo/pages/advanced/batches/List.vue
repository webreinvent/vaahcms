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

import {useBatchStore} from '../../../stores/advanced/store-batches'
import {useRootStore} from "../../../stores/root";

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
const store = useBatchStore();
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
            <Panel class="vc-dense" >
                <template class="p-1" #header>
                    <div class="flex flex-row align-items-center w-full">
                        <h1 class="w-full batches-list-title"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.batches_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total">
                            </Badge>
                        </h1>

                        <div class="batches-list-heading">
                            <Button size="small" class="" icon="pi pi-refresh" aria-label="Sync batches" @click="store.sync" data-testid="batches-list-refresh" :loading="store.is_btn_loading" />
                        </div>
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

<style scoped>

/* UT-108 — the panel title and its count badge are one centred row. The
   badge is 19.3px tall against a 17px line of 14px text, so on the text
   baseline it hung 2.6px below the title instead of sitting level with it. */
.batches-list-heading {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* UT-129 (UAT sweep) — the batches screen had no heading at all: its title
   was a bare <b> inside a <div>, so the screen opened with no top-level
   heading. The title is now the screen's <h1>; the UA's h1 size and weight
   are pinned back to what the <div> inherited, so the rendering is
   unchanged. */
.batches-list-title {
    font-size: inherit;
    font-weight: inherit;
}
</style>
