<template>
    <Message severity="info" :closable="true" class="is-small">Create first account,this account will have super administrator role and will have all the permissions.</Message>
    <div class="grid p-fluid">
        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">First name</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter first name" class="p-inputtext-sm"/>
            </div>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Middle name</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter middle name" class="p-inputtext-sm"/>
            </div>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Last name</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter last name" class="p-inputtext-sm"/>
            </div>
        </div>
        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Email</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter email" class="p-inputtext-sm"/>
            </div>
        </div>
    </div>
    <div class="grid p-fluid">


        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Username</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter Username" class="p-inputtext-sm"/>
            </div>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Password</h5>
            <div class="p-inputgroup">
                <Password :feedback="false" toggleMask input-class="w-full p-inputtext-sm" placeholder="Enter password"/>
            </div>
        </div>
        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Search Country</h5>
            <AutoComplete v-model="selectedCountry1" :suggestions="filteredCountries" @complete="searchCountry($event)" placeholder="Enter Your Country" optionLabel="name" input-class="p-inputtext-sm"/>
        </div>

        <div class="col-12 md:col-3">
            <h5 class="p-1 text-xs mb-0">Phone</h5>
            <div class="p-inputgroup">
                <InputText placeholder="Enter phone" class="p-inputtext-sm"/>
            </div>
        </div>
    </div>
    <div class="grid p-fluid">
        <div class="col-12 mt-3">
            <Button icon="pi pi-user-plus" label="Create Account" class="p-button-sm w-auto is-small"/>
        </div>
        <div class="col-12">
            <div class="flex justify-content-between mt-3">
                <Button label="Back" class="p-button-sm w-auto" @click="goBack"></Button>
                <Button icon="pi pi-external-link" label="Go to Backend Sign in" class="p-button-sm w-auto"></Button>
            </div>
        </div>
    </div>
</template>

<script>
import countriesData from "../../assets/data/country.json";
import {FilterService,FilterMatchMode} from 'primevue/api';
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
