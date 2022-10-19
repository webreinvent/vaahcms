<template>
<div class="user-detials">
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h5 class="font-semibold text-sm">UserName</h5>
                <div class="p-inputgroup justify-content-end">
                    <Button label="#1986"></Button>
                    <Button label="Edit" icon="pi pi-pencil" class="p-button-sm"/>
                    <Button class="p-button-sm" icon="pi pi-caret-down" @click="toggle"/>
                    <Button icon="pi pi-times" class="p-button-sm"/>
                </div>
                <TieredMenu :model="menu_options" ref="menu" :popup="true">
                </TieredMenu>
            </div>
        </template>
        <template #content>
        </template>
    </Card>
</div>
</template>

<script>
export default {
    name: "UserDetials",
    data(){
        return{
            menu_options:[
                {
                    label:'Save & Close',
                    icon:'pi pi-fw pi-file'
                },
                {
                    label:'Save & Clone',
                    icon:'pi pi-fw pi-pencil'
                },
                {
                    label:'Reset',
                    icon:'pi pi-fw pi-user'
                }
            ]
        }
    },
    methods:{
        toggle(event) {
            this.$refs.menu.toggle(event);
        }
    }
}
</script>

<style scoped>

</style>
