<script setup>

import { useTaxonomyStore } from "../../../stores/store-taxonomies";
import { ref } from "vue";
import { vaah } from "../../../vaahvue/pinia/vaah";
import { TreeView } from "@grapoza/vue-tree";
import Loader from "../../../vaahvue/vue-three/primeflex/Loader.vue"

const store = useTaxonomyStore();
const useVaah = vaah();
const selectedNode = ref();
const tree_data = ref([]);
const editLabel = ref(false);

const openEditNode = () => {
    editLabel.value = true ?? false
}

const modelDefaults = {
    expanderTitle: 'Expand this node',
    draggable: true,
    allowDrop: true,
    deletable:true,
    state: {
        expanded: false
    },

    customizations: {
        classes: {
            treeViewNodeSelfExpander: 'action-button',
            treeViewNodeSelfExpandedIndicator: 'pi  pi-chevron-right',
            treeViewNodeSelfAction: 'action-button',
            treeViewNodeSelfAddChildIcon: 'pi pi-plus',
        }
    }
}

const cloneAction = () => {
    console.log('draggable clone method');
}
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

            <InputText class="p-inputtext-sm border-noround"
                       name="child-taxonomies-type-slug"
                       data-testid="child-taxonomies-type-slug"
                       v-model="store.taxonomy_type_items.name"
            />

            <Button class="p-button-sm"
                    label="Add"
                    @click="store.createTaxonomyType"
            />
        </div>

        <Divider />

        <div class="field col-12 md:col-6 custom-skeleton" v-if="store.is_loading === true">
            <Loader />
        </div>

        <div class="draggable-tree-list" v-if="store && store.assets && store.assets.types && store.is_loading === false">
            <TreeView ref="tree_data" :initialModel="store.assets.types"
                      :model-defaults="modelDefaults"
            >
                <template v-slot:text="{ model, customClasses }">
                    <div class="list-item">
                        <span>
                            <p class="inline cursor-pointer"
                               v-if="!store.edit_tree_label_array.includes(model.id)"
                               @click="useVaah.copy(model.data)"
                               v-tooltip.top=" 'Copy Slug' "
                            >
                                <span><i class="pi pi-folder mr-1"></i> {{ model.label }} </span>
                            </p>

                            <InputText @input="store.setTaxonomyTypeNewName(model.label)"
                                       v-model="model.label"
                                       v-if="store.edit_tree_label_array.includes(model.id)"
                            />

                            <span v-if="model.children.length > 0" class="font-semibold">
                                 ({{ model.children.length }})
                            </span>
                        </span>

                        <span>
                            <a href="javascript:void(0)"
                               v-if="!store.edit_tree_label_array.includes(model.id)"
                               @click="store.setTaxonomyTypeNewName(model)"
                               class="cursor-pointer"
                            >
                                <i class="pi pi-pencil ml-4 mr-2"></i>
                            </a>

                            <a href="javascript:void(0)"
                               v-if="store.edit_tree_label_array.includes(model.id)"
                               @click="store.updateTaxonomyType(model)"
                               class="cursor-pointer"
                            >
                                <i class="pi pi-check ml-4 mr-2"></i>
                            </a>

                            <a href="javascript:void(0)"
                               @click="store.deleteTaxonomyType(model)"
                               class="cursor-pointer"
                            >
                                <i class="pi pi-trash ml-4 mr-2"></i>
                            </a>
                        </span>
                    </div>
                </template>
            </TreeView>
        </div>
    </div>
</template>

