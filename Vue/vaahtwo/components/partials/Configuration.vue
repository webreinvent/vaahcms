<template>
  <div class="container">
    <h5 class="text-left p-1 title is-6">App URL</h5>

    <div class="grid p-fluid">
      <div class="col-12">
        <div class="p-input">
          <InputText placeholder="App URL" class="p-inputtext-sm" id="app-url"/>

        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">ENV</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Debug</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Timezone</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12">
    <h5 class="text-left p-1 title is-6">App/Website Name</h5>
        <div class="p-input">
          <InputText placeholder="App/Website Name" class="p-inputtext-sm" id="app-url"/>

        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Type</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Host</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Host" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Port</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Port" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Name</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Username</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Host" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Database Password</h5>
        <div class="p-inputgroup">
          <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm" />
        </div>
      </div>
    </div>

    <Button label="Test Database connection" icon="pi pi-database" class="p-button-sm my-4 is-small"/>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Provider</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Driver</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Host" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Host</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Port" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Port</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Username</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Host" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Password</h5>
        <div class="p-inputgroup">
          <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <div class="grid p-fluid">
      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">Mail Encryption</h5>
        <div class="p-inputgroup">
          <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select a City" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Name</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Host" class="p-inputtext-sm"/>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <h5 class="text-left p-1 title is-6">From Email</h5>
        <div class="p-inputgroup">
          <InputText placeholder="Database Port" class="p-inputtext-sm"/>
        </div>
      </div>
    </div>

    <Button label="Test Mail Configuration" icon="pi pi-envelope" class="p-button-sm my-4 is-small"/>

    <div class="grid p-fluid">
      <div class="col-12">
        <div class="flex justify-content-end">
          <Button label="Save & Next" class="p-button-sm w-auto" @click="goToNextStep"></Button>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Configuration",
  data() {
    return {
      checked1: false,
      checked2: false,
      radioValue1: '',
      radioValue2: '',
      selectedCity1: null,
      cities: [
        {name: 'New York', code: 'NY'},
        {name: 'Rome', code: 'RM'},
        {name: 'London', code: 'LDN'},
        {name: 'Istanbul', code: 'IST'},
        {name: 'Paris', code: 'PRS'}
      ]
    }
  },
  methods:{
    goToNextStep(){
      this.$router.push("/install/migrate");
    },
  }

}
</script>

<style scoped>

</style>