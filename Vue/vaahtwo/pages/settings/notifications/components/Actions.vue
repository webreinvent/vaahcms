<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import {useNotificationStore} from '../../../../stores/settings/store-notification'


import Filters from './Filters.vue';
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useNotificationStore();

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
    <div v-if="!store.active_notification">

        <!--actions-->
        <!-- UT-92 (M6-T4a Batch 18) — the notifications bar uses the two-island
             toolbar (`justify-content: space-between`): the selection menus
             anchor to the left edge and the search cluster is pinned to the
             right edge, matching the other list pages. The search field +
             search/filters/reset buttons sit in one InputGroup so the
             cluster reads as a single unit. -->
        <div class="flex flex-wrap align-items-center justify-between gap-2 mt-2 mb-2">

            <!--left-->
            <div class="notifications-toolbar-menu flex align-items-center gap-1"
                 v-if="store.view === 'large'&& root.assets.language_strings.general">

                <!--selected_menu-->
                <Button size="small" class="" aria-label="Selected items actions" aria-haspopup="true" aria-controls="overlay_menu" data-testid="notification-action_menu" @click="toggleSelectedMenuState" icon="pi pi-angle-down" :badge="store.action.items.length > 0 ? String(store.action.items.length) : null" badgeSeverity="primary" />

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true"
                />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button size="small" icon="pi pi-ellipsis-h" aria-label="Bulk actions" aria-haspopup="true" aria-controls="bulk_menu_state" data-testid="notification-action_bulk_menu" @click="toggleBulkMenuState" />

                <Menu ref="bulk_menu_state"
                      :model="store.list_bulk_menu"
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
                <InputGroup class="w-full notifications-toolbar-field">
                    <InputText aria-label="Search notifications" size="small" class="w-full" type="text" v-model="store.query.filter.q" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" data-testid="notification-action_search_input" />

                    <Button size="small" class="" icon="pi pi-search" aria-label="Search" data-testid="notification-action_search" @click="store.delayedSearch()" />
                    <Button size="small" class="notifications-toolbar-action" :label="root.assets.language_strings.crud_actions.filters_button" data-testid="notification-action_filter" @click="store.show_filters = true" :disabled="store.active_notification">

                        <Badge v-if="store.count_filters > 0"
                               :value="store.count_filters"
                        />
                    </Button>

                    <Button size="small" class="notifications-toolbar-action" :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" data-testid="notification-action_reset" @click="store.resetQuery()" />
                </InputGroup>
            </div>
            <!--/right-->
        </div>
        <!-- UT-92 (M6-T4a Batch 18) — the filters live in their own grid cell,
             exactly as on the canonical list pages. -->
        <Fluid class="grid">
            <Filters />
        </Fluid>
        <RouterView />
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
.notifications-toolbar-menu :deep(.p-button) {
    height: 2.5714rem;
}

.notifications-toolbar-menu :deep(.p-button.p-button-icon-only) {
    width: 2.5714rem;
}

/* The field takes the room the search cluster has; the two list actions
   beside it keep their own width and never shrink (below 640px the cluster
   wraps, so the actions drop onto their own row). */
.notifications-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.notifications-toolbar-action {
    flex: 0 0 auto;
}
</style>
