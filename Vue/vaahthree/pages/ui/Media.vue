<template>
    <div class="grid media">
        <div class="col-12 md:col-4">
            <Card>
                <template #header>
                    <div class="flex justify-content-between align-items-center">
                        <h5 class="font-semibold text-lg">Create</h5>
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
                    <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </span>
                        <div class="field mb-4">
                            <FileUpload name="demo[]" url="./upload">
                                <template #empty>
                                    <p class="text-center text-sm text-gray-600">Drag and drop files to here to upload.</p>
                                </template>
                            </FileUpload>
                        </div>
                        <span class="p-float-label">
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </span>
                        <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </span>

                        <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </span>
                        <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                        <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-12 md:col-4">
            <Card>
                <template #header><h5 class="font-semibold text-lg">Multiple File Upload</h5></template>
                <template #content>
                    <div class="mb-5">
                        <FileUpload mode="basic" name="demo[]" url="./upload.php" accept="image/*" :maxFileSize="1000000" @upload="onUpload" class="w-full"/>
                    </div>
                    <div class="flex justify-content-between align-items-center mb-5">
                        <h6 class="font-semibold text-sm">Media List (3)</h6>
                        <span>
                                <Button icon="pi pi-plus" class="p-button-sm mr-2" @click="handleAccordion('expand')"></Button>
                                <Button icon="pi pi-minus" class="p-button-sm" @click="handleAccordion('collapse')"></Button>
                            </span>
                    </div>
                    <Accordion id="accordion-container" :active-index="active_index" :multiple="true">
                        <AccordionTab>
                            <template #header>
                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="text-sm inline">Lorem.jpg</p> <br>
                                        <p class="text-sm inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button class="p-button-sm p-button-danger" icon="pi pi-trash"></Button>
                                </div>
                            </template>
                            <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </span>

                                <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </span>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                                </span>
                                    <Button label="Save" class="p-button-sm" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="text-sm inline">Lorem.jpg</p> <br>
                                        <p class="text-sm inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button class="p-button-sm p-button-danger" icon="pi pi-trash"></Button>
                                </div>
                            </template>
                            <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </span>

                                <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </span>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption"
                                                  :options="download_options"
                                                  option-value="value"
                                                  option-label="label"></SelectButton>
                                </span>
                                    <Button label="Save" class="p-button-sm" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="text-sm inline">Lorem.jpg</p> <br>
                                        <p class="text-sm inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button class="p-button-sm p-button-danger" icon="pi pi-trash"></Button>
                                </div>
                            </template>
                            <div class="form">
                    <span class="p-float-label">
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </span>
                                <span class="p-float-label">
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </span>

                                <span class="p-float-label mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </span>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="text-xs text-gray-600 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                                </span>
                                    <Button label="Save" class="p-button-sm" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        </AccordionTab>
                    </Accordion>
                </template>
            </Card>
        </div>
    </div>
</template>

<script>

export default {
    name: "Media",
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
          downloadOption:null,
          download_options:[
              {
                  label:'Yes',
                  value:'yes'
              },
              {
                  label:'No',
                  value: 'no'
              }
          ],
          active_index:[0],
          accordion_container:null,
          accordions:null
      }
    },
    mounted(){
        this.accordion_container = document.getElementById('accordion-container') ;
        this.accordions = this.accordion_container.children;
    },
    methods:{
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        handleAccordion(action){
            if(action === 'expand'){
                for(let i = 0; i<= this.accordions.length; i++){
                    console.log(i);
                    this.active_index.push(i);
                }
            }else {
                this.active_index=[];
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>
