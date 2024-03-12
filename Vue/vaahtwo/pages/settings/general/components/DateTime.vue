<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useGeneralStore();
</script>

<template>
    <div v-if="store.list && store.assets && root.assets" class="grid">
        <div class="col-4">
            <h5 class="p-1 text-xs mb-1">{{ store.assets.language_strings.date_format }}</h5>

            <div class="p-inputgroup">
                <Dropdown v-model="store.list.date_format"
                          data-testid="general-date_format"
                          :options="store.date_format_options"
                          inputClass="p-inputtext-sm"
                          class="is-small"
                />

                <InputText :placeholder="store.assets.language_strings.placeholder_date_format"
                           v-model="store.list.date_format_custom"
                           data-testid="general-date_format_custom"
                           v-if="store.list.date_format === 'custom'"
                           class="p-inputtext-sm"
                />

                <Button icon="pi pi-copy"
                        data-testid="general-date_format_copy"
                        @click="store.getCopy('date_format')"
                        class="p-button-sm"
                />
            </div>
        </div>

        <div class="col-4">
            <h5 class="p-1 text-xs mb-1">{{ store.assets.language_strings.time_format }}</h5>

            <div class="p-inputgroup">
                <Dropdown v-model="store.list.time_format"
                          data-testid="general-time_format"
                          :options="store.time_format_options"
                          inputClass="p-inputtext-sm"
                          class="is-small"
                />

                <InputText :placeholder="store.assets.language_strings.placeholder_time_format"
                           v-model="store.list.time_format_custom"
                           data-testid="general-time_format_custom"
                           v-if="store.list.time_format === 'custom'"
                           class="p-inputtext-sm"
                />

                <Button icon="pi pi-copy"
                        data-testid="general-time_format_copy"
                        @click="store.getCopy('time_format')"
                        class="p-button-sm"
                />
            </div>
        </div>

        <div class="col-4">
            <h5 class="p-1 text-xs mb-1">{{ store.assets.language_strings.date_time_format }}</h5>
            <div class="p-inputgroup">
                <Dropdown v-model="store.list.datetime_format"
                          data-testid="general-datetime_format"
                          :options="store.date_time_format_options"
                          inputClass="p-inputtext-sm"
                          class="is-small"
                />

                <InputText :placeholder="store.assets.language_strings.placeholder_time_date_format"
                           v-model="store.list.datetime_format_custom"
                           data-testid="general-datetime_format_custom"
                           v-if="store.list.datetime_format === 'custom'"
                           class="p-inputtext-sm"

                />

                <Button icon="pi pi-copy"
                        data-testid="general-datetime_format_copy"
                        @click="store.getCopy('datetime_format')"
                        class="p-button-sm"
                />
            </div>
        </div>

        <div class="col-12">
            <Divider class="mt-0 mb-3"/>
            <Button :label="store.assets.language_strings.date_and_time_save_button"
                    @click="store.storeSiteSettings()"
                    data-testid="general-date_format_save"
                    icon="pi pi-save"
                    class="p-button-sm"
            />
        </div>
    </div>
</template>
