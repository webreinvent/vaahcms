<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useRegistrationStore } from '../../../stores/store-registrations'

import Filters from './Filters.vue'

const store = useRegistrationStore();

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
                <Button class="p-button-sm"
                        @click="toggleSelectedMenuState"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        data-testid="register-toggle_list_selected_menu"
                        v-if="store.hasPermission('can-update-registrations') || store.hasPermission('can-manage-registrations')"
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
                        @click="toggleBulkMenuState"
                        aria-haspopup="true"
                        aria-controls="bulk_menu_state"
                        data-testid="register-toggle_list_bulk_menu"
                        v-if="store.hasPermission('can-update-registrations') || store.hasPermission('can-manage-registrations')"
                >
                </Button>

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
                        <div class="p-inputgroup ">
                            <InputText v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       placeholder="Search"
                                       name="register-search_query_filter_q"
                                       data-testid="register-search_query_filter_q"
                                       class="p-inputtext-sm"
                            />

                            <Button class="p-button-sm"
                                    @click="store.delayedSearch()"
                                    icon="pi pi-search"
                                    data-testid="register-search_icon_query_filter_q"
                            />

                            <Button label="Filters"
                                    class="p-button-sm"
                                    @click="store.show_filters = true"
                                    data-testid="register-show_filters"
                            >
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters" />
                            </Button>

                            <Button icon="pi pi-filter-slash"
                                    class="p-button-sm"
                                    label="Reset"
                                    @click="store.resetQuery()"
                                    data-testid="register-reset_query"
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
