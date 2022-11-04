<template>
<div class="grid">
    <div class="col-12 md:col-3"></div>
    <div class="col-12 md:col-6">
        <Card class="draggable-menu">
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h2 class="font-semibold text-lg">Top Menu</h2>
                    <div class="p-inputgroup w-max">
                        <Button label="Save" icon="pi pi-save" class="p-button-sm"></Button>
                        <Button icon="pi pi-cog" class="p-button-sm"></Button>
                        <Button icon="pi pi-trash" class="p-button-sm"></Button>
                    </div>
                </div>
            </template>
            <template #content>
                <NestedDraggable :tasks="menu"></NestedDraggable>
            </template>
        </Card>
    </div>
    <div class="col-12 md:col-3">
        <Card>
            <template #header>
                <h2 class="font-semibold text-lg">Content</h2>
            </template>
            <template #content>
                <Panel header="Contents" :toggleable="true" class="mb-4">
                    <AutoComplete input-class="w-full" class="w-full mb-3" placeholder="Search"></AutoComplete>
                    <draggable
                        v-model="content_types"
                        class="dragArea"
                        :group="{ name: 'g1', pull: 'clone', put: false }"
                        @start="drag=true"
                        @end="drag=false"
                        item-key="id">
                        <template #item="{element}">
                            <div class="p-inputgroup mb-3">
                                <Button icon="pi pi-bars" class="p-button-secondary p-button-sm"></Button>
                                <Button :label="element.name" class="p-button-secondary p-button-sm"></Button>
                            </div>
                        </template>
                    </draggable>
                </Panel>
                <Panel header="Custom" :toggleable="true">
                    <div class="p-inputgroup mb-3">
                        <Button icon="pi pi-bars" class="p-button-secondary p-button-sm"></Button>
                        <Button label="Internal Link" class="p-button-secondary p-button-sm"></Button>
                    </div>
                    <div class="p-inputgroup mb-3">
                        <Button icon="pi pi-bars" class="p-button-secondary p-button-sm"></Button>
                        <Button label="External Link" class="p-button-secondary p-button-sm"></Button>
                    </div>
                </Panel>
            </template>
        </Card>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable'
import NestedDraggable from "../../components/organisms/NestedDraggable.vue";
export default {
    name: "MenuContent",
    components: {
        NestedDraggable,
        draggable,
    },
    data(){
        return{
            content_types:[
                {
                    id:1,
                    name:'#981Home',
                    tasks:[],
                    menu_options:false
                },
                {
                    id:2,
                    name:'Solutions',
                    tasks:[],
                    menu_options:false
                },
                {
                    id:3,
                    name: 'Resources',
                    tasks:[],
                    menu_options:false
                },
                {
                    id:4,
                    name: 'Coaching',
                    tasks:[],
                    menu_options:false
                },
                {
                    id:5,
                    name: 'Counselling',
                    tasks: [],
                    menu_options:false
                }
            ],
            menu:[
                {
                    "name": "Home",
                    "tasks": [
                        {
                            "name": "Menu Item 1",
                            "tasks": [],
                            menu_options:false
                        },
                        {
                            "name": "Menu Item 2",
                            "tasks": [],
                            menu_options:false
                        }
                    ],
                    menu_options:false
                },
                {
                    "name": "Solutions",
                    "tasks": [
                        {
                            "name": "Menu Item 1",
                            "tasks": [],
                            menu_options:false
                        }
                    ],
                    menu_options:false
                },
                {
                    "name": "Resources",
                    "tasks": [],
                    menu_options:false
                }
            ],
            content_groups:[
                {
                    title:'Default',
                    is_repeatable:false,
                    content_types:[]
                }
            ]
        }
    }
}
</script>

<style lang="scss">
/*.draggable-menu{
    ul{
        &:not(:first-child){
            margin: 0 10px 5px 10px;
        }
    }
}*/
</style>
