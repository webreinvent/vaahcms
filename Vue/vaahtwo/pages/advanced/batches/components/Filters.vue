<script  setup>
import VhFieldVertical from '../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';


import {useBatchStore} from '../../../../stores/store-batches';
const store = useBatchStore();
const dateColumns = [
    {name:"created_at"},
    {name: "updated_at"},
    { name: "finished_at"},
];

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters" position="right">
            <VhFieldVertical >
                <template #label>
                    <b>Column:</b>
                </template>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="created_at:desc"
                                 v-model="store.query.date_filter_by" />
                    <label for="sort-descending">Created (Descending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="cancelled_at:desc"
                                 v-model="store.query.date_filter_by" />
                    <label for="sort-descending">Cancelled (Descending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="finished_at:desc"
                                 v-model="store.query.date_filter_by" />
                    <label for="sort-descending">Finished (Descending)</label>
                </div>
            </VhFieldVertical>
            <VhFieldVertical>
                <Calendar inputId="range"
                          v-model="store.dates2"
                          @date-select="store.setDateRange"
                          selectionMode="range"
                          :manualInput="false" />
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
