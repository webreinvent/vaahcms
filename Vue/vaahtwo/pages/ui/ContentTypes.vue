<template>
<div class="grid">
    <div class="col-12 md:col-3"></div>
    <div class="col-12 md:col-6">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h2 class="font-semibold text-lg">Content Structure</h2>
                    <div class="p-inputgroup w-max">
                        <Button label="Save" icon="pi pi-save" class="p-button-sm"></Button>
                        <Button icon="pi pi-times" class="p-button-sm"></Button>
                    </div>
                </div>
            </template>
            <template #content>
                <Card v-for="(item,idx) in content_groups" class="mb-3">
                    <template #content>
                        <div class="w-full flex justify-content-between align-items-center mb-4">
                            <h4 class="font-semibold">{{item.title}}</h4>
                            <div class="w-max p-inputgroup align-items-center">
                                <InputSwitch></InputSwitch>
                                <p class="ml-1 mr-3 text-xs font-semibold">Is Repeatable</p>
                                <Button icon="pi pi-hashtag" class="p-button-sm"></Button>
                                <Button icon="pi pi-trash" class="p-button-sm" @click="removeGroup(idx)"></Button>
                            </div>
                        </div>
                        <draggable
                            v-model="item.content_types"
                            class="dragArea list-group"
                            group="content-types"
                            @start="drag=true"
                            @end="drag=false"
                            item-key="id">
                            <template #item="{element,index}">
                               <div>
                                   <div class="p-inputgroup mb-3">
                                       <InputText class="w-2" :model-value="element.title" disabled></InputText>
                                       <InputText class="w-6" placeholder="Field Name"></InputText>
                                       <Button icon="pi pi-hashtag p-button-sm"></Button>
                                       <Button icon="pi pi-cog p-button-sm" @click="element.content_settings_status = !element.content_settings_status"></Button>
                                       <Button icon="pi pi-trash p-button-sm" @click="removeAt(index,idx)"></Button>
                                   </div>
                                   <div v-if="element.content_settings_status">
                                       <DataTable :value="element.content_settings" stripedRows class="p-datatable-sm">
                                           <Column>
                                               <template #body="slotProps">
                                                   {{slotProps.data.label}}
                                               </template>
                                           </Column>
                                           <Column>
                                               <template #body="slotProps">
                                                   <InputSwitch v-if="slotProps.data.value === 'repeatable'"></InputSwitch>
                                                   <InputSwitch v-if="slotProps.data.value === 'searchable'"></InputSwitch>
                                                   <Textarea v-if="slotProps.data.value === 'excerpt'" class="w-full"></Textarea>
                                                   <InputText v-if="slotProps.data.value === 'opening-tag'" class="w-full"></InputText>
                                                   <InputText v-if="slotProps.data.value === 'closing-tag'" class="w-full"></InputText>
                                                   <div v-if="slotProps.data.value === 'hidden'">
                                                       <Checkbox id="hidden"></Checkbox>
                                                       <label for="hidden" class="font-semibold text-xs ml-1">Is Hidden</label>
                                                   </div>
                                               </template>
                                           </Column>
                                       </DataTable>
                                   </div>
                               </div>
                            </template>
                        </draggable>
                    </template>
                </Card>
            </template>
            <template #footer>
                <div class="p-inputgroup w-6 m-auto">
                    <InputText v-model="contentInput"></InputText>
                    <Button label="Add Group" class="p-button-sm" @click="addContentGroup"></Button>
                </div>
            </template>
        </Card>
    </div>
    <div class="col-12 md:col-3">
        <Card>
            <template #header>
                <h2 class="font-semibold text-lg">Content Fields</h2>
            </template>
            <template #content>
                <draggable
                    v-model="content_types"
                    class="dragArea list-group"
                    :group="{ name: 'content-types', pull: 'clone', put: false }"
                    @start="drag=true"
                    @end="drag=false"
                    item-key="id">
                    <template #item="{element}">
                        <div class="p-inputgroup mb-3">
                            <Button icon="pi pi-bars" class="p-button-sm p-button-secondary"></Button>
                            <Button :label="element.title" class="p-button-secondary p-button-sm"></Button>
                        </div>
                    </template>
                </draggable>
            </template>
        </Card>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    name: "ContentTypes",
    components: {
        draggable,
    },
    data() {
        return {
            user_details:[
                {
                    label:'Id',
                    value:'#998',
                    link:'sdfas'
                },
                {
                    label:'Uuid',
                    value:'askjdhfkjasdjsndckjasdhfajlds',
                    link:''
                },
                {
                    label:'Email',
                    value:'lorem@ipsum.com'
                },
                {
                    label:'Username',
                    value:'Lorem',
                    link:'sdfas'
                },
                {
                    label:'Display Name',
                    value:''
                },
                {
                    label:'First Name',
                    value:''
                },
                {
                    label:'Last Name',
                    value:''
                }

            ],
            contentInput:null,
            drag: false,
            myArray:[

            ],
            myArray2:[
                {
                    "name": "Juan",
                    "id": 5
                },
                {
                    "name": "Edgard",
                    "id": 6
                },
                {
                    "name": "Johnson",
                    "id": 7
                }
            ],
            content_types:[
                {
                    id:1,
                    title:'Text',
                    content_settings:[
                        {
                            label:'Is repeatable',
                            value:'repeatable'
                        },
                        {
                            label:'Is Searchable',
                            value:'searchable'
                        },
                        {
                            label:'Excerpt',
                            value:'excerpt'
                        },
                        {
                            label:'Opening Tag',
                            value:'opening-tag'
                        },
                        {
                            label:'Closing Tag',
                            value:'closing-tag'
                        },
                        {
                            label:'Is Hidden',
                            value:'hidden'
                        }
                    ],
                    content_settings_status:false
                },
                {
                    id:2,
                    title:'TextArea',
                    content_settings:[
                        {
                            label:'Is repeatable',
                            value:'repeatable'
                        },
                        {
                            label:'Is Searchable',
                            value:'searchable'
                        },
                        {
                            label:'Excerpt',
                            value:'excerpt'
                        },
                        {
                            label:'Opening Tag',
                            value:'opening-tag'
                        },
                        {
                            label:'Closing Tag',
                            value:'closing-tag'
                        },
                        {
                            label:'Is Hidden',
                            value:'hidden'
                        }
                    ],
                    content_settings_status:false
                },
                {
                    id:3,
                    title: 'Title',
                    content_settings:[
                        {
                            label:'Is repeatable',
                            value:'repeatable'
                        },
                        {
                            label:'Is Searchable',
                            value:'searchable'
                        },
                        {
                            label:'Excerpt',
                            value:'excerpt'
                        },
                        {
                            label:'Opening Tag',
                            value:'opening-tag'
                        },
                        {
                            label:'Closing Tag',
                            value:'closing-tag'
                        },
                        {
                            label:'Is Hidden',
                            value:'hidden'
                        }
                    ],
                    content_settings_status:false
                },
                {
                    id:4,
                    title: 'Slug',
                    content_settings:[
                        {
                            label:'Is repeatable',
                            value:'repeatable'
                        },
                        {
                            label:'Is Searchable',
                            value:'searchable'
                        },
                        {
                            label:'Excerpt',
                            value:'excerpt'
                        },
                        {
                            label:'Opening Tag',
                            value:'opening-tag'
                        },
                        {
                            label:'Closing Tag',
                            value:'closing-tag'
                        },
                        {
                            label:'Is Hidden',
                            value:'hidden'
                        }
                    ],
                    content_settings_status:false
                },
                {
                    id:5,
                    title: 'Editor',
                    content_settings:[
                        {
                            label:'Is repeatable',
                            value:'repeatable'
                        },
                        {
                            label:'Is Searchable',
                            value:'searchable'
                        },
                        {
                            label:'Excerpt',
                            value:'excerpt'
                        },
                        {
                            label:'Opening Tag',
                            value:'opening-tag'
                        },
                        {
                            label:'Closing Tag',
                            value:'closing-tag'
                        },
                        {
                            label:'Is Hidden',
                            value:'hidden'
                        }
                    ],
                    content_settings_status:false
                }
            ],
            content_groups:[
                {
                    title:'Default',
                    is_repeatable:false,
                    content_types:[],
                }
            ]
        }
    },
    methods:{
        addContentGroup(){
            if(this.contentInput){
                this.content_groups.push({
                    title: this.contentInput,
                    is_repeatable: false,
                    content_types: [],
                });
                this.contentInput = null;
            }
        },
        removeGroup(idx){
            this.content_groups.splice(idx,1)
        },
        removeAt(idx,i) {
            this.content_groups[i].content_types.splice(idx, 1);
        },
    }
}
</script>

<style scoped>

</style>
