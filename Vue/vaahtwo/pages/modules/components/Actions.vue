<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import { useModuleStore } from '../../../stores/store-modules'
import {useRootStore} from "../../../stores/root";

const store = useModuleStore();
const root = useRootStore();
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
    <div>

        <!--actions-->
        <div class="flex justify-content-between align-items-center">

            <!--left-->

            <div class="">

                <!--bulk_menu-->
                <Button class="p-button-sm"
                        icon="pi pi-filter"
                        aria-haspopup="true"
                        data-testid="themes-actions"
                        @click="toggleBulkMenuState"
                        :label="store.query.filter.status?store.toLabel(store.query.filter.status):root.assets.language_string.extend_modules.filter_button"
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
                               @keyup.13="store.getList()"
                               data-testid="modules-actions-search"
                               :placeholder="root.assets.language_string.extend_modules.placeholder_search"
                               class="p-inputtext-sm"
                    />


                    <Button class="p-button-sm"
                            icon="pi pi-filter-slash"
                            data-testid="modules-actions-reset-filters"
                            :label="root.assets.language_string.extend_modules.reset_button"
                            @click="store.resetQuery()"
                    />
                </div>
            </div>

            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
