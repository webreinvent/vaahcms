<template>
<div class="grid">
    <div class="col-12 md:col-3"></div>
    <div class="col-12 md:col-6">
        <Card>
            <template #content>
                <draggable
                    v-model="myArray"
                    group="{name:'people', pull: 'clone'}"
                    @start="drag=true"
                    @end="drag=false"
                    item-key="id">
                    <template #item="{element}">
                        <div class="p-inputgroup mb-3">
                            <InputText class="w-2" :model-value="element.name"></InputText>
                            <InputText class="w-6"></InputText>
                            <Button icon="pi pi-hashtag"></Button>
                            <Button icon="pi pi-cog"></Button>
                            <Button icon="pi pi-trash"></Button>
                        </div>
                    </template>
                </draggable>
            </template>
        </Card>
    </div>
    <div class="col-12 md:col-3">
        <Card>
            <template #content>
                <draggable
                    v-model="myArray2"
                    group="{name:'people', pull: 'clone'}"
                    @start="drag=true"
                    @end="drag=false"
                    item-key="id">
                    <template #item="{element}">
                        <div class="p-inputgroup">
                            <InputText class="w-2" :model-value="element.name"></InputText>
                            <InputText class="w-6"></InputText>
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
            drag: false,
            myArray:[
                {
                    "name": "John",
                    "id": 1
                },
                {
                    "name": "Joao",
                    "id": 2
                },
                {
                    "name": "Jean",
                    "id": 3
                },
                {
                    "name": "Gerard",
                    "id": 4
                }
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
            ]
        }
    },
}
</script>

<style scoped>

</style>
