<script  setup>

import { useTaxonomyStore } from '../../../stores/store-taxonomies'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'

const store = useTaxonomyStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101"
        >
            <VhFieldVertical>
                <template #label>
                    <b>Sort By:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="taxonomies-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                    />
                    <label for="sort-none">None</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="taxonomies-filters-sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">Updated (Ascending)</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="taxonomies-filters-sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">Updated (Descending)</label>
                </div>
            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical>
                <template #label>
                    <b>Is Active:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="taxonomies-filters-active-all"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-all">All</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 data-testid="taxonomies-filters-active-true"
                                 value="true"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-true">Only Active</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="taxonomies-filters-active-false"
                                 value="false"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-false">Only Inactive</label>
                </div>
            </VhFieldVertical>

            <VhFieldVertical>
                <template #label>
                    <b>Trashed:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 data-testid="taxonomies-filters-trashed-exclude"
                                 value=""
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-exclude">Exclude Trashed</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 data-testid="taxonomies-filters-trashed-include"
                                 value="include"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-include">Include Trashed</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 data-testid="taxonomies-filters-trashed-only"
                                 value="only"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-only">Only Trashed</label>
                </div>
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
