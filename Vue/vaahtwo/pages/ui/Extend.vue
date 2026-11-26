<template>
<div class="grid extend">
    <div class="col">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="font-semibold vc-text-16">Themes</h5>
                    <InputGroup class="justify-content-end">
                        <Button size="small" label="Install" icon="pi pi-plus" class="" @click="showThemes"/>
                        <Button size="small" class="" icon="pi pi-download" label="Check Updates"/>
                        <Button size="small" icon="pi pi-refresh" class=""/>
                    </InputGroup>
                </div>
            </template>
            <template #content>
                <div class="grid">
                    <div class="col-4 mb-5">
                        <Select placeholder="Select a filter"></Select>
                    </div>
                    <div class="col-5 col-offset-3 mb-5">
                        <!-- UT-108 (D3) — the search field and the "Filter" /
                             "Reset" buttons were welded into one
                             `InputGroup`, so the row read as a single
                             oversized input with two buttons stuck to its
                             right edge — the defect the UT-108 cross-screen
                             probe found on the list toolbars. The field and
                             its magnifier are one control and stay
                             together; "Filter" and "Reset" act on the
                             *list*, not on the field, so they are controls
                             of their own beside it (the peer contract). -->
                        <div class="extend-toolbar flex flex-wrap items-center gap-2">
                            <InputGroup class="extend-toolbar-field">
                                <InputText aria-label="Search" size="small" placeholder="Search" class="w-full"></InputText>
                                <Button size="small" icon="pi pi-search" aria-label="Search" class=""></Button>
                            </InputGroup>

                            <Button size="small" class="extend-toolbar-action" label="Filter"></Button>
                            <Button size="small" class="extend-toolbar-action" label="Reset"></Button>
                        </div>
                    </div>
                    <div class="col-12">
                       <div class="grid">
                           <div class="col-12 md:col-5">
                               <h5 class="font-semibold vc-text-20 inline">Theme for Jalapeno</h5>
                               <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                               <p class="vc-muted vc-text-13 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                           </div>
                           <div class="col-12 md:col-7">
                               <div class="flex justify-content-end mb-3">
                                   <Tag value="Name: Jalapeno" class="mr-2 vc-chip font-semibold"></Tag>
                                   <Tag value="Version: 1.1.10" class="mr-2 vc-chip font-semibold"></Tag>
                                   <Tag value="Developed by: WebReinvent" class="mr-2 vc-chip font-semibold"></Tag>
                               </div>
                               <div class="flex justify-content-end">
                                   <Button size="small" label="Deactivate" class="mr-2"></Button>
                                   <Button size="small" label="Import Data" class="mr-2"></Button>
                                   <Button size="small" icon="pi pi-check" severity="warn" class="mr-2"></Button>
                                   <Button size="small" icon="pi pi-trash" severity="danger" class="mr-2"></Button>
                               </div>
                           </div>
                       </div>
                    </div>
                    <Divider />
                    <div class="col-12">
                        <div class="grid">
                            <div class="col-12 md:col-9">
                                <h5 class="font-semibold vc-text-20 inline">Theme for Jalapeno</h5>
                                <Tag value="Default" severity="success" class="ml-2" rounded></Tag>
                                <p class="vc-muted vc-text-13 mt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, sit.</p>
                                <div class="flex mt-3">
                                    <Tag value="Name: Jalapeno" class="mr-2 vc-chip font-semibold"></Tag>
                                    <Tag value="Version: 1.1.10" class="mr-2 vc-chip font-semibold"></Tag>
                                    <Tag value="Developed by: WebReinvent" class="mr-2 vc-chip font-semibold"></Tag>
                                </div>
                            </div>
                            <div class="col-12 md:col-3">
                                <div class="flex justify-content-end">
                                    <Button size="small" label="Deactivate" class="mr-2"></Button>
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
                    <h5 class="white-space-nowrap font-semibold vc-text-16">Install Themes</h5>
                    <InputGroup class="justify-content-end w-6">
                        <!-- UT-117 — v3's `p-input-icon-left` span has no rule
                             in the v4 engine, so the magnifier was no longer
                             an overlay on the field. The engine's
                             `InputGroupAddon` is the v4 equivalent. -->
                        <InputGroupAddon>
                            <i class="pi pi-search" />
                        </InputGroupAddon>
                        <InputText aria-label="Search" placeholder="Search" class="w-full"></InputText>
                        <Button size="small" icon="pi pi-times" aria-label="Close" class="" @click="hideThemes"/>
                    </InputGroup>
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
                                <h5 class="vc-text-20 font-semibold mb-1">Bulma Blog Theme</h5>
                                <p class="mb-3 vc-text-13">Bulma is a multipurpose responsive VaahCms theme.</p>
                                <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                            </template>
                            <template #footer>
                                <Button size="small" label="Install" icon="pi pi-download" class="p-button-outlined"></Button>
                            </template>
                        </Card>
                    </div>
                    <div class="col-12 md:col-6">
                        <Card>
                            <template #header>
                                <img src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png" style="height: 15rem" />
                            </template>
                            <template #content>
                                <h5 class="vc-text-20 font-semibold mb-1">Bulma Blog Theme</h5>
                                <p class="mb-3 vc-text-13">Bulma is a multipurpose responsive VaahCms theme.</p>
                                <Tag value="Name: Bulma blog theme" class="mr-2 mb-2"></Tag>
                                <Tag value="Version: 0.0.4" class="mr-2 mb-2"></Tag>
                                <Tag value="Developed by: WebReinvent" class="mr-2 mb-2"></Tag>
                            </template>
                            <template #footer>
                                <Button size="small" label="Install" icon="pi pi-download" class="p-button-outlined"></Button>
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

/* UT-108 — the peer toolbar's sizing: the field takes the room the search
   cluster has, and the two list actions beside it keep their own width and
   never shrink (below 640px the cluster wraps, so they drop onto their own
   row). */
.extend-toolbar-field {
    flex: 1 1 220px;
    min-width: 0;
}

.extend-toolbar-action {
    flex: 0 0 auto;
}

</style>
