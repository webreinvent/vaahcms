<script  setup>
import VhFieldVertical from '../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';


import {useBatchStore} from '../../../../stores/advanced/store-batches';
const store = useBatchStore();
const dateColumns = [
    {name:"created_at"},
    {name: "updated_at"},
    { name: "finished_at"},
];

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1102"
        >
            <VhFieldVertical>
                <template #label>
                    <b>Column:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="batches-filters-created_at"
                                 value="created_at"
                                 v-model="store.query.filter.date_filter_by"/>
                    <label for="sort-descending">Created</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="batches-filters-cancelled_at"
                                 value="cancelled_at"
                                 v-model="store.query.filter.date_filter_by" />
                    <label for="sort-descending">Cancelled</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="batches-filters-finished_at"
                                 value="finished_at"
                                 v-model="store.query.filter.date_filter_by"/>
                    <label for="sort-descending">Finished</label>
                </div>
            </VhFieldVertical>

            <VhFieldVertical>
                <template #label>
                    <b>Date Between:</b>
                </template>

                <Calendar inputId="range"
                          data-testid="batch"
                          v-model="store.dates2"
                          @date-select="store.setDateRange"
                          selectionMode="range"
                          :manualInput="false"
                />
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
