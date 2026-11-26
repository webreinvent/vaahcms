<template>
    <div class="container">
        <h6 class="p-1 vc-text-12 mb-1">App URL</h6>
        <Fluid class="grid">
            <div class="col-12">
                <div class="p-input">
                    <InputText size="small" placeholder="App URL" class="" id="app-url"/>

                </div>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">ENV</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Env" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Debug</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Debug" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Timezone</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Timezone" class=""/>
                </InputGroup>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12">
                <h5 class="p-1 vc-text-12 mb-0">App/Website Name</h5>
                <div class="p-input">
                    <InputText size="small" placeholder="App/Website Name" class="" id="app-url"/>

                </div>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Type</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Database Type" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Host</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Database Host" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Port</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Database Port" class=""/>
                </InputGroup>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Name</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Database Name" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Username</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Database Username" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Database Password</h5>
                <InputGroup>
                    <Password size="small" :feedback="false" toggleMask input-class="w-full" placeholder="Database Password"/>
                </InputGroup>
            </div>
        </Fluid>

        <Button size="small" label="Test Database connection" icon="pi pi-database" class=" my-4 vc-dense"/>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Provider</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Mail Provider" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Driver</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Mail Driver" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Host</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Mail Host" class=""/>
                </InputGroup>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Port</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Mail Port" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Username</h5>
                <InputGroup>
                    <InputText size="small" placeholder="Mail Username" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Password</h5>
                <InputGroup>
                    <Password size="small" :feedback="false" toggleMask input-class="w-full" placeholder="Mail Password"/>
                </InputGroup>
            </div>
        </Fluid>

        <Fluid class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">Mail Encryption</h5>
                <InputGroup>
                    <Select size="small" v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" placeholder="Select Mail Encryption" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">From Name</h5>
                <InputGroup>
                    <InputText size="small" placeholder="From Name" class=""/>
                </InputGroup>
            </div>

            <div class="col-12 md:col-4">
                <h5 class="p-1 vc-text-12 mb-0">From Email</h5>
                <InputGroup>
                    <InputText size="small" placeholder="From Email" class=""/>
                </InputGroup>
            </div>
        </Fluid>

        <Button size="small" label="Test Mail Configuration" icon="pi pi-envelope" class=" my-4 vc-dense"/>

        <Fluid class="grid">
            <div class="col-12">
                <div class="flex justify-content-end">
                    <Button size="small" label="Save & Next" class=" w-auto" @click="goToNextStep"></Button>
                </div>
            </div>
        </Fluid>

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
