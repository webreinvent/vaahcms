<script setup>

import {useTaxonomyStore} from "../../../stores/store-taxonomies";
import NodeService from "../json/NodeService"
import { onMounted, ref } from "vue";

const store = useTaxonomyStore();

const nodeService = ref(new NodeService());
const nodes = ref();

onMounted( async () => {
    nodeService.value.getTreeNodes().then(data => nodes.value = data);
});
</script>

<template>
    <div>
        <div class="p-inputgroup" v-if="store && store.assets">
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
                        :options="nodes"
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

        <Tree :value="nodes" />
    </div>
</template>
