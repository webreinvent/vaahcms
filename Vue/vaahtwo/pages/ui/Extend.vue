<template>
<div class="grid extend">
    <div class="col">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="font-semibold text-lg">Themes</h5>
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Install" icon="pi pi-plus" class="p-button-sm" @click="showThemes"/>
                        <Button class="p-button-sm" icon="pi pi-download" label="Check Updates"/>
                        <Button icon="pi pi-refresh" class="p-button-sm"/>
                    </div>
                </div>
            </template>
            <template #content>
                <div class="grid">
                    <div class="col-4 mb-5">
                        <Dropdown placeholder="Select a filter"></Dropdown>
                    </div>
                    <div class="col-5 col-offset-3 mb-5">
                        <div class="p-inputgroup">
                            <InputText placeholder="Search"></InputText>
                            <Button label="Filter"></Button>
                            <Button label="Reset"></Button>
                        </div>
                    </div>
                    <div class="col-12">
                       <div class="grid">
                           <div class="col-12 md:col-5">
                               <h5 class="font-semibold text-xl inline">Theme for Jalapeno</h5>
                               <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                               <p class="text-sm text-gray-600 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                           </div>
                           <div class="col-12 md:col-7">
                               <div class="flex justify-content-end mb-3">
                                   <Tag value="Name: Jalapeno" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                   <Tag value="Version: 1.1.10" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                   <Tag value="Developed by: WebReinvent" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                               </div>
                               <div class="flex justify-content-end">
                                   <Button label="Deactivate" class="mr-2 p-button-sm"></Button>
                                   <Button label="Import Data" class="mr-2 p-button-sm"></Button>
                                   <Button icon="pi pi-check" class="mr-2 p-button-sm p-button-warning"></Button>
                                   <Button icon="pi pi-trash" class="mr-2 p-button-sm p-button-danger"></Button>
                               </div>
                           </div>
                       </div>
                    </div>
                    <Divider />
                    <div class="col-12">
                        <div class="grid">
                            <div class="col-12 md:col-9">
                                <h5 class="font-semibold text-xl inline">Theme for Jalapeno</h5>
                                <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                                <p class="text-sm text-gray-600 mt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                                <div class="flex mt-3">
                                    <Tag value="Name: Jalapeno" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                    <Tag value="Version: 1.1.10" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                    <Tag value="Developed by: WebReinvent" class="mr-2 bg-blue-50 text-blue-600 font-semibold"></Tag>
                                </div>
                            </div>
                            <div class="col-12 md:col-3">
                                <div class="flex justify-content-end">
                                    <Button label="Deactivate" class="mr-2 p-button-sm"></Button>
                                    <Button icon="pi pi-ellipsis-v" class="p-button-link" @click="toggle"></Button>
                                </div>
                                <TieredMenu :model="menu_options" ref="menu" :popup="true">
                                </TieredMenu>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </div>
    <div class="col-12 md:col-6" v-if="show_themes">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="white-space-nowrap font-semibold text-lg">Install Themes</h5>
                    <div class="p-inputgroup justify-content-end w-6">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText placeholder="Search" class="w-full"></InputText>
                        </span>
                        <Button icon="pi pi-times" class="p-button-sm" @click="hideThemes"/>
                    </div>
                </div>
            </template>
            <template #content>
                <div class="grid">
                    <div class="col-12 md:col-6">
                        <Card>
                            <template #header>
                                <img src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png" style="height: 15rem" />
                            </template>
                            <template #content>
                                <h5 class="text-xl font-semibold mb-1">Bulma Blog Theme</h5>
                                <p class="mb-3 text-sm">Bulma is a multipurpose responsive VaahCms theme.</p>
                                <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                            </template>
                            <template #footer>
                                <Button label="Install" icon="pi pi-download" class="p-button-outlined p-button-sm"></Button>
                            </template>
                        </Card>
                    </div>
                    <div class="col-12 md:col-6">
                        <Card>
                            <template #header>
                                <img src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png" style="height: 15rem" />
                            </template>
                            <template #content>
                                <h5 class="text-xl font-semibold mb-1">Bulma Blog Theme</h5>
                                <p class="mb-3 text-sm">Bulma is a multipurpose responsive VaahCms theme.</p>
                                <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                            </template>
                            <template #footer>
                                <Button label="Install" icon="pi pi-download" class="p-button-outlined p-button-sm"></Button>
                            </template>
                        </Card>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</div>


</template>

<script>
export default {
    name: "Extend",
    data(){
        return{
            show_themes:false,
            menu_options:[
                {
                    label:'Import Data',
                    icon:'pi pi-fw pi-server'
                },
                {
                    label:'Delete',
                    icon:'pi pi-fw pi-trash'
                },
                {
                    label:'Remove Default',
                    icon:'pi pi-fw pi-times'
                }
            ]
        }
    },
    methods:{
        showThemes(){
            this.show_themes  = true;
        },
        hideThemes() {
            this.show_themes = false;
        },
        toggle(event) {
            this.$refs.menu.toggle(event);
        }
    }
}
</script>

<style scoped>

</style>
