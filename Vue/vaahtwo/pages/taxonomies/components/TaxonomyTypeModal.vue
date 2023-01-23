<script setup>

import {useTaxonomyStore} from "../../../stores/store-taxonomies";

const store = useTaxonomyStore();
</script>

<template>
    <div>
        <div class="p-inputgroup" v-if="store">
            <Dropdown v-model="selectedCity1"
                      :options="cities"
                      optionLabel="name"
                      optionValue="code"
                      placeholder="Select a Parent"
            />

            <InputText class="ml-3 p-inputtext-sm"
                       name="taxonomies-slug"
                       data-testid="taxonomies-slug"
                       v-model="store.item.slug"
            />
            <Button class="p-button-sm"
                    label="Add"
            />
        </div>

        <Divider />

    </div>
</template>
