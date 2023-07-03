<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useTaxonomyStore } from '../../../stores/store-taxonomies'

import Filters from './Filters.vue'

const store = useTaxonomyStore();

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
    <div >

        <!--actions-->
        <div :class="{'flex justify-content-between': store.isViewLarge()}" class="mt-2 mb-2">

            <!--left-->
            <div v-if="store.view === 'large'">

                <!--selected_menu-->
                <Button v-if="store.hasPermission('can-update-taxonomies') || store.hasPermission('can-manage-taxonomies')"
                        class="p-button-sm"
                        type="button"
                        @click="toggleSelectedMenuState"
                        data-testid="taxonomies-actions-menu"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
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
                <Button class="p-button-sm ml-1"
                        icon="pi pi-ellipsis-h"
                        @click="toggleBulkMenuState"
                        data-testid="taxonomies-actions-bulk-menu"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                        v-if="store.hasPermission('can-update-taxonomies') || store.hasPermission('can-manage-taxonomies')"
                />

                <Menu ref="bulk_menu_state"
                      :model="store.list_bulk_menu"
                      :popup="true" />
                <!--/bulk_menu-->

            </div>
            <!--/left-->

            <!--right-->
            <div>
                <div class="grid p-fluid">
                    <div class="col-12">
                        <div class="p-inputgroup">

                            <InputText class="p-inputtext-sm"
                                       v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       data-testid="taxonomies-actions-search"
                                       placeholder="Search"
                            />

                            <Button @click="store.delayedSearch()"
                                    class="p-button-sm"
                                    data-testid="taxonomies-actions-search-button"
                                    icon="pi pi-search"
                            />

                            <Button class="p-button-sm"
                                    label="Filters"
                                    type="button"
                                    data-testid="taxonomies-actions-show-filters"
                                    @click="store.show_filters = true"
                            >
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters"/>
                            </Button>

                            <Button class="p-button-sm"
                                    type="button"
                                    icon="pi pi-filter-slash"
                                    data-testid="taxonomies-actions-reset-filters"
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
