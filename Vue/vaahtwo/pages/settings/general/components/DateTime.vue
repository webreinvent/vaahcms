<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useGeneralStore();
</script>

<template>
    <div v-if="store.list && store.assets && root.assets" class="grid">
        <div class="col-4">
            <div class="p-1 vaah-type-caption mb-1" id="gd-date-format">{{ store.assets.language_strings.date_format }}</div>

            <InputGroup>
                <Select aria-labelledby="gd-date-format" size="small" v-model="store.list.date_format" data-testid="general-date_format" :options="store.date_format_options" inputClass="" class="vc-dense" />

                <InputText aria-labelledby="gd-date-format" size="small" :placeholder="store.assets.language_strings.placeholder_date_format" v-model="store.list.date_format_custom" data-testid="general-date_format_custom" v-if="store.list.date_format === 'custom'" class="" />

                <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-date_format_copy" @click="store.getCopy('date_format')" class="" />
            </InputGroup>
        </div>

        <div class="col-4">
            <div class="p-1 vaah-type-caption mb-1" id="gd-time-format">{{ store.assets.language_strings.time_format }}</div>

            <InputGroup>
                <Select aria-labelledby="gd-time-format" size="small" v-model="store.list.time_format" data-testid="general-time_format" :options="store.time_format_options" inputClass="" class="vc-dense" />

                <InputText aria-labelledby="gd-time-format" size="small" :placeholder="store.assets.language_strings.placeholder_time_format" v-model="store.list.time_format_custom" data-testid="general-time_format_custom" v-if="store.list.time_format === 'custom'" class="" />

                <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-time_format_copy" @click="store.getCopy('time_format')" class="" />
            </InputGroup>
        </div>

        <div class="col-4">
            <div class="p-1 vaah-type-caption mb-1" id="gd-date-time-format">{{ store.assets.language_strings.date_time_format }}</div>
            <InputGroup>
                <Select aria-labelledby="gd-date-time-format" size="small" v-model="store.list.datetime_format" data-testid="general-datetime_format" :options="store.date_time_format_options" inputClass="" class="vc-dense" />

                <InputText aria-labelledby="gd-date-time-format" size="small" :placeholder="store.assets.language_strings.placeholder_time_date_format" v-model="store.list.datetime_format_custom" data-testid="general-datetime_format_custom" v-if="store.list.datetime_format === 'custom'" class="" />

                <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-datetime_format_copy" @click="store.getCopy('datetime_format')" class="" />
            </InputGroup>
        </div>

        <div class="col-12">
            <Divider class="mt-0 mb-3"/>
            <Button size="small" :label="store.assets.language_strings.date_and_time_save_button" @click="store.storeSiteSettings()" data-testid="general-date_format_save" icon="pi pi-save" class="" />
        </div>
    </div>
</template>
