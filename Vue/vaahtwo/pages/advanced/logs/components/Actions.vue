<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useLogStore } from '../../../../stores/advanced/store-logs'

import Filters from './Filters.vue'
import {useRootStore} from "../../../../stores/root";

const root = useRootStore();
const store = useLogStore();

onMounted(async () => {
    store.getListSelectedMenu();
    store.getListBulkMenu();

    await store.getLogsFileTypes();
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
        <!-- UT-108 (D3) — the logs bar had the search field and the "Reset"
             button welded into one `InputGroup`, so the row read as a single
             oversized input with a button stuck to its right edge — the
             defect the UT-108 cross-screen probe found on the list
             toolbars. The field and the magnifier are one control and stay
             together; "Reset" acts on the *list*, not on the field, so it is
             a button of its own beside it (the peer contract: media, users,
             roles, permissions, taxonomies, jobs, batches, failed jobs).

             The extension filter stays on its own row below: it is a
             multi-value filter, not part of the search control. -->
        <div class="mt-2 mb-2">
            <div class="logs-toolbar-search flex flex-wrap items-center gap-2 vaah-list-search"
                 style="flex: 1 1 420px; min-width: 260px; max-width: 520px;">
                <InputGroup class="w-full logs-toolbar-field">
                    <InputText aria-label="Search logs" size="small" class="w-full" inputClass="w-full" v-model="store.query.filter.q" @keyup.enter="store.delayedSearch()" @keyup.13="store.delayedSearch()" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" data-testid="logs-action_search_input" />

                    <Button size="small" @click="store.delayedSearch()" data-testid="logs-action_search_button" icon="pi pi-search" aria-label="Search" class="" />
                </InputGroup>

                <Button size="small" class="logs-toolbar-action" :label="root.assets.language_strings.crud_actions.reset_button" data-testid="logs-action_search" @click="store.resetSearch" />
            </div>

            <MultiSelect v-model="store.query.filter.file_type"
                         :options="store.logs_file_types"
                         optionLabel="name" :placeholder="store.assets.language_strings.filter_by_extension"
                         display="chip"
                         size="small"
                         class="w-full my-2"
                         optionValue="value"
                         data-testid="logs-action_filter"
                         @change="store.getList()"
            />
        </div>
        <!--/actions-->
    </div>
</template>

<style scoped>

/* UT-108 (D3) — the peer toolbar's sizing: the field takes the room the
   search cluster has, and the list action beside it keeps its own width and
   never shrinks (below 640px the cluster wraps, so the action drops onto
   its own row). */
.logs-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.logs-toolbar-action {
    flex: 0 0 auto;
}
</style>
