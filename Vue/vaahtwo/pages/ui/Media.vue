<template>
    <div class="grid media">
        <div class="col-12 md:col-4">
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
                    <div class="form">
                    <FloatLabel>
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </FloatLabel>
                        <div class="field mb-4">
                            <FileUpload name="demo[]" url="./upload">
                                <template #empty>
                                    <p class="text-center vc-muted vc-text-13">Drag and drop files to here to upload.</p>
                                </template>
                            </FileUpload>
                        </div>
                        <FloatLabel>
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </FloatLabel>
                        <FloatLabel>
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </FloatLabel>

                        <FloatLabel class="mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </FloatLabel>
                        <p class="vc-muted vc-text-12 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                        <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-12 md:col-4">
            <Card>
                <template #header><h5 class="font-semibold vc-text-16">Multiple File Upload</h5></template>
                <template #content>
                    <div class="mb-5">
                        <FileUpload mode="basic" name="demo[]" url="./upload.php" accept="image/*" :maxFileSize="1000000" @upload="onUpload" class="w-full"/>
                    </div>
                    <div class="flex justify-content-between align-items-center mb-5">
                        <h6 class="font-semibold vc-text-14">Media List (3)</h6>
                        <span>
                                <Button size="small" icon="pi pi-plus" class=" mr-2" @click="handleAccordion('expand')"></Button>
                                <Button size="small" icon="pi pi-minus" class="" @click="handleAccordion('collapse')"></Button>
                            </span>
                    </div>
                    <Accordion id="accordion-container" :value="active_index" :multiple="true">
                        <AccordionPanel :value="0">
                            <AccordionHeader>                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="vc-text-14 inline">Lorem.jpg</p> <br>
                                        <p class="vc-text-13 inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button size="small" severity="danger" icon="pi pi-trash"></Button>
                                </div>
                            </AccordionHeader>
                            <AccordionContent>

                            
                            <div class="form">
                    <FloatLabel>
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </FloatLabel>

                                <FloatLabel class="mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </FloatLabel>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="vc-muted vc-text-12 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                                </span>
                                    <Button size="small" label="Save" class="" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        
                            </AccordionContent>
                        </AccordionPanel>
                        <AccordionPanel :value="1">
                            <AccordionHeader>                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="vc-text-14 inline">Lorem.jpg</p> <br>
                                        <p class="vc-text-13 inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button size="small" severity="danger" icon="pi pi-trash"></Button>
                                </div>
                            </AccordionHeader>
                            <AccordionContent>

                            
                            <div class="form">
                    <FloatLabel>
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </FloatLabel>

                                <FloatLabel class="mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </FloatLabel>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="vc-muted vc-text-12 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption"
                                                  :options="download_options"
                                                  option-value="value"
                                                  option-label="label"></SelectButton>
                                </span>
                                    <Button size="small" label="Save" class="" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        
                            </AccordionContent>
                        </AccordionPanel>
                        <AccordionPanel :value="2">
                            <AccordionHeader>                                <div class="flex align-items-center justify-content-between w-full">
                                    <div class="flex align-items-center">
                                        <img src="https://img.site/p/50/50/BDC3C8/solid-box" alt="" class="mr-3">
                                        <span>
                                        <p class="vc-text-14 inline">Lorem.jpg</p> <br>
                                        <p class="vc-text-13 inline">lorem ipsum dolor</p>
                                    </span>
                                    </div>
                                    <Button size="small" severity="danger" icon="pi pi-trash"></Button>
                                </div>
                            </AccordionHeader>
                            <AccordionContent>

                            
                            <div class="form">
                    <FloatLabel>
                        <InputText id="name" class="w-full"></InputText>
                        <label for="name">Name</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="title" class="w-full"></InputText>
                        <label for="title">Title</label>
                    </FloatLabel>
                                <FloatLabel>
                        <InputText id="alt-text" class="w-full"></InputText>
                        <label for="alt-text">Alternate Text</label>
                    </FloatLabel>

                                <FloatLabel class="mb-0">
                        <Textarea id="caption" class="w-full"></Textarea>
                        <label for="caption">Caption</label>
                    </FloatLabel>
                                <div class="flex justify-content-between align-items-end">
                                <span>
                                    <p class="vc-muted vc-text-12 ml-2 mb-1 mt-3">Is this a downloadable media?</p>
                                    <SelectButton :v-model="downloadOption" :options="download_options" option-value="value" option-label="label"></SelectButton>
                                </span>
                                    <Button size="small" label="Save" class="" icon="pi pi-save"></Button>
                                </div>
                            </div>
                        
                            </AccordionContent>
                        </AccordionPanel>
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
