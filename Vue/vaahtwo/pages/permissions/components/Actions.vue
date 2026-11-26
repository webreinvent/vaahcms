<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { usePermissionStore } from '../../../stores/store-permissions'

import Filters from './Filters.vue'
import {useRootStore} from "../../../stores/root";

const root = useRootStore();
const store = usePermissionStore();

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
        <!-- UT-25 (M6-T4a Batch 5) — the toolbar is two islands at the
             opposite edges (`justify-content: space-between`): the selection
             menus anchor to the left edge and the search cluster anchors to
             the right edge. The right island is a fixed-width flex item
             (no grow) so it sits at the right instead of stretching back
             toward the left block. -->
        <div class="flex flex-wrap align-items-center justify-between gap-2 mt-2 mb-2">

            <!--left-->
            <div class="permissions-toolbar-menu flex align-items-center gap-1"
                 v-if="store.view === 'large'&& root.assets.language_strings.general">

                <!--selected_menu-->
                <Button size="small" type="button" aria-label="Actions for selected records" aria-haspopup="true" aria-controls="overlay_menu" data-testid="permission-action_menu" @click="toggleSelectedMenuState" v-if="store.hasPermission('can-manage-permissions') || store.hasPermission('can-update-permissions')" icon="pi pi-angle-down" :badge="store.action.items.length > 0 ? String(store.action.items.length) : null" badgeSeverity="primary" />

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true"
                />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button size="small" class="ml-1" icon="pi pi-ellipsis-h" type="button" aria-label="Bulk actions" data-testid="permission-action_bulk_menu" @click="toggleBulkMenuState" aria-haspopup="true" aria-controls="bulk_menu_state" v-if="store.hasPermission('can-manage-permissions') || store.hasPermission('can-update-permissions')" />

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
                <InputGroup class="w-full permissions-toolbar-field">
                    <InputText aria-label="Search permissions" size="small" class="w-full" v-model="store.query.filter.q" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" data-testid="permission-action_search_input" />

                    <Button size="small" aria-label="Search" @click="store.delayedSearch()" icon="pi pi-search" data-testid="permission-action_search" />
                    <Button class="permissions-toolbar-action" size="small" type="button" :label="root.assets.language_strings.crud_actions.filters_button" @click="store.show_filters = true" data-testid="permission-action_filter">
                        <Badge v-if="store.count_filters > 0" :value="store.count_filters" />
                    </Button>

                    <Button class="permissions-toolbar-action" size="small" type="button" icon="pi pi-filter-slash" :label="root.assets.language_strings.crud_actions.reset_button" data-testid="permission-action_filter_reset" @click="store.resetQuery()" />
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
.permissions-toolbar-menu :deep(.p-button) {
    height: 2.5714rem;
}

.permissions-toolbar-menu :deep(.p-button.p-button-icon-only) {
    width: 2.5714rem;
}

/* The field takes the room the search cluster has; the two list actions
   beside it keep their own width and never shrink (below 640px the cluster
   wraps, so the actions drop onto their own row). */
.permissions-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.permissions-toolbar-action {
    flex: 0 0 auto;
}
</style>
