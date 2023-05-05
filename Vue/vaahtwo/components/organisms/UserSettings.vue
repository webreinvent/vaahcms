<template>
<div>
  <Card>
    <template #header>
      <h4 class=" font-semibold text-lg">User Settings</h4>
    </template>
    <template #content>
      <Accordion :multiple="true" :activeIndex="activeIndex" id="accordionTabContainer">
        <AccordionTab>
          <template #header>
            <div class="w-full">
              <div>
                <h5 class="font-semibold text-sm">Fields</h5>
              </div>
            </div>
          </template>
          <DataTable :value="data" class="p-datatable-sm" showGridlines responsiveLayout="scroll">
            <Column field="fieldName" header="Field Name"></Column>
            <Column field="visibilityStatus" header="Is Hidden">
              <template #body="slotProps">
                <InputSwitch v-model="slotProps.data.visibilityStatus"  class="is-small"/>
              </template>
            </Column>
            <Column field="applyToRegistration" header="Apply To Registration">
              <template #body="slotProps">
                <Checkbox v-model="slotProps.data.applyToRegistration" :binary="true" class="is-small"/>
              </template>
            </Column>
          </DataTable>
        </AccordionTab>
        <AccordionTab>
          <template #header>
            <div class="w-full">
              <div>
                <h5 class="font-semibold text-sm">Custom Fields</h5>
              </div>
            </div>
          </template>
          <Message severity="info">The inputs of these fields will be stored in <strong>meta</strong> column.</Message>
          <p class="py-5 text-center">
            No Records
          </p>
          <div class="grid justify-content-between">
            <div class="col-12 md:col-3">
              <div class="p-inputgroup">
                <Dropdown v-model="selectedFieldType" :options="fieldTypes" optionLabel="name" optionValue="code" placeholder="Select a type" />
                <Button label="Add"></Button>
              </div>
            </div>
            <div class="col-12 md:col-3 flex justify-content-end">
              <Button icon="pi pi-save" label="Save" class="p-button-sm"></Button>
            </div>
          </div>
        </AccordionTab>
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
      fieldTypes:['Text','Email','TextArea','Number','Password']
    }
  }
}
</script>

<style scoped>

</style>
