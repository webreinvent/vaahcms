<script setup>

import {useTaxonomyStore} from "../../../stores/store-taxonomies";

const store = useTaxonomyStore();
</script>

<template>
    <div>
        <div class="p-inputgroup" v-if="store">
<!--            <Dropdown v-model="store.assets.type"-->
<!--                      :options="store.assets.type"-->
<!--                      optionLabel="name"-->
<!--                      optionValue="code"-->
<!--                      placeholder="Select a Parent"-->
<!--            />-->

<!--            <Dropdown v-model="store.item.type"-->
<!--                      :options="store.assets.types"-->
<!--                      optionLabel="name"-->
<!--                      optionValue="id"-->
<!--                      data-testid="taxonomy-type"-->
<!--                      name="taxonomy-type"-->
<!--                      placeholder="Select a parent"-->
<!--            />-->

            <TreeSelect v-model="store.item.type"
                        :options="store.assets.types"
                        :label="store.assets.types.name"
                        placeholder="Select a Parent"
            />

<!--            <CascadeSelect :options="store.assets.type"-->
<!--                           optionLabel="name"-->
<!--                           optionGroupLabel="name"-->
<!--                           :optionGroupChildren="['countries', 'cities']"-->
<!--                           style="minWidth: 14rem"-->
<!--                           placeholder="Select a Parent"-->
<!--            />-->

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

<!--        {{ store.assets.types }}-->
        <div v-for="items in store.assets.types">
            <PanelMenu :model="items"></PanelMenu>

<!--            {{ items }}-->
        </div>

    </div>
</template>
