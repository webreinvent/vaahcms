<script  setup>

import { usePermissionStore } from '../../../stores/store-permissions'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'

const store = usePermissionStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 style="z-index: 1001"
                 position="right">

            <VhFieldVertical >
                <template #label>
                    <b>Sort By:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 value=""
                                 v-model="store.query.filter.sort" />
                    <label for="sort-none">None</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">Updated (Ascending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">Updated (Descending)</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>Is Active:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="permission-filter_active_all"
                                 v-model="store.query.filter.is_active" />
                    <label for="active-all">All</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 value="true"
                                 data-testid="permission-filter_active_only"
                                 v-model="store.query.filter.is_active" />
                    <label for="active-true">Only Active</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 value="false"
                                 data-testid="permission-filter_inactive_only"
                                 v-model="store.query.filter.is_active" />
                    <label for="active-false">Only Inactive</label>
                </div>

            </VhFieldVertical>

            <VhFieldVertical >
                <template #label>
                    <b>Trashed:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 value=""
                                 data-testid="permission-filter_trashed_exclude"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-exclude">Exclude Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 value="include"
                                 data-testid="permission-filter_trashed_include"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-include">Include Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 value="only"
                                 data-testid="permission-filter_trashed_only"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-only">Only Trashed</label>
                </div>

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
