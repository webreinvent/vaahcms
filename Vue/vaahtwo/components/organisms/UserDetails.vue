<template>
<div class="user-details">
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h2 class="font-semibold vc-text-16">UserName</h2>
                <InputGroup class="justify-content-end">
                    <Button label="#1986"></Button>
                    <Button size="small" label="Edit" icon="pi pi-pencil" class=""/>
                    <Button size="small" class="" icon="pi pi-caret-down" @click="toggle"/>
                    <Button size="small" icon="pi pi-times" class=""/>
                </InputGroup>
                <TieredMenu :model="menu_options" ref="menu" :popup="true">
                </TieredMenu>
            </div>
        </template>
        <template #content>
            <DataTable size="small" :value="user_details" stripedRows class="">
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
