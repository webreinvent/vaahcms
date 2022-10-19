<template>
<Card>
  <template #header>
    <div class="flex justify-content-between align-items-center">
      <h5 class="font-semibold text-lg">Localization</h5>
      <div class="p-inputgroup justify-content-end">
        <Button icon="pi pi-plus" label="Add Language"></Button>
        <Button icon="pi pi-plus" label="Add Category"></Button>
        <Button label="Reset"></Button>
        <Button icon="pi pi-refresh" label="Sync"></Button>
      </div>
    </div>
  </template>
  <template #content>
    <div class="grid justify-content-between">
      <div class="col-4 align-items-center flex">
          <Dropdown v-model="selectedLanguage" :options="languages" optionLabel="label" optionValue="value" placeholder="Select a Language" />
      </div>
      <div class="p-inputgroup col-4">
        <Dropdown v-model="selectedCategory" :options="categories" optionLabel="label" optionValue="value" placeholder="Select a Category" />
        <Dropdown v-model="selectedFilter" :options="filterOptions" optionLabel="label" optionValue="value" placeholder="Select a Filter" />
      </div>
    </div>
    <div class="grid mt-4">
      <div class="col-12 md:col-4" v-for="(item,index) in localizationVariables">
        <h5 class="text-left p-1">{{item.slug}}</h5>
        <div class="p-inputgroup">
          <InputText :model-value="item.value"></InputText>
          <Button icon="pi pi-copy" class=""/>
          <Button icon="pi pi-trash" class="p-button-danger"/>
        </div>
      </div>
    </div>
  </template>
</Card>
</template>

<script>
export default {
  name: "LocalizationSettings",
  data(){
    return{
      localizationVariables:[
        {
          slug:'title_required',
          value:'The title field is required.'
        },
        {
          slug:'title_limit',
          value:'The title character is not greater than 200.'
        },
        {
          slug:'slug_required',
          value:'The slug field is required.'
        },
        {
          slug:'slug_limit',
          value:'The slug character is not greater than 150.'
        }
      ],
        checked1:false,
        selectedFilter:'filled',
        filterOptions:[
            {
                label:'Empty Values',
                value:'empty'
            },
            {
                label:'Filled Values',
                value:'filled'
            }
        ],
        selectedCategory:null,
        categories:[
            {
                label:'Account Setting',
                value:'account-setting'
            },
            {
                label:'Change Password',
                value:'change-password'
            },
            {
                label:'Frontend Reset Password',
                value:'frontend-reset-password'
            },
            {
                label:'Frontend Sign In',
                value:'frontend-signin'
            }
        ],
        selectedLanguage:'en',
        languages:[
            {
                label:'English',
                value:'en'
            },
            {
                label:'Spanish',
                value:'sp'
            },
            {
                label:'Russian',
                value:'rs'
            }
        ]
    }
  }
}
</script>

<style scoped>

</style>
