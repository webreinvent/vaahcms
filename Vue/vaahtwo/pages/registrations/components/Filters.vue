<script  setup>

import { useRegistrationStore } from '../../../stores/store-registrations'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'

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
                    <b>Sort By:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="sort-none"
                                 value=""
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_none"
                    />
                    <label for="sort-none">None</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-ascending"
                                 value="updated_at"
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_ascending"
                    />
                    <label for="sort-ascending">Updated (Ascending)</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="sort-descending"
                                 value="updated_at:desc"
                                 v-model="store.query.filter.sort"
                                 data-testid="register-query_filter_sort_descending"
                    />
                    <label for="sort-descending">Updated (Descending)</label>
                </div>

            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>Trashed:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude"
                                 value=""
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_exclude"
                    />
                    <label for="trashed-exclude">Exclude Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-include"
                                 value="include"
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_include"
                    />
                    <label for="trashed-include">Include Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-only"
                                 value="only"
                                 v-model="store.query.filter.trashed"
                                 data-testid="register-query_filter_trashed_only"
                    />
                    <label for="trashed-only">Only Trashed</label>
                </div>

            </VhFieldVertical>

            <Divider/>
            <VhFieldVertical >
                <template #label>
                    <b>Status:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="email-verification-pending"
                                 value="email-verification-pending"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_email_verification_pending"
                    />
                    <label for="email-verification-pending">Email Verification Pending</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="email-verified"
                                 value="email-verified"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_email_verified"
                    />
                    <label for="email-verified">Email Verified</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="user-created"
                                 value="user-created"
                                 v-model="store.query.filter.status"
                                 data-testid="register-query_filter_status_user-created"
                    />
                    <label for="user-created">User Created</label>
                </div>

            </VhFieldVertical>


        </Sidebar>

    </div>
</template>
