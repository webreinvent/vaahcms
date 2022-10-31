<template>
<div class="user-details">
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
            <DataTable :value="user_details" stripedRows class="p-datatable-sm">
                <Column>
                    <template #body="slotProps">
                        {{slotProps.data.label}}
                    </template>
                </Column>
                <Column>
                    <template #body="slotProps">
                        {{slotProps.data.value}}
                    </template>
                </Column>
                <Column>
                    <template #body="slotProps">
                        <a href="" v-if="slotProps.data.link">
                            <i class="pi pi-copy"></i>
                        </a>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>
</div>
</template>

<script>
export default {
    name: "UserDetails",
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
            ],
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
