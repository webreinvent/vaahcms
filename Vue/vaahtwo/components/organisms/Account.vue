<template>
    <Message severity="info" :closable="true" class="vc-dense">Create first account,this account will have super administrator role and will have all the permissions.</Message>
    <Fluid class="grid">
        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">First name</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter first name" class=""/>
            </InputGroup>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Middle name</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter middle name" class=""/>
            </InputGroup>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Last name</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter last name" class=""/>
            </InputGroup>
        </div>
        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Email</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter email" class=""/>
            </InputGroup>
        </div>
    </Fluid>
    <Fluid class="grid">


        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Username</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter Username" class=""/>
            </InputGroup>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Password</h5>
            <InputGroup>
                <Password size="small" :feedback="false" toggleMask input-class="w-full" placeholder="Enter password"/>
            </InputGroup>
        </div>
        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Search Country</h5>
            <AutoComplete size="small" v-model="selectedCountry1" :suggestions="filteredCountries" @complete="searchCountry($event)" placeholder="Enter Your Country" optionLabel="name" input-class=""/>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 vc-text-12 mb-0">Phone</h5>
            <InputGroup>
                <InputText size="small" placeholder="Enter phone" class=""/>
            </InputGroup>
        </div>
    </Fluid>
    <Fluid class="grid">
        <div class="col-12 mt-3">
            <Button size="small" icon="pi pi-user-plus" label="Create Account" class=" w-auto vc-dense"/>
        </div>
        <div class="col-12">
            <div class="flex justify-content-between mt-3">
                <Button size="small" label="Back" class=" w-auto" @click="goBack"></Button>
                <Button size="small" icon="pi pi-external-link" label="Go to Backend Sign in" class=" w-auto"></Button>
            </div>
        </div>
    </Fluid>
</template>

<script>
import countriesData from "../../assets/data/country.json";
export default {
  name: "Account",
  data(){
    return{
      countries: null,
      selectedCountry1: null,
      filteredCountries: null,
    }
      },
  mounted() {
    this.countries = countriesData.data.map((country) => country.name);
  },
  methods: {
    goBack(){
      this.$router.push("/ui/public/install/dependencies")
    },
    searchCountry(event) {
      setTimeout(() => {
        if (!event.query.trim().length) {
          this.filteredCountries = [...this.countries];
        }
        else {
          this.filteredCountries = this.countries.filter((country) => {
            return country.toLowerCase().startsWith(event.query.toLowerCase());
          });
        }
      }, 250);
    }
  }
}
</script>

<style scoped>

</style>
