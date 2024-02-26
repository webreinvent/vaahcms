<script  setup>

import { useJobStore } from '../../../../stores/advanced/store-jobs'
import VhFieldVertical from '../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';
import {useRootStore} from "../../../../stores/root";

const root = useRootStore();
const store = useJobStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101;"
        >
            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="jobs-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-none">{{root.assets.language_strings.crud_actions.sort_by_none}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="jobs-filters-sort-ascending"
                                 value="created_at"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-ascending">{{root.assets.language_strings.crud_actions.sort_by_updated_ascending}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="created_at:desc"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-descending">{{root.assets.language_strings.crud_actions.sort_by_updated_descending}}</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>{{store.assets.language_strings.filter_queue}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="default"
                                 data-testid="jobs-queue_defaut"
                                 value="default"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="default">{{store.assets.language_strings.filter_default}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="high"
                                 data-testid="jobs-queue_high"
                                 value="high"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="high">{{store.assets.language_strings.filter_high}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="medium"
                                 data-testid="jobs-queue_medium"
                                 value="medium"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="medium">{{store.assets.language_strings.filter_medium}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="low"
                                 data-testid="jobs-queue_low"
                                 value="low"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="low">{{store.assets.language_strings.filter_low}}</label>
                </div>
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
