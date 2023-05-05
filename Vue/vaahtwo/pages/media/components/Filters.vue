<script  setup>

import { useMediaStore } from '../../../stores/store-media';
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';

const store = useMediaStore();
</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101"
        >

            <VhFieldVertical>
                <template #label>
                    <b>Month:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="media-filters-date-month-all"
                                 value=""
                                 v-model="store.query.filter.month" />
                    <label for="sort-none">None</label>
                </div>
                <div class="field-radiobutton" v-for="month in store.assets.date.month">
                    <RadioButton name="sort-ascending"
                                 data-testid="media-filters-date-month"
                                 :value="month.month"
                                 v-model="store.query.filter.month" />
                    <label for="sort-ascending">{{ month.month }}</label>
                </div>
            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>Year:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value=""
                                 data-testid="media-filters-date-year-all"
                                 v-model="store.query.filter.year" />
                    <label for="active-all">All</label>
                </div>
                <div class="field-radiobutton" v-for="item in store.assets.date.year">
                    <RadioButton name="active-true"
                                 data-testid="media-filters-date-year"
                                 :value="item.year"
                                 v-model="store.query.filter.year" />
                    <label for="active-true">{{ item.year}}</label>
                </div>
            </VhFieldVertical>

            <VhFieldVertical >
                <template #label>
                    <b>Trashed:</b>
                </template>
                <div class="field-radiobutton">
                    <Checkbox v-model="store.query.filter.trashed"
                              data-testid="media-filters-include_trashed"
                              :binary="true"
                    />
                    <label for="trashed-only">with Trashed</label>
                </div>

            </VhFieldVertical>
            <VhFieldVertical >
                <template #label>
                    <b>Dates:</b>
                </template>
                <div class="field-radiobutton">
                    <Calendar inputId="range"
                              data-testid="media-filters-dates"
                              v-model="store.dates2"
                              @date-select="store.setDateRange"
                              selectionMode="range"
                              :manualInput="false" />
                </div>

            </VhFieldVertical>
        </Sidebar>

    </div>
</template>
