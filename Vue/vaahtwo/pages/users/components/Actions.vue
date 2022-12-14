<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useUserStore } from '../../../stores/store-users'

import Filters from './Filters.vue'

const store = useUserStore();

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
                        :badge="store.action.items.length"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        @click="toggleSelectedMenuState"
                />

                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true"
                />
                <!--/selected_menu-->

                <!--bulk_menu-->
                <Button class="p-button-sm ml-1"
                        icon="pi pi-ellipsis-h"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                        @click="toggleBulkMenuState"
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
                            <InputText class="p-inputtext-sm"
                                       type="text"
                                       v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       placeholder="Search"
                            />

                            <Button class="p-button-sm"
                                    icon="pi pi-search"
                                    @click="store.delayedSearch()"
                            />

                            <Button class="p-button-sm"
                                    label="Filters"
                                    @click="store.show_filters = true"
                                    :badge="store.count_filters"
                            />

                            <Button class="p-button-sm"
                                    label="Reset"
                                    icon="pi pi-filter-slash"
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
