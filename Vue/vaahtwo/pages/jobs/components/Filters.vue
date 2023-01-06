<script  setup>

import { useJobStore } from '../../../stores/store-jobs'
import VhViewRow from '../../../vaahvue/vue-three/primeflex/VhViewRow.vue';


const store = useJobStore();

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
                                 data-testid="jobs-filters-sort-none"
                                 value=""
                                 v-model="store.query.filter.sort" />
                    <label for="sort-none">None</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 data-testid="jobs-filters-sort-ascending"
                                 value="created_at"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">Created (Ascending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 data-testid="jobs-filters-sort-descending"
                                 value="created_at:desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">Created (Descending)</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >

            </VhFieldVertical>

            <VhFieldVertical >

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
