<template>
    <div class="container">
        <h6 class="p-1 text-xs mb-1">App URL</h6>
        <div class="grid p-fluid">
            <div class="col-12">
                <div class="p-input">
                    <InputText placeholder="App URL" class="p-inputtext-sm" id="app-url"/>

                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">ENV</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Env" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Debug</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Debug" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Timezone</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Timezone" class="p-inputtext-sm"/>
                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12">
                <h5 class="p-1 text-xs mb-0">App/Website Name</h5>
                <div class="p-input">
                    <InputText placeholder="App/Website Name" class="p-inputtext-sm" id="app-url"/>

                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Type</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Database Type" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Host</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Database Host" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Port</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Database Port" class="p-inputtext-sm"/>
                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Name</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Database Name" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Username</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Database Username" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Database Password</h5>
                <div class="p-inputgroup">
                    <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm" placeholder="Database Password"/>
                </div>
            </div>
        </div>

        <Button label="Test Database connection" icon="pi pi-database" class="p-button-sm my-4 is-small"/>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Provider</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Mail Provider" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Driver</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Mail Driver" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Host</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Mail Host" class="p-inputtext-sm"/>
                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Port</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Mail Port" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Username</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="Mail Username" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Password</h5>
                <div class="p-inputgroup">
                    <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm" placeholder="Mail Password"/>
                </div>
            </div>
        </div>

        <div class="grid p-fluid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">Mail Encryption</h5>
                <div class="p-inputgroup">
                    <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Mail Encryption" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">From Name</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="From Name" class="p-inputtext-sm"/>
                </div>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-0">From Email</h5>
                <div class="p-inputgroup">
                    <InputText placeholder="From Email" class="p-inputtext-sm"/>
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
      this.$router.push({path:'/ui/public/install/migrate'});
    },
  }

}
</script>

<style scoped>

</style>
