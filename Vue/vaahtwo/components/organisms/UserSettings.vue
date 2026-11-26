<template>
<div>
  <Card>
    <template #header>
      <h4 class=" font-semibold vc-text-16">User Settings</h4>
    </template>
    <template #content>
      <Accordion :multiple="true" :value="activeIndex" id="accordionTabContainer">
        <AccordionPanel :value="0">
          <AccordionHeader>
            <div class="w-full">
              <div>
                <h5 class="font-semibold vc-text-14">Fields</h5>
              </div>
            </div>
          </AccordionHeader>
          <AccordionContent>
          <DataTable size="small" :value="data" class="" showGridlines scrollable>
            <Column field="fieldName" header="Field Name"></Column>
            <Column field="visibilityStatus" header="Is Hidden">
              <template #body="slotProps">
                <ToggleSwitch v-model="slotProps.data.visibilityStatus"  class="vc-dense"/>
              </template>
            </Column>
            <Column field="applyToRegistration" header="Apply To Registration">
              <template #body="slotProps">
                <Checkbox v-model="slotProps.data.applyToRegistration" :binary="true" class="vc-dense"/>
              </template>
            </Column>
          </DataTable>
          </AccordionContent>
        </AccordionPanel>
        <AccordionPanel :value="1">
          <AccordionHeader>
            <div class="w-full">
              <div>
                <h5 class="font-semibold vc-text-14">Custom Fields</h5>
              </div>
            </div>
          </AccordionHeader>
          <AccordionContent>
          <Message severity="info">The inputs of these fields will be stored in <strong>meta</strong> column.</Message>
          <p class="py-5 text-center">
            No Records
          </p>
          <div class="grid justify-content-between">
            <div class="col-12 md:col-3">
              <InputGroup>
                <Select v-model="selectedFieldType" :options="fieldTypes" optionLabel="name" optionValue="code" placeholder="Select a type" />
                <Button label="Add"></Button>
              </InputGroup>
            </div>
            <div class="col-12 md:col-3 flex justify-content-end">
              <Button size="small" icon="pi pi-save" label="Save" class=""></Button>
            </div>
          </div>
          </AccordionContent>
        </AccordionPanel>
      </Accordion>
    </template>
  </Card>
</div>
</template>

<script>
export default {
  name: "UserSettings",
  data(){
    return{
      activeIndex: [0],
      data: [
        {
          fieldName:'Display Name',
          visibilityStatus:"False",
          visibilityOptions:['True','False'],
          applyToRegistration:false
        },
        {
          fieldName:'Title',
          visibilityStatus:"True",
          visibilityOptions:['True','False'],
          applyToRegistration:false
        },
        {
          fieldName:'Designation',
          visibilityStatus:"False",
          visibilityOptions:['True','False'],
          applyToRegistration:true
        }
      ],
      selectedFieldType:null,
      // UT-119 (M7-T4): v4 Select declares optionLabel="name" optionValue="code"
      // (line 49). The v3-era string array made `option.name` undefined and
      // crashed the Select's `labelDataP` computed on mount (TypeError: reading
      // 'length'), leaving the whole card unmounted. Demo-data shape only —
      // same labels, plus the value codes the option already declared.
      fieldTypes:[{name:'Text',code:'text'},{name:'Email',code:'email'},{name:'TextArea',code:'textarea'},{name:'Number',code:'number'},{name:'Password',code:'password'}]
    }
  }
}
</script>

<style scoped>

</style>
