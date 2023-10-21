<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useMediaStore } from '../../../stores/store-media'

import Filters from './Filters.vue'

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
        <div :class="{'flex justify-content-between': store.isViewLarge()}" class="mt-2 mb-2">

            <!--left-->
            <div v-if="store.view === 'large'">

                <!--selected_menu-->
                <Button v-if="store.hasPermission('can-manage-media') || store.hasPermission('can-update-media')"
                        class="p-button-sm"
                        data-testid="media-actions-menu"
                        type="button"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        @click="toggleSelectedMenuState"
                >
                    <i class="pi pi-angle-down"></i>
                    <Badge v-if="store.action.items.length > 0"
                           :value="store.action.items.length"
                    />
                </Button>

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true" />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button class="ml-1 p-button-sm"
                        icon="pi pi-ellipsis-h"
                        data-testid="media-actions-bulk-menu"
                        type="button"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                        @click="toggleBulkMenuState"
                        v-if="store.hasPermission('can-update-media') || store.hasPermission('can-manage-media')"
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
                        <div class="p-inputgroup">
                            <InputText v-model="store.query.filter.q"
                                       class="p-inputtext-sm"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       data-testid="media-actions-search"
                                       placeholder="Search"
                            />

                            <Button @click="store.delayedSearch()"
                                    class="p-button-sm"
                                    data-testid="media-actions-search-button"
                                    icon="pi pi-search"
                            />

                            <Button class="p-button-sm"
                                    label="Filters"
                                    data-testid="media-actions-show-filters"
                                    @click="store.show_filters = true"
                            >
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters"></Badge>
                            </Button>

                            <Button class="p-button-sm"
                                    icon="pi pi-filter-slash"
                                    data-testid="media-actions-reset-filters"
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
