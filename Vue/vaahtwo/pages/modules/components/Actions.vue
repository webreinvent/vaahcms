<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useModuleStore } from '../../../stores/store-modules'

import Filters from './Filters.vue'

const store = useModuleStore();

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
        <div class="flex justify-content-between">

            <!--left-->

            <div class="col-4 mb-5">
                <Dropdown v-model="store.query.status"
                          :options="store.statusList"
                          optionLabel="name"
                          optionValue="value"
                          placeholder="Select a filter">
                </Dropdown>
            </div>
            <!--/left-->

            <!--right-->
            <div class="col-5 col-offset-3 mb-5">
                <div class="p-inputgroup">
                    <InputText v-model="store.query.q"
                               @keyup.enter="store.delayedSearch()"
                               @keyup.enter.native="store.delayedSearch()"
                               @keyup.13="store.getList()"
                               data-testid="modules-actions-search"
                               placeholder="Search"/>
                    <Button
                        type="button"
                        class="p-button-sm"
                        data-testid="modules-actions-show-filters"
                        @click="store.delayedSearch()">
                        Filters
                    </Button>
                    <Button
                        type="button"
                        icon="pi pi-filter-slash"
                        data-testid="modules-actions-reset-filters"
                        class="p-button-sm"
                        label="Reset"
                        @click="store.resetQuery()" />
                </div>
            </div>

            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
