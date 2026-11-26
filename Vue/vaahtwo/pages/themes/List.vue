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

import {useThemeStore} from '../../stores/store-themes'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
const store = useThemeStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
import {useRootStore} from "../../stores/root";
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
                        <h1 class="themes-list-heading">
                            <b>{{store.assets.language_strings.themes_heading}}</b>
                            <Badge v-if="store.list && store.list.length > 0"
                                   :value="store.list.length"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <!-- UT-17d (M6-T4a Batch 5) — the screen's ONE primary
                             action (install a theme); every other control on the
                             page is neutral or ghost. -->
                        <Button size="small" class="vaah-btn-primary" tag="router-link" v-if="store.hasPermission('can-install-theme')" @click="store.setSixColumns()" icon="pi pi-plus" data-testid="themes-list-install" :label="store.assets.language_strings.themes_install_button" />
                        <Button size="small" :loading="store.is_fetching_updates" v-if="store.hasPermission('can-update-theme')" @click="store.checkUpdate()" icon="pi pi-download" class="" data-testid="themes-list-check_updated" :label="store.assets.language_strings.themes_check_updates_button" />

                        <!-- UT-23 (M6-T4a Batch 5) — `type="is-light"` is a v3
                             prop; v4 spells the ghost variant `text`. The old
                             prop was inert, so the button rendered as a solid
                             default button. -->
                        <Button size="small" text aria-label="Reload themes" @click="store.sync()" :loading="store.is_btn_loading" class="" data-testid="themes-list-refresh" icon="pi pi-refresh" v-tooltip.top="store.assets.language_strings.toolkit_text_reload" />
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
.themes-list-heading {
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
