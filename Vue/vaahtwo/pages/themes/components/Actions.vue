<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useThemeStore } from '../../../stores/store-themes'

import Filters from './Filters.vue'
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
const store = useThemeStore();

onMounted(async () => {
    store.getListSelectedMenu();
    store.getListBulkMenu();
    store.getFilterMenu();
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
    <div class="">

        <!--actions-->
        <!-- UT-25 (M6-T4a Batch 5) — the toolbar is two islands at the
             opposite edges (`justify-content: space-between`): the status
             filter anchors to the left edge and the search cluster is
             pinned to the right edge. Unlike the fuller list pages (which
             add a search button and a Filters button), this cluster is just
             the field + reset — these pages never carried those controls. -->
        <div class="flex flex-wrap items-center justify-between gap-2">

            <!--left-->
                <div class="themes-toolbar-menu" v-if="root.assets.language_strings.general">

                    <Button size="small" icon="pi pi-filter" aria-haspopup="true" aria-label="Filter by status" data-testid="themes-actions" @click="toggleBulkMenuState" :label="store.query.filter.status?store.toLabel(store.query.filter.status):store.assets.language_strings.themes_filter_button" />

                    <Menu ref="bulk_menu_state"
                          :model="store.status_list"
                          :popup="true"
                    />
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
                    <InputGroup class="w-full themes-toolbar-field">
                        <InputText aria-label="Search themes" size="small" class="w-full" v-model="store.query.filter.q" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" data-testid="themes-actions-search-input" :placeholder=store.assets.language_strings.themes_placeholder_search />
                        <Button class="themes-toolbar-action" size="small" icon="pi pi-filter-slash" data-testid="themes-actions-reset-filters" :label="root.assets.language_strings.crud_actions.reset_button" @click="store.resetQuery()" />
                    </InputGroup>
                </div>
            <!--/right-->

        </div>
        <!--/actions-->

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
.themes-toolbar-menu :deep(.p-button) {
    height: 2.5714rem;
}

.themes-toolbar-menu :deep(.p-button.p-button-icon-only) {
    width: 2.5714rem;
}

/* The field takes the room the search cluster has; the two list actions
   beside it keep their own width and never shrink (below 640px the cluster
   wraps, so the actions drop onto their own row). */
.themes-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.themes-toolbar-action {
    flex: 0 0 auto;
}
</style>
