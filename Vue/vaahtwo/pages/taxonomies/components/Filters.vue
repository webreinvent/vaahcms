<script  setup>

import { useTaxonomyStore } from '../../../stores/store-taxonomies'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
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
                    <b>Type:</b>
                </template>

                <div class="card flex justify-content-center">
                    <MultiSelect v-model="store.query.filter.type"
                                 :options="store.assets.types"
                                 optionLabel="label"
                                 optionValue="data"
                                 placeholder="Select Types"
                                 :maxSelectedLabels="3"
                                 filter
                                 display="chip"
                                 class="w-full md:w-20rem"/>
                </div>
            </VhFieldVertical>

            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="taxonomies-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                    />
                    <label for="sort-none">{{root.assets.language_strings.crud_actions.sort_by_none}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="taxonomies-filters-sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">{{root.assets.language_strings.crud_actions.sort_by_updated_ascending}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="taxonomies-filters-sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">{{root.assets.language_strings.crud_actions.sort_by_updated_descending}}</label>
                </div>
            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_is_active}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="taxonomies-filters-active-all"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-all">{{root.assets.language_strings.crud_actions.filter_is_active_all}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 data-testid="taxonomies-filters-active-true"
                                 value="true"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-true">{{root.assets.language_strings.crud_actions.filter_only_active}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="taxonomies-filters-active-false"
                                 value="false"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-false">{{root.assets.language_strings.crud_actions.filter_only_inactive}}</label>
                </div>
            </VhFieldVertical>

            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_trashed}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 data-testid="taxonomies-filters-trashed-exclude"
                                 value=""
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-exclude">{{root.assets.language_strings.crud_actions.filter_exclude_trashed}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 data-testid="taxonomies-filters-trashed-include"
                                 value="include"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-include">{{root.assets.language_strings.crud_actions.filter_include_trashed}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 data-testid="taxonomies-filters-trashed-only"
                                 value="only"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-only">{{root.assets.language_strings.crud_actions.filter_only_trashed}}</label>
                </div>
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
