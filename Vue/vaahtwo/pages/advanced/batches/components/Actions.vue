<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useBatchStore } from '../../../../stores/advanced/store-batches'

import Filters from './Filters.vue'

const store = useBatchStore();

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
            <div v-if="store.view === 'large'">

                <!--selected_menu-->
                <Button class="p-button-sm"
                        icon="pi pi-angle-down"
                        @click="toggleSelectedMenuState"
                        data-testid="batches-actions-menu"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                >
                    <Badge v-if="store.action.items.length > 0"
                           :value="store.action.items.length"
                    />
                </Button>

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true"
                />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button class="p-button-sm ml-1"
                        icon="pi pi-ellipsis-h"
                        @click="toggleBulkMenuState"
                        data-testid="batches-actions-bulk-menu"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                    />

                <Menu ref="bulk_menu_state"
                      :model="store.list_bulk_menu"
                      :popup="true"
                />
                <!--/bulk_menu-->
            </div>
            <!--/left-->

            <!--right-->
            <div>
                <div class="grid p-fluid">
                    <div class="col-12">
                        <div class="p-inputgroup ">
                            <InputText v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       data-testid="batches-actions-search"
                                       placeholder="Search"
                                       class="p-inputtext-sm"
                            />

                            <Button @click="store.delayedSearch()"
                                    data-testid="batches-actions-search-button"
                                    icon="pi pi-search"
                                    class="p-button-sm"
                            />
                            <Button class="p-button-sm"
                                    label="Filters"
                                    data-testid="batches-actions-show-filters"
                                    @click="store.show_filters = true"
                            >
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters" />
                            </Button>

                            <Button class="p-button-sm"
                                    icon="pi pi-filter-slash"
                                    data-testid="batches-actions-reset-filters"
                                    label="Reset"
                                    @click="store.resetQuery()"
                            />
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
