<script  setup>
import { useFailedJobStore } from '../../../../stores/advanced/store-failedjobs'
import VhFieldVertical from '../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';
import {useRootStore} from "../../../../stores/root";

const root = useRootStore();
const store = useFailedJobStore();

</script>

<template>
    <div>
        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1102"
        >
            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="failedjobs-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-none">{{root.assets.language_strings.crud_actions.sort_by_none}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="failedjobs-filters-sort-ascending"
                                 value="failed_at"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-ascending">{{root.assets.language_strings.crud_actions.sort_by_updated_ascending}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="failedjobs-filters-sort-descending"
                                 value="failed_at:desc"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-descending">{{root.assets.language_strings.crud_actions.sort_by_updated_descending}}</label>
                </div>
            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical>
                <label for="range">Range</label>
                <Calendar inputId="range"
                          data-testid="failedjobs-filters-range"
                          v-model="store.dates2"
                          @date-select="store.setDateRange"
                          selectionMode="range"
                          dateFormat="yy-mm-dd"
                          :manualInput="false"
                />
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
