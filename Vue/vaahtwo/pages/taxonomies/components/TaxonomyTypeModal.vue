<script setup>

import { useTaxonomyStore } from "../../../stores/store-taxonomies";
import {ref} from "vue";

const store = useTaxonomyStore();

const selectedNode = ref();

</script>

<template>
    <div>
        <div class="p-inputgroup mt-2" v-if="store && store.assets">

            <TreeSelect v-model="selectedNode"
                        :options="store.assets.types"
                        placeholder="Select a Parent"
                        @node-select="store.selectedNode"
                        name="parent-taxonomies-type-name"
                        data-testid="parent-taxonomies-type-name"
            />

            <InputText class="p-inputtext-sm"
                       name="child-taxonomies-type-slug"
                       data-testid="child-taxonomies-type-slug"
                       v-model="store.taxonomy_type_items.name"
            />

            <Button class="p-button-sm"
                    label="Add"
                    @click="store.createTaxonomyType()"
            />
        </div>

        <Divider />

        <Tree :value="store.assets.types" selectionMode="single" />
    </div>
</template>
