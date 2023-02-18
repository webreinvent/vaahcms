<script  setup>

import { useJobStore } from '../../../../stores/advanced/store-jobs'
import VhFieldVertical from '../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';


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
                    <b>Sort By:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 data-testid="jobs-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-none">None</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="jobs-filters-sort-ascending"
                                 value="created_at"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-ascending">Created (Ascending)</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="created_at:desc"
                                 v-model="store.query.filter.sort"
                    />

                    <label for="sort-descending">Created (Descending)</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>Queue:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="default"
                                 data-testid="jobs-queue_defaut"
                                 value="default"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="default">Default</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="high"
                                 data-testid="jobs-queue_high"
                                 value="high"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="high">High</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="medium"
                                 data-testid="jobs-queue_medium"
                                 value="medium"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="medium">Medium</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="low"
                                 data-testid="jobs-queue_low"
                                 value="low"
                                 v-model="store.query.filter.queue"
                    />

                    <label for="low">Low</label>
                </div>
            </VhFieldVertical>
        </Sidebar>
    </div>
</template>
