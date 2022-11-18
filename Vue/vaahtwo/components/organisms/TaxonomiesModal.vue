<template>
    <div>
        <div class="p-inputgroup">
            <Dropdown placeholder="Select a Parent" v-model="selectedParent" :options="tvModel" option-label="label"></Dropdown>
            <InputText v-model="inputChild"></InputText>
            <Button label="Add" @click="addToTree(selectedParent)"></Button>
        </div>
        <div>
        </div>
        <div class="draggable-tree-list">
            <tree-view :initial-model="tvModel" :model-defaults="modelDefaults">
                <template v-slot:text="{ model, customClasses }">
                    <div class="list-item">
                    <span>
                      <p class="inline" v-if="!editLabel">{{ model.label }}</p>
                      <InputText :model-value="model.label" v-if="editLabel"></InputText>
                      <span v-if="model.children.length > 0" class="font-semibold">
                         ({{model.children.length}})
                      </span>
                    </span>
                        <span>
                      <a v-if="!editLabel" @click="editLabel = true" class="cursor-pointer"><i class="pi pi-pencil ml-4 mr-2" ></i></a>
                      <a v-if="editLabel" @click="editLabel = false" class="cursor-pointer"><i class="pi pi-check ml-4 mr-2" ></i></a>
                    </span>
                    </div>
                </template>
            </tree-view>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import { TreeView } from "@grapoza/vue-tree";
export default {
    name: "TaxonomiesModal",
    components: {
        draggable,
        TreeView
    },
    data(){
        return{
            parentsList:null,
            selectedParent:null,
            inputChild:null,
            editLabel:false,
            selectedKey2: null,
            tvModel: [
                {
                    id: 'dragdrop2-node1',
                    label: 'Countries',
                    children: [],
                },
                {
                    id: 'dragdrop2-node2',
                    label: 'Registrations',
                    children: [
                        {
                            id: 'dragdrop2-subnode1',
                            label: 'Registrations one',
                            children: []
                        },
                        {
                            id: 'dragdrop2-subnode2',
                            label: 'Registrations two',
                            children: [
                                {
                                    id: 'dragdrop2-subsubnode1',
                                    label: 'Registrations sub 1',
                                    children: []
                                },
                                {
                                    id: 'dragdrop2-subsubnode2',
                                    label: 'Registrations sub 1',
                                    children: []
                                }
                            ]
                        }
                    ]
                },
                {
                    id: 'dragdrop2-node3',
                    label: 'Roles',
                    children: [
                        {
                            id: 'dragdrop2-subnode1',
                            label: 'Roles One',
                            children: []
                        },
                        {
                            id: 'dragdrop2-subnode2',
                            label: 'Roles Two',
                            children: [
                                {
                                    id: 'dragdrop2-subsubnode1',
                                    label: 'Roles sub 1',
                                    children: []
                                },
                                {
                                    id: 'dragdrop2-subsubnode2',
                                    label: 'Roles sub 2',
                                    children: []
                                }
                            ]
                        }
                    ]
                }
            ],
            modelDefaults:{
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
                        treeViewNodeSelfDeleteIcon: 'pi pi-trash'
                    }
                }
            }
        }
    },
    methods:{
        onNodeSelect(node) {
            console.log('Selected --->',node)
        },
        onNodeUnselect(node) {
            console.log('UnSelected --->',node)
        },
        addToTree(item){
            item.children.push(
                {
                    id:'lorem',
                    label:this.inputChild,
                    children:[]
                });
            this.inputChild = null;
        }
    }
}
</script>

<style lang="scss">
.p-treenode-label{
    width: 100% !important;
}
.grtv-wrapper{
    .grtvn-self-action{
        border:none;
        background:none;
        cursor:pointer;
    }
    .grtvn-self-expander.action-button{
        padding-left:0;
    }
    .action-button i {
        &.pi-trash{
            color:red;
            font-size: 14px;
            font-weight: normal;
        }
    }
}
.grtv-wrapper .grtvn-self-expander.grtvn-self-expanded i.grtvn-self-expanded-indicator {
    transform: rotate(90deg);
    transition: all 0.2s linear;
}
.grtv-wrapper{
    .grtvn-children{
        transition: all 0.2s linear;
    }
}
.draggable-tree-list{
    ul{
        list-style-type:none;
        padding-left: 0;
        &.grtv{
            li{
                padding:8px 0;
                .grtvn-self{
                    width: 100%;
                    display: flex;
                    .list-item{
                        width:100%;
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                    }
                }
                .grtvn-children-wrapper{
                    ul{
                        padding-left:14px
                    }
                }
            }
        }
    }
}
.action-button{
    border: none;
    background: transparent;
    i{
        font-size: 10px;
        font-weight: 700;
    }
}
</style>
