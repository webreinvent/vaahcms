<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useThemeStore } from '../../../stores/store-themes'

import Filters from './Filters.vue'

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
        <div class="flex justify-content-between align-items-center">

            <!--left-->
                <div>

                    <Button class="p-button-sm"
                            icon="pi pi-filter"
                            aria-haspopup="true"
                            data-testid="themes-actions"
                            @click="toggleBulkMenuState"
                            :label="store.query.filter.status?store.toLabel(store.query.filter.status):'Filter'"

                    />

                    <Menu ref="bulk_menu_state"
                          :model="store.status_list"
                          :popup="true"
                    />
                    <!--/bulk_menu-->
                </div>


            <!--/left-->

            <!--right-->

                <div class="">
                    <div class="p-inputgroup">
                        <InputText v-model="store.query.filter.q"
                                   @keyup.enter="store.delayedSearch()"
                                   @keyup.enter.native="store.delayedSearch()"
                                   @keyup.13="store.delayedSearch()"
                                   data-testid="themes-actions-search-input"
                                   placeholder="Search"
                                   class="p-inputtext-sm"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-filter-slash"
                                data-testid="themes-actions-reset-filters"
                                label="Reset"
                                @click="store.resetQuery()"
                        />
                    </div>
                </div>
            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
