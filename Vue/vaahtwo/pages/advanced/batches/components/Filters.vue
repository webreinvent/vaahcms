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

        <Sidebar v-model:visible="store.show_filters"
                 position="right">

            <VhFieldVertical >
                <template #label>
                    <b>Sort By:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="batches-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort" />
                    <label for="sort-none">None</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="batches-filters-sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">Updated (Ascending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="batches-filters-sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">Updated (Descending)</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>Column:</b>
                </template>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="created_at:desc"
                                 v-model="store.query.filter.dateColumn" />
                    <label for="sort-descending">Created (Descending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="cancelled_at:desc"
                                 v-model="store.query.filter.dateColumn" />
                    <label for="sort-descending">Cancelled (Descending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="finished_at:desc"
                                 v-model="store.query.filter.dateColumn" />
                    <label for="sort-descending">Finished (Descending)</label>
                </div>
            </VhFieldVertical>
            <VhFieldVertical>
                <Calendar inputId="range"
                          v-model="store.query.filter.datesRange"
                          selectionMode="range"
                          :manualInput="false"
                          :hideOnDateTimeSelect="true"
                />
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
