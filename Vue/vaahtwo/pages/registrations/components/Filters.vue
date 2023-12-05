<script  setup>

import { useRegistrationStore } from '../../../stores/store-registrations'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
const store = useRegistrationStore();

</script>

<template>
    <div>

        <Sidebar v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101"
        >
            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_sort_by}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_none"
                    />
                    <label for="sort-none">{{root.assets.language_string.crud_actions.sort_by_none}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_ascending"
                    />
                    <label for="sort-ascending">{{root.assets.language_string.crud_actions.sort_by_updated_ascending}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_descending"
                    />
                    <label for="sort-descending">{{root.assets.language_string.crud_actions.sort_by_updated_descending}}</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_trashed}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 value=""
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_exclude"
                    />
                    <label for="trashed-exclude">{{root.assets.language_string.crud_actions.filter_exclude_trashed}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 value="include"
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_include"
                    />
                    <label for="trashed-include">{{root.assets.language_string.crud_actions.filter_include_trashed}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 value="only"
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_only"
                    />
                    <label for="trashed-only">{{root.assets.language_string.crud_actions.filter_only_trashed}}</label>
                </div>

            </VhFieldVertical>

            <Divider/>
            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_string.crud_actions.filter_status}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="email-verification-pending"
                                 value="email-verification-pending"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_email_verification_pending"
                    />
                    <label for="email-verification-pending">{{root.assets.language_string.registrations.filter_email_verification_pending}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="email-verified"
                                 value="email-verified"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_email_verified"
                    />
                    <label for="email-verified">{{root.assets.language_string.registrations.filter_email_verified}}</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="user-created"
                                 value="user-created"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_user-created"
                    />
                    <label for="user-created">{{root.assets.language_string.registrations.filter_user_created}}</label>
                </div>

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
