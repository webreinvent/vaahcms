<script  setup>

import {useNotificationStore} from "../../../../stores/settings/store-notification";
import VhFieldVertical from './../../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useNotificationStore();

</script>

<template>
    <div>


        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101"
        >
            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 value=""
                                 data-testid="notification-setting-filter_sort_none"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-none">{{root.assets.language_strings.crud_actions.sort_by_none}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 value="updated_at"
                                 data-testid="notification-setting-filter_sort_asc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-ascending">{{root.assets.language_strings.crud_actions.sort_by_updated_ascending}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 value="updated_at:desc"
                                 data-testid="notification-setting-filter_sort_desc"
                                 v-model="store.query.filter.sort" />
                    <label for="sort-descending">{{root.assets.language_strings.crud_actions.sort_by_updated_descending}}</label>
                </div>

            </VhFieldVertical>

            <Divider/>



            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_trashed}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 value=""
                                 data-testid="notification-setting-filter_trash_exclude"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-exclude">{{root.assets.language_strings.crud_actions.filter_exclude_trashed}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 value="include"
                                 data-testid="notification-setting-filter_trash_include"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-include">{{root.assets.language_strings.crud_actions.filter_include_trashed}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 value="only"
                                 data-testid="notification-setting-filter_trash_only"
                                 v-model="store.query.filter.trashed" />
                    <label for="trashed-only">{{root.assets.language_strings.crud_actions.filter_only_trashed}}</label>
                </div>

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
