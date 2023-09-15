<template>
    <Card class="notification-settings">
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h4 class="font-semibold text-lg">Notification</h4>
                <Button icon="pi pi-plus" label="Add" class="p-button-sm"></Button>
            </div>
        </template>
        <template #content>
            <div class="grid" v-if="!show">
                <div class="col">
                    <DataTable :value="notifications" stripedRows responsiveLayout="scroll" class="p-datatable-sm" showGridlines>
                        <Column header="Notification Title">
                            <template #body="slotProps">
                                <p>{{slotProps.data.title}}</p>
                            </template>
                        </Column>
                        <Column header="Edit">
                            <template #body="slotProps">
                                <Button icon="pi pi-pencil" @click="showNotificationSettings(slotProps.index)" class="p-button-rounded p-button-sm"></Button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
            <div class="grid" v-else>
                <div class="col-12 mb-3">
                    <div class="flex align-items-center justify-content-between">
                        <h4 class="font-semibold text-xl">{{activeNotification.title}}</h4>
                        <Button class="p-button-outlined p-button-sm" label="Go back" icon="pi pi-arrow-left" icon-class="text-xs" v-if="show" @click="hideNotificationSettings"></Button>
                    </div>
                </div>
                <div class="col-3 pr-3">
                    <h5 class="text-lg font-semibold mb-4">Variables</h5>
                    <div class="p-inputgroup mb-3">
                        <AutoComplete placeholder="Search"></AutoComplete>
                    </div>
                    <div class="notification-variables pt-2 pr-1">
                        <div class="p-inputgroup mb-3" v-for="item in activeNotification.variables">
                            <InputText :model-value="item" readonly></InputText>
                            <Button icon="pi pi-copy"></Button>
                            <Button icon="pi pi-question-circle" class="p-button-secondary"></Button>
                        </div>
                    </div>
                </div>
                <div class="col-9 pl-3 p-fluid">
                    <h5 class="text-lg font-semibold mb-4">Notification Options</h5>
                    <div class="grid justify-content-between">
                        <div class="col-5">
                            <h5 class="text-sm font-semibold mb-2">Deliver via</h5>
                            <div class="flex justify-content-between">
                <span>
              <h5 class="font-semibold text-xs mb-1">Mail</h5>
              <InputSwitch v-model="checked"  class="is-small"/>
            </span>
                                <span>
              <h5 class="font-semibold text-xs mb-1">SMS</h5>
              <InputSwitch v-model="checked"  class="is-small"/>
            </span>
                                <span>
              <h5 class="font-semibold text-xs mb-1">Push</h5>
              <InputSwitch v-model="checked"  class="is-small"/>
            </span>
                                <span>
              <h5 class="font-semibold text-xs mb-1">Frontend</h5>
              <InputSwitch v-model="checked"  class="is-small"/>
            </span>
                                <span>
              <h5 class="font-semibold text-xs mb-1">Backend</h5>
              <InputSwitch v-model="checked"  class="is-small"/>
            </span>
                            </div>
                        </div>
                        <div class="col-6 justify-content-end flex">
           <span class="text-right">
              <h5 class="font-semibold text-xs mb-1">Error notifications</h5>
              <InputSwitch v-model="checked" class="is-small"/>
           </span>
                        </div>
                        <div class="col-12">
                            <TabView ref="tabview1">
                                <TabPanel header="Mail" content-class="p-0">
                                    <div>

                                        <h5 class="p-1 text-xs mb-1 mt-3">Subject</h5>
                                        <div class="p-inputgroup">
                                            <InputText placeholder="Enter Subject"></InputText>
                                        </div>
                                        <h5 class="p-1 text-xs mb-1 mt-3">From</h5>
                                        <div class="p-inputgroup">
                                            <InputText placeholder="Enter From"></InputText>
                                        </div>
                                        <h5 class="p-1 text-xs mb-1 mt-3">Line</h5>
                                        <div class="p-inputgroup">
                                            <Textarea v-model="value" :autoResize="true" class="w-full" placeholder="Content with variables"/>
                                            <Button icon="pi pi-trash" class="has-max-height"/>
                                        </div>
                                        <h5 class="p-1 text-xs mb-1 mt-3">Greetings</h5>
                                        <div class="p-inputgroup">
                                            <InputText placeholder="Content with variables"></InputText>
                                        </div>
                                        <h5 class="p-1 text-xs mb-1 mt-3">Action</h5>
                                        <div class="p-inputgroup">
                                            <InputText placeholder="Enter action label"></InputText>
                                            <Dropdown placeholder="Choose an action"></Dropdown>
                                        </div>
                                        <div class="flex mt-5">
                                            <Button icon="" label="Add Subject" class="w-auto mr-2 p-button-sm" disabled></Button>
                                            <Button icon="" label="Add From" class="w-auto mr-2 p-button-sm"></Button>
                                            <Button icon="" label="Add Greetings" class="w-auto mr-2 p-button-sm"></Button>
                                            <Button icon="" label="Add Line" class="w-auto mr-2 p-button-sm"></Button>
                                            <Button icon="" label="Add Action" class="w-auto p-button-sm"></Button>
                                        </div>
                                    </div>
                                </TabPanel>
                                <TabPanel header="Backend">
                                    <div class="col-12 px-0">
                                        <h5 class="p-1 text-xs mb-1">Message</h5>
                                        <div class="p-inputgroup">
                                            <Textarea v-model="value" :autoResize="true" class="w-full" />
                                            <Button icon="pi pi-copy" class="has-max-height"/>
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <h5 class="p-1 text-xs mb-1">Action</h5>
                                        <div class="p-inputgroup">
                                            <InputText placeholder="Enter action label"></InputText>
                                            <Dropdown placeholder="Choose an action"></Dropdown>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <Button label="Save" icon="pi pi-save" class="w-auto mr-3 p-button-sm"></Button>
                                        <Button label="Test" icon="pi pi-reply" class="w-auto p-button-sm"></Button>
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
