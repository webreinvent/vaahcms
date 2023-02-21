<script setup>

import { useTaxonomyStore } from "../../../stores/store-taxonomies";
import { ref } from "vue";
import { vaah } from "../../../vaahvue/pinia/vaah";
import draggable from 'vuedraggable'
import { TreeView } from "@grapoza/vue-tree";

const store = useTaxonomyStore();
const useVaah = vaah();
const selectedNode = ref();
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

        <div class="draggable-tree-list" v-if="store && store.assets && store.assets.types">
            <TreeView :initial-model="store.assets.types"
                      :model-defaults="modelDefaults"
            >
                <template v-slot:text="{ model, customClasses }">
                    <div class="list-item">
                        <span>
                            <p class="inline cursor-pointer"
                               v-if="!editLabel"
                               @click="useVaah.copy(model.data)"
                               v-tooltip.top=" 'Copy Slug' "
                            >
                                <span><i class="pi pi-folder mr-1"></i> {{ model.label }} </span>
                            </p>

                            <InputText @input="store.setTaxonomyTypeNewName(model.label)"
                                       v-model="model.label"
                                       v-if="editLabel"
                            />

                            <span v-if="model.children.length > 0" class="font-semibold">
                                 ({{ model.children.length }})
                            </span>
                        </span>

                        <span>
                            <a href="javascript:void(0)"
                               v-if="!editLabel"
                               @click="store.setTaxonomyTypeNewName(model.label); openEditNode()"
                               class="cursor-pointer"
                            >
                                <i class="pi pi-pencil ml-4 mr-2"></i>
                            </a>

                            <a href="javascript:void(0)"
                               v-if="editLabel"
                               @click="store.updateTaxonomyType(model.id)"
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

<style scoped lang="scss">

.p-treenode-label {
    width: 100% !important;
}

.grtv-wrapper {
    .grtvn-self-action {
        border:none;
        background:none;
        cursor:pointer;
    }

    .grtvn-self-expander.action-button {
        padding-left:0;
    }

    .pi-trash{
        color:red;
        font-size: 14px;
        font-weight: normal;
    }
}

.grtv-wrapper .grtvn-self-expander.grtvn-self-expanded i.grtvn-self-expanded-indicator {
    transform: rotate(90deg);
    transition: all 0.2s linear;
}

.grtv-wrapper {
    .grtvn-children {
        transition: all 0.2s linear;
    }
}

.draggable-tree-list{
    ul {
        list-style-type:none;
        padding-left: 0;
        &.grtv {
            li {
                padding:8px 0;
                .grtvn-self {
                    width: 100%;
                    display: flex;
                    .list-item{
                        width:100%;
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                    }
                }

                .grtvn-children-wrapper {
                    ul {
                        padding-left:14px
                    }
                }
            }
        }
    }
}

.action-button {
    border: none;
    background: transparent;
    i {
        font-size: 10px;
        font-weight: 700;
    }
}
</style>
