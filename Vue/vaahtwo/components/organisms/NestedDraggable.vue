<template>
    <draggable
        class="dragArea drag-list"
        tag="ul"
        :list="tasks"
        :group="{ name: 'g1' }"
        item-key="name"
    >
        <template #item="{ element,index }">
            <li>
                <InputGroup class="mb-3">
                    <InputText class="w-2" :model-value="element.name" disabled></InputText>
                    <InputText class="w-6" placeholder="Field Name"></InputText>
                    <Button size="small" icon="pi pi-home"></Button>
                    <Button size="small" icon="pi pi-cog" @click="element.menu_options = !element.menu_options"></Button>
                    <Button size="small" icon="pi pi-trash" @click="removeAt(index)"></Button>
                </InputGroup>
                <div class="menu-options m-3" v-if="element.menu_options">
                    <div class="mb-5">
                        <Checkbox value="Test" id="check"></Checkbox>
                        <label for="check" class="vc-text-12 font-semibold ml-1">Open in new Page</label>
                    </div>
                    <FloatLabel class="mb-5">
                        <InputText size="small" class="w-full" id="item-id"></InputText>
                        <label for="item-id">Menu Item Id</label>
                    </FloatLabel>
                    <FloatLabel class="mb-5">
                        <InputText size="small" class="w-full" id="item-class"></InputText>
                        <label for="item-class">Menu Item Class</label>
                    </FloatLabel>
                </div>
                <NestedDraggable :tasks="element.tasks" />
            </li>
        </template>
    </draggable>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    name: "NestedDraggable",
    props: {
        tasks: {
            required: true,
            type: Array
        }
    },
    components: {
        draggable
    },
    methods:{
        removeAt(idx) {
            this.tasks.splice(idx, 1);
        },
    }
}
</script>

<style scoped>
.dragArea {
}
</style>
