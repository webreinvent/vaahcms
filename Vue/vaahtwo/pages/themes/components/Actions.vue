<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useThemeStore } from '../../../stores/store-themes'

import Filters from './Filters.vue'

const store = useThemeStore();

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
        <div :class="{'flex justify-content-between': store.isViewLarge()}">

            <!--left-->
            <div v-if="store.view === 'large'"></div>
            <!--/left-->

            <!--right-->
            <div >


                <div class="grid p-fluid">


                    <div class="col-12">
                        <div class="p-inputgroup ">

                            <InputText v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       data-testid="themes-actions-search"
                                       placeholder="Search"/>
                            <Button @click="store.delayedSearch()"
                                    data-testid="themes-actions-search-button"
                                    icon="pi pi-search"/>
                            <Button
                                type="button"
                                class="p-button-sm"
                                data-testid="themes-actions-show-filters"
                                @click="store.show_filters = true">
                                Filters
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters"></Badge>
                            </Button>

                            <Button
                                type="button"
                                icon="pi pi-filter-slash"
                                data-testid="themes-actions-reset-filters"
                                class="p-button-sm"
                                label="Reset"
                                @click="store.resetQuery()" />

                        </div>
                    </div>


                    <Filters/>

                </div>

            </div>
            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
