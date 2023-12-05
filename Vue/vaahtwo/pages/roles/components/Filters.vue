<script  setup>

import {useRoleStore} from '../../../stores/store-roles'
import { useRootStore } from "../../../stores/root";

import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'

const root = useRootStore();
const store = useRoleStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 style="z-index: 1101"
                 position="right"
        >
            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 value=""
                                 data-testid="role-filter_sort_none"
                                 v-model="store.query.filter.sort"
                    />
                    <label for="sort-none">{{root.assets.language_string.crud_actions.sort_by_none}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 value="updated_at"
                                 data-testid="role-filter_sort_asc"
                                 v-model="store.query.filter.sort"
                    />
                    <label for="sort-ascending">{{root.assets.language_string.crud_actions.sort_by_updated_ascending}})</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 value="updated_at:desc"
                                 data-testid="role-filter_sort_desc"
                                 v-model="store.query.filter.sort"
                    />
                    <label for="sort-descending">{{root.assets.language_string.crud_actions.sort_by_updated_descending}}</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_is_active}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="null"
                                 data-testid="role-filter_status_all"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-all">{{root.assets.language_string.crud_actions.filter_is_active_all}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 value="true"
                                 data-testid="role-filter_status_active_only"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-true">{{root.assets.language_string.crud_actions.filter_only_active}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 value="false"
                                 data-testid="role-filter_status_inactive_only"
                                 v-model="store.query.filter.is_active"
                    />
                    <label for="active-false">{{root.assets.language_string.crud_actions.filter_only_inactive}}</label>
                </div>

            </VhFieldVertical>

            <VhFieldVertical>
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_trashed}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 value=""
                                 data-testid="role-filter_trashed_exclude"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-exclude">{{root.assets.language_string.crud_actions.filter_exclude_trashed}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 value="include"
                                 data-testid="role-filter_trashed_include"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-include">{{root.assets.language_string.crud_actions.filter_include_trashed}}</label>
                </div>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 value="only"
                                 data-testid="role-filter_trashed_only"
                                 v-model="store.query.filter.trashed"
                    />
                    <label for="trashed-only">{{root.assets.language_string.crud_actions.filter_only_trashed}}</label>
                </div>

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
