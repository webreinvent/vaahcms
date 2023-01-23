<script setup>

import {useTaxonomyStore} from "../../../stores/store-taxonomies";

const store = useTaxonomyStore();
</script>

<template>
    <div>
        <div class="p-inputgroup" v-if="store">
            <Dropdown v-model="store.assets.type"
                      :options="store.assets.type"
                      optionLabel="name"
                      optionValue="code"
                      placeholder="Select a Parent"
            />

            <CascadeSelect :options="store.assets.type"
                           optionLabel="name"
                           optionGroupLabel="name"
                           :optionGroupChildren="['countries', 'cities']"
                           style="minWidth: 14rem" placeholder="Select a City"
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
