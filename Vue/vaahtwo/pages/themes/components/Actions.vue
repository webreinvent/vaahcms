<script  setup>
import {ref, onMounted} from 'vue';
import { useThemeStore } from '../../../stores/store-themes'
import {useRootStore} from "../../../stores/root";

const root = useRootStore();
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
                            :label="store.query.filter.status?store.toLabel(store.query.filter.status):root.assets.language_string.extend_themes.filter_button"

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
                                   :placeholder="root.assets.language_string.extend_themes.placeholder_search"
                                   class="p-inputtext-sm"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-filter-slash"
                                data-testid="themes-actions-reset-filters"
                                :label="root.assets.language_string.extend_themes.reset_button"
                                @click="store.resetQuery()"
                        />
                    </div>
                </div>
            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
