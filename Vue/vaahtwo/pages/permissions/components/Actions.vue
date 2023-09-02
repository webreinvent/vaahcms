<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { usePermissionStore } from '../../../stores/store-permissions'

import Filters from './Filters.vue'

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
        <div :class="{'flex justify-content-between': store.isViewLarge()}"
             class="mt-2 mb-2">

            <!--left-->
            <div v-if="store.view === 'large'">

                <!--selected_menu-->
                <Button class="p-button-sm"
                        type="button"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        @click="toggleSelectedMenuState"
                        v-if="store.hasPermission('can-manage-permissions') || store.hasPermission('can-update-permissions')"
                >
                    <i class="pi pi-angle-down"></i>
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
                        type="button"
                        @click="toggleBulkMenuState"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                        v-if="store.hasPermission('can-manage-permissions') || store.hasPermission('can-update-permissions')"
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
                            <InputText class="p-inputtext-sm"
                                       v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       placeholder="Search"
                                       data-testid="permission-action_search_input"
                            />

                            <Button @click="store.delayedSearch()"
                                    icon="pi pi-search"
                                    class="p-button-sm"
                                    data-testid="permission-action_search"
                            />

                            <Button class="p-button-sm"
                                    type="button"
                                    @click="store.show_filters = true"
                                    data-testid="permission-action_filter"
                            >
                                Filters
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters" />
                            </Button>

                            <Button class="p-button-sm"
                                    type="button"
                                    icon="pi pi-filter-slash"
                                    label="Reset"
                                    data-testid="permission-action_filter_reset"
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
