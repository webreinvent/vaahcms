<template>
    <Card class="notification-settings">
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h4 class="font-semibold vc-text-16">Notification</h4>
                <Button size="small" icon="pi pi-plus" label="Add" class=""></Button>
            </div>
        </template>
        <template #content>
            <div class="grid" v-if="!show">
                <div class="col">
                    <DataTable size="small" :value="notifications" stripedRows scrollable class="" showGridlines>
                        <Column header="Notification Title">
                            <template #body="slotProps">
                                <p>{{slotProps.data.title}}</p>
                            </template>
                        </Column>
                        <Column header="Edit">
                            <template #body="slotProps">
                                <Button size="small" icon="pi pi-pencil" @click="showNotificationSettings(slotProps.index)" class="p-button-rounded"></Button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
            <div class="grid" v-else>
                <div class="col-12 mb-3">
                    <div class="flex align-items-center justify-content-between">
                        <h4 class="font-semibold vc-text-20">{{activeNotification.title}}</h4>
                        <Button size="small" class="p-button-outlined" label="Go back" icon="pi pi-arrow-left" icon-class="vc-text-12" v-if="show" @click="hideNotificationSettings"></Button>
                    </div>
                </div>
                <div class="col-3 pr-3">
                    <h5 class="vc-text-16 font-semibold mb-4">Variables</h5>
                    <InputGroup class="mb-3">
                        <AutoComplete placeholder="Search"></AutoComplete>
                    </InputGroup>
                    <div class="notification-variables pt-2 pr-1">
                        <InputGroup class="mb-3">
                            <InputText :model-value="item" readonly></InputText>
                            <Button icon="pi pi-copy"></Button>
                            <Button icon="pi pi-question-circle" class="p-button-secondary"></Button>
                        </InputGroup>
                    </div>
                </div>
                <Fluid class="col-9 pl-3">
                    <h5 class="vc-text-16 font-semibold mb-4">Notification Options</h5>
                    <div class="grid justify-content-between">
                        <div class="col-5">
                            <h5 class="vc-text-14 font-semibold mb-2">Deliver via</h5>
                            <div class="flex justify-content-between">
                <span>
              <h5 class="font-semibold vc-text-12 mb-1">Mail</h5>
              <ToggleSwitch v-model="checked"  class="vc-dense"/>
            </span>
                                <span>
              <h5 class="font-semibold vc-text-12 mb-1">SMS</h5>
              <ToggleSwitch v-model="checked"  class="vc-dense"/>
            </span>
                                <span>
              <h5 class="font-semibold vc-text-12 mb-1">Push</h5>
              <ToggleSwitch v-model="checked"  class="vc-dense"/>
            </span>
                                <span>
              <h5 class="font-semibold vc-text-12 mb-1">Frontend</h5>
              <ToggleSwitch v-model="checked"  class="vc-dense"/>
            </span>
                                <span>
              <h5 class="font-semibold vc-text-12 mb-1">Backend</h5>
              <ToggleSwitch v-model="checked"  class="vc-dense"/>
            </span>
                            </div>
                        </div>
                        <div class="col-6 justify-content-end flex">
           <span class="text-right">
              <h5 class="font-semibold vc-text-12 mb-1">Error notifications</h5>
              <ToggleSwitch v-model="checked" class="vc-dense"/>
           </span>
                        </div>
                        <div class="col-12">
                                                        <Tabs value="0" ref="tabview1">
                                <TabList>
                                    <Tab value="0" content-class="p-0">Mail</Tab>
                                    <Tab value="1">Backend</Tab>
                                </TabList>
                                <TabPanels>
                                    <TabPanel value="0" content-class="p-0">

                                    <div>

                                        <h5 class="p-1 vc-text-12 mb-1 mt-3">Subject</h5>
                                        <InputGroup>
                                            <InputText placeholder="Enter Subject"></InputText>
                                        </InputGroup>
                                        <h5 class="p-1 vc-text-12 mb-1 mt-3">From</h5>
                                        <InputGroup>
                                            <InputText placeholder="Enter From"></InputText>
                                        </InputGroup>
                                        <h5 class="p-1 vc-text-12 mb-1 mt-3">Line</h5>
                                        <InputGroup>
                                            <Textarea v-model="value" :autoResize="true" class="w-full" placeholder="Content with variables"/>
                                            <Button icon="pi pi-trash" class="has-max-height"/>
                                        </InputGroup>
                                        <h5 class="p-1 vc-text-12 mb-1 mt-3">Greetings</h5>
                                        <InputGroup>
                                            <InputText placeholder="Content with variables"></InputText>
                                        </InputGroup>
                                        <h5 class="p-1 vc-text-12 mb-1 mt-3">Action</h5>
                                        <InputGroup>
                                            <InputText placeholder="Enter action label"></InputText>
                                            <Select placeholder="Choose an action"></Select>
                                        </InputGroup>
                                        <div class="flex mt-5">
                                            <Button size="small" icon="" label="Add Subject" class="w-auto mr-2" disabled></Button>
                                            <Button size="small" icon="" label="Add From" class="w-auto mr-2"></Button>
                                            <Button size="small" icon="" label="Add Greetings" class="w-auto mr-2"></Button>
                                            <Button size="small" icon="" label="Add Line" class="w-auto mr-2"></Button>
                                            <Button size="small" icon="" label="Add Action" class="w-auto"></Button>
                                        </div>
                                    </div>
                                                                    </TabPanel>
                                    <TabPanel value="1">

                                    <div class="col-12 px-0">
                                        <h5 class="p-1 vc-text-12 mb-1">Message</h5>
                                        <InputGroup>
                                            <Textarea v-model="value" :autoResize="true" class="w-full" />
                                            <Button icon="pi pi-copy" class="has-max-height"/>
                                        </InputGroup>
                                    </div>
                                    <div class="col-12 px-0">
                                        <h5 class="p-1 vc-text-12 mb-1">Action</h5>
                                        <InputGroup>
                                            <InputText placeholder="Enter action label"></InputText>
                                            <Select placeholder="Choose an action"></Select>
                                        </InputGroup>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <Button size="small" label="Save" icon="pi pi-save" class="w-auto mr-3"></Button>
                                        <Button size="small" label="Test" icon="pi pi-reply" class="w-auto"></Button>
                                    </div>
                                                                    </TabPanel>
                                </TabPanels>
                            </Tabs>
                        </div>
                    </div>
                </Fluid>
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
      checked:true,
        show:false,
        notifications: [
            {
                title:'Send Login OTP',
                variables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
            },
            {
                title:'Send Reset Password email',
                variables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
            },
            {
                title:'Send Update Message',
                variables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
            },
            {
                title:'Send Verification Email',
                variables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
            },
            {
                title:'Send Welcome Email',
                variables:['#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#','#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#','#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#','#!USER:NAME!#','#!USER:DISPLAY_NAME!#','#!USER:EMAIL!#','#!USER:PHONE!#'],
            },
        ],
        activeNotification:null
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
    showNotificationSettings(index){
        console.log(index);
        this.activeNotification = this.notifications[index];
        this.show = true;
    },
    hideNotificationSettings(){
        this.show  = false;
        this.activeNotification = null;
    }
  }
}
</script>

<style lang="scss">
.notification-settings{
    .p-tabview .p-tabview-panels{
        padding: 0;
    }
    .notification-variables{
        max-height: 50vh;
        overflow-y: auto;
        &::-webkit-scrollbar {
            width: 5px;
        }
        &::-webkit-scrollbar-track {
            width:5px;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }
        &::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
            width: 5px;
        }
    }
}
</style>
