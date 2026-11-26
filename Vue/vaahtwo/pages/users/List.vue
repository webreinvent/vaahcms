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

import { useRootStore } from "../../stores/root";
import {useUserStore} from '../../stores/store-users'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const root = useRootStore();
const store = useUserStore();
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
    <div class="grid">
        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="users-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.page_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <!-- UT-17d (M6-T4a Batch 5) — the screen's ONE primary
                             action. The brand colour is reserved for it; every
                             other control on the page is neutral or ghost. -->
                        <Button size="small" class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="user-create" v-if="store.hasPermission('can-create-users')
                                                                                     && root.assets
                                                                                     && root.assets.language_strings
                                                                                     && root.assets.language_strings.crud_actions" />

                        <Button size="small" class="" aria-label="Refresh list" icon="pi pi-refresh" :loading="store.is_btn_loading" data-testid="user-list_refresh" @click="store.sync()" />
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
.users-list-heading {
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
