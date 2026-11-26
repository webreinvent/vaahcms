<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useJobStore } from '../../../../stores/advanced/store-jobs'

import Filters from './Filters.vue'
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useJobStore();

onMounted(async () => {
    store.getListSelectedMenu();
    store.getListBulkMenu();
});

//--------selected_menu_state
const selected_menu_state = ref();
const toggleSelectedMenuState = (event) => {
    selected_menu_state.value.toggle(event);
};
//--------/selected_menu_state

//--------bulk_menu_state
const bulk_menu_state = ref();
const toggleBulkMenuState = (event) => {
    bulk_menu_state.value.toggle(event);
};
//--------/bulk_menu_state
</script>

<template>
    <div>

        <!--actions-->
        <!-- UT-92 (M6-T4a Batch 18) — the jobs bar uses the two-island
             toolbar (`justify-content: space-between`): the selection menus
             anchor to the left edge and the search cluster is pinned to the
             right edge, matching the other list pages. The search field +
             search/filters/reset buttons sit in one InputGroup so the
             cluster reads as a single unit. -->
        <div class="flex flex-wrap align-items-center justify-between gap-2 mt-2 mb-2">

            <!--left-->
            <div class="jobs-toolbar-menu flex align-items-center gap-1"
                 v-if="store.view === 'large' && root.assets.language_strings.general">

                <!--selected_menu-->
                <Button aria-label="Selected items actions" size="small" class="" @click="toggleSelectedMenuState" data-testid="jobs-actions-menu" aria-haspopup="true" aria-controls="overlay_menu" icon="pi pi-angle-down" :badge="store.action.items.length > 0 ? String(store.action.items.length) : null" badgeSeverity="primary" />

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true" />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button size="small" icon="pi pi-ellipsis-h" aria-label="Bulk actions" @click="toggleBulkMenuState" data-testid="jobs-actions-bulk-menu" aria-haspopup="true" aria-controls="bulk_menu_state" />

                <Menu ref="bulk_menu_state"
                      :model="store.list_bulk_menu"
                      :popup="true" />
                <!--/bulk_menu-->
            </div>
            <!--/left-->

            <!--right-->
            <!-- AUD-005 — both right-anchors are load-bearing: on a single row
                 `justify-between` (on the parent) spreads the two islands apart,
                 but once `flex-wrap` breaks the row on a narrow viewport the
                 island sits alone on its own line and `justify-between` can no
                 longer push it — `margin-left:auto` is what keeps it
                 right-anchored then. Don't drop either. -->
            <div class="flex flex-wrap items-center gap-2 vaah-list-search"
                 style="margin-left: auto; flex: 0 1 420px; min-width: 260px; max-width: 520px;">
                <InputGroup class="w-full jobs-toolbar-field">
                    <InputText aria-label="Search jobs" size="small" class="w-full" v-model="store.query.filter.q" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" data-testid="jobs-actions-search" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" />

                    <Button size="small" @click="store.delayedSearch()" data-testid="jobs-actions-search-button" icon="pi pi-search" aria-label="Search" class="" />
                    <Button size="small" class="jobs-toolbar-action" :label="root.assets.language_strings.crud_actions.filters_button" data-testid="jobs-actions-show-filters" @click="store.show_filters = true">
                        <Badge v-if="store.count_filters > 0" :value="store.count_filters"></Badge>
                    </Button>

                    <Button size="small" class="jobs-toolbar-action" :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" data-testid="jobs-actions-reset-filters" @click="store.resetQuery()" />
                </InputGroup>
            </div>
            <!--/right-->
        </div>
        <!--/actions-->

        <Fluid class="grid">
            <Filters />
        </Fluid>
    </div>
</template>

<style scoped>

/* UT-108 (M6-T1's cross-screen probe) — one control height in the toolbar.
   The density contract says a control is 36px tall (2.5714rem at the 14px
   root — `scss/openvue-density.scss`). The engine states that height for
   the whole `.vc-dense` subtree, but the app's UT-18 rule sets
   `height:auto` on *every* icon-only button (so a 32px table row can hold
   a 20px action) — and that rule is unlayered, so it outranks the engine's
   layered density rule. The two menu buttons therefore rendered 29.3px tall
   beside the 36px field.

   Here they are what the design system asks for (§8: "icon-only buttons
   are square"): a 36 x 36 square with the `pi` icon centred. */
.jobs-toolbar-menu :deep(.p-button) {
    height: 2.5714rem;
}

.jobs-toolbar-menu :deep(.p-button.p-button-icon-only) {
    width: 2.5714rem;
}

/* The field takes the room the search cluster has; the two list actions
   beside it keep their own width and never shrink (below 640px the cluster
   wraps, so the actions drop onto their own row). */
.jobs-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.jobs-toolbar-action {
    flex: 0 0 auto;
}
</style>
