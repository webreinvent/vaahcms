<script  setup>

import { useMediaStore } from '../../../stores/store-media';
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue';
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
const store = useMediaStore();
</script>

<template>
    <div>

        <Drawer v-model:visible="store.show_filters"
                 position="right"
                 style="z-index: 1101"
        >

            <VhFieldVertical>
                <template #label>
                    <b>{{store.assets.language_strings.filter_month}}:</b>
                </template>

                <!-- M6-T1 — the labels pointed at ids that no control
                     carried: v4's RadioButton and Checkbox render their
                     input with `:id="inputId"`, and no `inputId` was given,
                     so `for="sort-none"` matched nothing and the control
                     had no accessible name at all. Each control now carries
                     the id its label points at.

                     The radios of one filter also share a single `name`,
                     which is what makes them one group — "None" and the
                     twelve months are alternatives of the same value, not
                     two groups. (The v-model already implied that; the
                     markup now says it.) -->
                <div class="field-radiobutton">
                    <RadioButton name="media-filter-month"
                                 inputId="media-filter-month-none"
                                 data-testid="media-filters-date-month-all"
                                 value=""
                                 v-model="store.query.filter.month" />
                    <label for="media-filter-month-none">{{root.assets.language_strings.crud_actions.sort_by_none}}</label>
                </div>
                <div class="field-radiobutton" v-for="month in store.assets.date.month">
                    <RadioButton name="media-filter-month"
                                 :inputId="'media-filter-month-' + month.month"
                                 data-testid="media-filters-date-month"
                                 :value="month.month"
                                 v-model="store.query.filter.month" />
                    <label :for="'media-filter-month-' + month.month">{{ month.month }}</label>
                </div>
            </VhFieldVertical>

            <Divider/>

            <VhFieldVertical >
                <template #label>
                    <b>{{store.assets.language_strings.filter_year}}:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="media-filter-year"
                                 inputId="media-filter-year-none"
                                 value=""
                                 data-testid="media-filters-date-year-all"
                                 v-model="store.query.filter.year" />
                    <label for="media-filter-year-none">{{root.assets.language_strings.crud_actions.filter_is_active_all}}</label>
                </div>
                <div class="field-radiobutton" v-for="item in store.assets.date.year">
                    <RadioButton name="media-filter-year"
                                 :inputId="'media-filter-year-' + item.year"
                                 data-testid="media-filters-date-year"
                                 :value="item.year"
                                 v-model="store.query.filter.year" />
                    <label :for="'media-filter-year-' + item.year">{{ item.year}}</label>
                </div>
            </VhFieldVertical>

            <VhFieldVertical >
                <template #label>
                    <b>{{root.assets.language_strings.crud_actions.filter_trashed}}:</b>
                </template>
                <div class="field-radiobutton">
                    <Checkbox v-model="store.query.filter.trashed"
                              inputId="media-filter-trashed"
                              data-testid="media-filters-include_trashed"
                              :binary="true"
                    />
                    <label for="media-filter-trashed">{{store.assets.language_strings.filter_with_trashed}}</label>
                </div>

            </VhFieldVertical>
            <VhFieldVertical >
                <template #label>
                    <b>{{store.assets.language_strings.filter_date}}:</b>
                </template>
                <div class="field-radiobutton">
                    <!-- M6-T1 — v4's DatePicker has no icon unless it is
                         asked for one (`showIcon` defaults to false), so the
                         date filter rendered as an empty box with no
                         affordance at all. The icon is the peer pattern of
                         the app (the registrations form's date of birth
                         field), and the placeholder names the range. -->
                    <DatePicker inputId="range"
                              data-testid="media-filters-dates"
                              v-model="store.dates2"
                              @date-select="store.setDateRange"
                              selectionMode="range"
                              :manualInput="false"
                              :showIcon="true"
                              iconDisplay="input"
                              placeholder="Select range" />
                </div>

            </VhFieldVertical>
        </Drawer>

    </div>
</template>
