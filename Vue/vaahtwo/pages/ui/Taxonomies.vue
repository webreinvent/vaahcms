<template>
    <div class="grid taxonomies">
        <div class="col-12 md:col-6"></div>
        <div class="col-12 md:col-6 form">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h5 class="font-semibold vc-text-16">Create</h5>
                        <InputGroup class="justify-content-end">
                            <Button size="small" label="Save & New" icon="pi pi-pencil" class=""/>
                            <Button size="small" class="" icon="pi pi-caret-down" @click="toggle"/>
                            <Button size="small" icon="pi pi-times" class=""/>
                        </InputGroup>
                        <TieredMenu :model="menu_options" ref="menu" :popup="true">
                        </TieredMenu>
                    </div>
                </template>
                <template #content>
                    <InputGroup>
                    <FloatLabel>
                         <Select id="dropdown-type"></Select>
                        <label for="dropdown-type">Type</label>
                    </FloatLabel>
                        <Button label="Manage" style="margin-bottom: 25px" @click="onShow"></Button>
                    </InputGroup>
                    <FloatLabel>
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="slug" class="w-full"></InputText>
                        <label for="slug">Slug</label>
                    </FloatLabel>
                    <FloatLabel>
                    <Textarea id="notes" class="w-full"></Textarea>
                    <label for="notes">Notes</label>
                </FloatLabel>
                    <FloatLabel>
                    <InputText id="seo-title" class="w-full"></InputText>
                    <label for="seo-title">Seo Title</label>
                </FloatLabel>
                    <FloatLabel>
                        <AutoComplete v-model="value1" id="seo-keywords" class="w-full" inputClass="w-full" :multiple="true" :typeahead="false"/>
                        <label for="seo-keywords">Seo Keywords</label>
                    </FloatLabel>
                    <FloatLabel class="mb-0">
                    <Textarea id="seo-desc" class="w-full"></Textarea>
                    <label for="seo-desc">Seo Description</label>
                </FloatLabel>
                    <p class="vc-muted vc-text-12 ml-2 mb-1 mt-3">Is Active</p>
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

import Button from 'openvue/button';
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
