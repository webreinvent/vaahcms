<template>
    <div class="grid taxonomies">
        <div class="col-12 md:col-6"></div>
        <div class="col-12 md:col-6 form">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h5 class="font-semibold text-sm">Create</h5>
                        <div class="p-inputgroup justify-content-end">
                            <Button label="Save & New" icon="pi pi-pencil" class="p-button-sm"/>
                            <Button class="p-button-sm" icon="pi pi-caret-down" @click="toggle"/>
                            <Button icon="pi pi-times" class="p-button-sm"/>
                        </div>
                        <TieredMenu :model="menu_options" ref="menu" :popup="true">
                        </TieredMenu>
                    </div>
                </template>
                <template #content>
                    <div class="p-inputgroup">
                    <span class="p-float-label">
                         <Dropdown id="dropdown-type"></Dropdown>
                        <label for="dropdown-type">Type</label>
                    </span>
                        <Button label="Manage" style="margin-bottom: 25px" @click="onShow"></Button>
                    </div>
                    <span class="p-float-label">
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </span>
                    <span class="p-float-label">
                        <InputText id="slug" class="w-full"></InputText>
                        <label for="slug">Slug</label>
                    </span>
                    <span class="p-float-label">
                    <Textarea id="notes" class="w-full"></Textarea>
                    <label for="notes">Notes</label>
                </span>
                    <span class="p-float-label">
                    <InputText id="seo-title" class="w-full"></InputText>
                    <label for="seo-title">Seo Title</label>
                </span>
                    <span class="p-float-label">
                        <Chips v-model="value1" id="seo-keywords" class="w-full" inputClass="w-full"/>
                        <label for="seo-keywords">Seo Keywords</label>
                    </span>
                    <span class="p-float-label mb-0">
                    <Textarea id="seo-desc" class="w-full"></Textarea>
                    <label for="seo-desc">Seo Description</label>
                </span>
                    <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is Active</p>
                    <SelectButton v-model="status" :options="status_options" option-label="label" option-value="value"></SelectButton>
                </template>
            </Card>
        </div>
        <DynamicDialog/>
    </div>
</template>

<script>
import TaxonomiesModal from "../../components/organisms/TaxonomiesModal.vue";
import { h } from 'vue';

import Button from 'primevue/button';
export default {
    name: "Taxonomies",
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
            status:null,
            status_options:[
                {
                    label:'Yes',
                    value:true
                },
                {
                    label:'No',
                    value:false
                }
            ]
        }
    },
    methods:{
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        onShow() {
            const dialogRef = this.$dialog.open(TaxonomiesModal, {
                props: {
                    header: 'Taxonomy Types',
                    style: {
                        width: '600px',
                    },
                    breakpoints:{
                        '960px': '75vw',
                        '640px': '90vw'
                    },
                    modal: true
                },
                templates: {
                    footer: () => {
                        return [
                            h(Button, { label: "No", icon: "pi pi-times", onClick: () => dialogRef.close({ buttonType: 'No' }), class: "p-button-text" }),
                            h(Button, { label: "Yes", icon: "pi pi-check", onClick: () => dialogRef.close({ buttonType: 'Yes' }), autofocus: true })
                        ]
                    }
                },
                onClose: (options) => {
                    const data = options.data;
                    if (data) {
                        const buttonType = data.buttonType;
                        const summary_and_detail = buttonType ? { summary: 'No Product Selected', detail: `Pressed '${buttonType}' button` } : { summary: 'Product Selected', detail: data.name };

                        this.$toast.add({ severity:'info', ...summary_and_detail, life: 3000 });
                    }
                }
            });
        }
    }
}
</script>

<style lang="scss">

</style>
