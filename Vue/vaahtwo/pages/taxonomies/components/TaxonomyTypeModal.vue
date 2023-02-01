<script setup>

import { useTaxonomyStore } from "../../../stores/store-taxonomies";

const store = useTaxonomyStore();

</script>

<template>
    <div>
        <div class="p-inputgroup" v-if="store && store.assets">

            <TreeSelect v-model="store.item.type"
                        :options="store.assets.types"
                        placeholder="Select a Parent"
            />

            <InputText class="p-inputtext-sm"
                       name="taxonomies-slug"
                       data-testid="taxonomies-slug"
                       v-model="store.taxonomy_type_items.name"
            />

            <Button class="p-button-sm"
                    label="Add"
                    @click="store.addTaxonomyType()"
            />
        </div>

        <Divider />

<!--        <Tree :value="nodes" />-->

        <Tree :value="store.assets.types" selectionMode="single" />
    </div>
</template>
