<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useMediaStore } from '../../../stores/store-media';
import {useRootStore} from "../../../stores/root";

import Filters from './Filters.vue'
const root = useRootStore();
const store = useMediaStore();

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
        <!-- UT-89 (M6-T4a Batch 17) — the media bar uses the two-island
             toolbar (`justify-content: space-between`): the bulk menu
             anchors to the left edge and the search cluster is pinned to
             the right edge, matching the other list pages. The search
             field + search/filters/reset buttons sit in one InputGroup so
             the cluster reads as a single unit. -->
        <div class="media-toolbar flex flex-wrap align-items-center justify-between gap-2 mt-2 mb-2">

            <!--left-->
            <div class="media-toolbar-menu flex align-items-center gap-1"
                 v-if="store.view === 'large' && root.assets.language_strings.general">

                <!--selected_menu-->
                <!-- M6-T1 (D3) — the two menu buttons were not the same
                     control. This one drew its chevron as a raw
                     `<i class="pi pi-angle-down">` — a 14px glyph on the text
                     baseline, sitting low in its box (measured: 14 × 14px,
                     `vertical-align: baseline`) — while its sibling used the
                     engine's `icon` prop (12.25px, centred, 28 × 29.3px).
                     The chevron now uses the `icon` prop too, so both
                     buttons are the engine's own icon-only control.

                     The count of selected records rides the engine's `badge`
                     prop: the engine renders it inside the button and keeps
                     the button out of its fixed-width icon-only shape (a
                     badge in the button's slot would have been clipped by
                     the icon-only width). `badgeSeverity="primary"` is the
                     badge's default tone — the v4 badge has no "primary"
                     class, so the count keeps the accent it always had. -->
                <Button aria-label="Selected items actions" size="small"
                        icon="pi pi-angle-down"
                        :badge="store.action.items.length > 0 ? String(store.action.items.length) : null"
                        badgeSeverity="primary"
                        v-if="store.hasPermission('can-manage-media') || store.hasPermission('can-update-media')" class="" data-testid="media-actions-menu" type="button" aria-haspopup="true" aria-controls="overlay_menu" @click="toggleSelectedMenuState" />

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true" />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button size="small" icon="pi pi-ellipsis-h" aria-label="Bulk actions" data-testid="media-actions-bulk-menu" type="button" aria-haspopup="true" aria-controls="bulk_menu_state" @click="toggleBulkMenuState" v-if="store.hasPermission('can-update-media') || store.hasPermission('can-manage-media')" />
                <Menu ref="bulk_menu_state"
                      :model="store.list_bulk_menu"
                      :popup="true"
                />
                <!--/bulk_menu-->
            </div>
            <!--/left-->

            <!--right-->
            <!-- M6-T1 (D3) — the search cluster is one InputGroup: the
                 field, the magnifier, "Filters" and "Reset" all sit inside
                 it so the whole cluster reads as a single bordered unit and
                 stays pinned to the right edge together. -->
            <!-- AUD-005 — both right-anchors are load-bearing: on a single row
                 `justify-between` (on the parent) spreads the two islands apart,
                 but once `flex-wrap` breaks the row on a narrow viewport the
                 island sits alone on its own line and `justify-between` can no
                 longer push it — `margin-left:auto` is what keeps it
                 right-anchored then. Don't drop either. -->
            <div class="media-toolbar-search flex flex-wrap align-items-center gap-2 vaah-list-search"
                 style="margin-left: auto; flex: 0 1 420px; min-width: 260px; max-width: 520px;">
                <InputGroup class="w-full media-toolbar-field">
                    <InputText aria-label="Search media" size="small" v-model="store.query.filter.q" class="w-full" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" data-testid="media-actions-search" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" />

                    <Button size="small" @click="store.delayedSearch()" class="" data-testid="media-actions-search-button" icon="pi pi-search" aria-label="Search" />
                    <Button size="small" class="media-toolbar-action" :label="root.assets.language_strings.crud_actions.filters_button" data-testid="media-actions-show-filters" @click="store.show_filters = true">
                        <Badge v-if="store.count_filters > 0" :value="store.count_filters"></Badge>
                    </Button>

                    <Button size="small" class="media-toolbar-action" icon="pi pi-filter-slash" data-testid="media-actions-reset-filters" :label="root.assets.language_strings.crud_actions.reset_button" @click="store.resetQuery()" />
                </InputGroup>
            </div>
            <!--/right-->
        </div>
        <!--/actions-->

        <Fluid class="grid">
            <Filters/>
        </Fluid>
    </div>
</template>

<style scoped>
/* M6-T1 (D3) — one control height in the toolbar.
   The density contract says a control is 36px tall (2.5714rem at the 14px
   root — `scss/openvue-density.scss`). The engine states that height for
   the whole `.vc-dense` subtree, but the app's UT-18 rule sets
   `height:auto` on *every* icon-only button (so a 32px table row can hold
   a 20px action) — and that rule is unlayered, so it outranks the
   engine's layered density rule. The two menu buttons therefore rendered
   29.3px tall beside the 36px field.

   Here they are what the design system asks for (§8: "icon-only buttons
   are square"): a 36 × 36 square with the `pi` icon centred. */
.media-toolbar-menu :deep(.p-button) {
    height: 2.5714rem;
}

.media-toolbar-menu :deep(.p-button.p-button-icon-only) {
    width: 2.5714rem;
}

/* M6-T1 (D3) — the field takes the room the search cluster has; the two
   list actions beside it keep their own width and never shrink (below
   640px the cluster wraps, so the actions drop onto their own row). */
.media-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.media-toolbar-action {
    flex: 0 0 auto;
}
</style>
