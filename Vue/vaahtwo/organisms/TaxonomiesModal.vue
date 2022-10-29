<template>
<div>
    <div class="p-inputgroup">
        <Dropdown placeholder="Select a Parent"></Dropdown>
        <InputText></InputText>
        <Button label="Add"></Button>
    </div>
    <div>
        <!--<Tree :value="nodes">
            <template #default="slotProps">
                <div class="flex justify-content-between">
                    <b class="mr-3">{{slotProps.node.label}} <small class="font-weight-normal">({{slotProps.node.children.length}})</small></b>
                    <span>
                        <a class="mr-2"><i class="pi pi-pencil"></i></a>
                        <a><i class="pi pi-copy"></i></a>
                    </span>
                </div>
            </template>
            <template #url="slotProps">
                <div class="flex justify-content-between">
                <a class="mr-3">{{slotProps.node.label}}</a>
                    <span>
                        <a class="mr-2"><i class="pi pi-pencil"></i></a>
                        <a><i class="pi pi-copy"></i></a>
                    </span>
                </div>
            </template>
        </Tree>-->
    </div>
    <div>
        <draggable
            :list="list"
            :disabled="!enabled"
            item-key="name"
            class="list-group"
            ghost-class="ghost"
            @start="dragging = true"
            @end="dragging = false"
        >
            <template #item="{ element }">
                <div class="list-group-item" :class="{ 'not-draggable': !enabled }">
                    {{ element.name }}
                </div>
            </template>
        </draggable>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    name: "TaxonomiesModal",
    components: {
        draggable,
    },
    data(){
        return{
            selectedKey2: null,
            nodes: [
                {
                    key: '0',
                    label: 'Introduction',
                    children: [
                        {key: '0-0', label: 'What is Vue.js?', data:'https://vuejs.org/guide/introduction.html#what-is-vue', type: 'url'},
                        {key: '0-1', label: 'Quick Start', data: 'https://vuejs.org/guide/quick-start.html#quick-start', type: 'url'},
                        {key: '0-2', label: 'Creating a Vue Application', data:'https://vuejs.org/guide/essentials/application.html#creating-a-vue-application', type:'url'},
                        {key: '0-3', label: 'Conditionals Rendering', data: 'https://vuejs.org/guide/essentials/conditional.html#conditional-rendering', type: 'url'}
                    ]
                },
                {
                    key: '1',
                    label: 'Components In-Depth',
                    children: [
                        {key: '1-0', label: 'Component Registration', data: 'https://vuejs.org/guide/components/registration.html#component-registration', type: 'url'},
                        {key: '1-1', label: 'Props', data: 'https://vuejs.org/guide/components/props.html#props', type: 'url'},
                        {key: '1-2', label: 'Components Events', data: 'https://vuejs.org/guide/components/events.html#component-events', type: 'url'}
                    ]
                }
            ],
            myArray:[
                {
                    name: 'Node 1',
                    id: 1,
                    pid: 0,
                    dragDisabled: true,
                    addTreeNodeDisabled: true,
                    addLeafNodeDisabled: true,
                    editNodeDisabled: true,
                    delNodeDisabled: true,
                    children: [
                        {
                            name: 'Node 1-2',
                            id: 2,
                            isLeaf: true,
                            pid: 1
                        }
                    ]
                },
                {
                    name: 'Node 2',
                    id: 3,
                    pid: 0,
                    disabled: true
                },
                {
                    name: 'Node 3',
                    id: 4,
                    pid: 0
                }
            ],
            list:[
                { name: "John", id: 0 },
                { name: "Joao", id: 1 },
                { name: "Jean", id: 2 }
            ],
            dragging:false,
            enabled:false
        }
    },
    methods:{
        onNodeSelect(node) {
            console.log('Selected --->',node)
        },
        onNodeUnselect(node) {
            console.log('UnSelected --->',node)
        }
    }
}
</script>

<style scoped lang="scss">
.p-treenode-label{
    width: 100% !important;
}
</style>
