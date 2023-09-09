<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useLogStore } from '../../../../stores/advanced/store-logs'

import Filters from './Filters.vue'

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
        <div class="p-inputgroup">
            <InputText class="p-inputtext-sm"
                       inputClass="w-full"
                       v-model="store.query.filter.q"
                       @keyup.enter="store.delayedSearch()"
                       @keyup.enter.native="store.delayedSearch()"
                       @keyup.13="store.delayedSearch()"
                       placeholder="Search"
                       data-testid="logs-action_search_input"
            />

            <Button label="Reset"
                    class="p-button-sm"
                    data-testid="logs-action_search"
                    @click="store.resetSearch"
            />
        </div>

        <MultiSelect v-model="store.query.filter.file_type"
                     :options="store.logs_file_types"
                     optionLabel="name" placeholder="Filter By Extension"
                     display="chip"
                     class="w-full mt-2 p-inputtext-sm"
                     optionValue="value"
                     data-testid="logs-action_filter"
                     @change="store.getList()"

        />
        <!--/actions-->
    </div>
</template>
