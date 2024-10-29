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
                <div class="p-inputgroup mb-3">
                    <InputText class="w-2" :model-value="element.name" disabled></InputText>
                    <InputText class="w-6" placeholder="Field Name"></InputText>
                    <Button icon="pi pi-home p-button-sm"></Button>
                    <Button icon="pi pi-cog p-button-sm" @click="element.menu_options = !element.menu_options"></Button>
                    <Button icon="pi pi-trash p-button-sm" @click="removeAt(index)"></Button>
                </div>
                <div class="menu-options m-3" v-if="element.menu_options">
                    <div class="mb-5">
                        <Checkbox value="Test" id="check"></Checkbox>
                        <label for="check" class="text-xs font-semibold ml-1">Open in new Page</label>
                    </div>
                    <div class="p-float-label mb-5">
                        <InputText class="w-full p-inputtext-sm" id="item-id"></InputText>
                        <label for="item-id">Menu Item Id</label>
                    </div>
                    <div class="p-float-label mb-5">
                        <InputText class="w-full p-inputtext-sm" id="item-class"></InputText>
                        <label for="item-class">Menu Item Class</label>
                    </div>
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
