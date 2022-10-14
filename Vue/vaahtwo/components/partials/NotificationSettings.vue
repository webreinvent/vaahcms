<template>
<Card>
  <template #header>
    <div class="pt-3 px-4 flex justify-content-between align-items-center">
      <h4 class="font-semibold text-lg">Notification</h4>
      <Button icon="pi pi-plus" label="Add"></Button>
    </div>
  </template>
  <template #content>
    <div class="grid" v-if="!show">
      <div class="col">
        <a @click="showNotificationSettings">Send Login OTP</a>
      </div>
    </div>
    <div class="grid" v-else>
      <div class="col-3 pr-3">
          <Button @click="showNotificationSettings">Back</Button>
        <div class="p-inputgroup mb-3" v-for="item in notificationVariables">
          <InputText :model-value="item" readonly></InputText>
          <Button icon="pi pi-copy"></Button>
          <Button icon="pi pi-question-circle" class="p-button-secondary"></Button>
        </div>
      </div>
      <div class="col-9 pl-3 p-fluid">
        <AutoComplete v-model="selectedCountry1" :suggestions="filteredCountries" @complete="searchCountry($event)" placeholder="Search" optionLabel="name"/>
        <h5 class="text-lg font-semibold my-4">Contact us notification</h5>
        <div class="grid justify-content-between">
          <div class="col-5 flex justify-content-between">
            <span>
              <h5 class="font-semibold text-xs">Mail</h5>
              <InputSwitch v-model="checked" />
            </span>
            <span>
              <h5 class="font-semibold text-xs">SMS</h5>
              <InputSwitch v-model="checked" />
            </span>
            <span>
              <h5 class="font-semibold text-xs">Push</h5>
              <InputSwitch v-model="checked" />
            </span>
            <span>
              <h5 class="font-semibold text-xs">Frontend</h5>
              <InputSwitch v-model="checked" />
            </span>
            <span>
              <h5 class="font-semibold text-xs">Backend</h5>
              <InputSwitch v-model="checked" />
            </span>
          </div>
          <div class="col-5 justify-content-end flex">
           <span class="text-right">
              <h5 class="font-semibold text-xs">Is this an error notifications?</h5>
              <InputSwitch v-model="checked" />
           </span>
          </div>
          <div class="col-12">
            <TabView ref="tabview1">
              <TabPanel header="Mail">
                <div>
                  <h5 class="text-left p-1">Subject</h5>
                  <div class="p-inputgroup">
                    <InputText></InputText>
                  </div>
                  <h5 class="text-left p-1">Line</h5>
                  <div class="p-inputgroup">
                    <Textarea v-model="value" :autoResize="true" class="w-full" />
                    <Button icon="pi pi-trash" class=""/>
                  </div>
                  <h5 class="text-left p-1">Line</h5>
                  <div class="p-inputgroup">
                    <Textarea v-model="value" :autoResize="true" class="w-full" />
                    <Button icon="pi pi-trash" class=""/>
                  </div>
                  <div class="flex mt-5">
                    <Button icon="" label="Add Subject" class="w-auto mr-2" disabled></Button>
                    <Button icon="" label="Add Form" class="w-auto mr-2"></Button>
                    <Button icon="" label="Add Greetings" class="w-auto mr-2"></Button>
                    <Button icon="" label="Add Line" class="w-auto mr-2"></Button>
                    <Button icon="" label="Add Action" class="w-auto"></Button>
                  </div>
                </div>
              </TabPanel>
              <TabPanel header="Backend">
                <div class="col-12">
                  <h5 class="text-left p-1">Message</h5>
                  <div class="p-inputgroup">
                    <Textarea v-model="value" :autoResize="true" class="w-full" />
                    <Button icon="pi pi-copy" class=""/>
                  </div>
                </div>
                <div class="col-12">
                  <h5 class="text-left p-1">Action</h5>
                  <div class="p-inputgroup">
                    <InputText placeholder="Enter action label"></InputText>
                    <Dropdown placeholder="Choose an action"></Dropdown>
                  </div>
                </div>
                <div class="col-12">
                  <Button label="Save" icon="pi pi-save" class="w-auto mr-3"></Button>
                  <Button label="Test" icon="pi pi-reply" class="w-auto"></Button>
                </div>
              </TabPanel>
            </TabView>
          </div>
        </div>
      </div>
    </div>
  </template>
</Card>
</template>

<script>
import countriesData from "../../assets/data/country.json";

export default {
  name: "NotificationSettings",
  data(){
    return{
      countries: null,
      selectedCountry1: null,
      filteredCountries: null,
      notificationVariables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
      checked:true,
        show:false
    }
  },
  mounted() {
    this.countries = countriesData.data.map((country) => country.name);
  },
  methods:{
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
    },
    showNotificationSettings(){
        this.show = !this.show;
    }
  }
}
</script>

<style scoped>

</style>
