<template>
    <div class="user-form form">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="font-semibold text-sm">Create</h5>
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Save & New" icon="pi pi-pencil" class="p-button-sm"/>
                        <Button @click="toggle" class="p-button-sm" icon="pi pi-caret-down"/>
                        <Button icon="pi pi-times" class="p-button-sm"/>
                    </div>
                    <TieredMenu :model="menu_options" ref="menu" :popup="true">
                    </TieredMenu>
                </div>
            </template>
            <template #content>
                    <div class="field mb-4 flex justify-content-between align-items-center">
                        <img src="https://img.site/p/100/100/BDC3C8/solid-box" alt="" width="64" height="64" style="border-radius: 50%">
                        <div class="w-max">
                            <FileUpload mode="basic" name="demo[]" url="./upload.php" accept="image/*" :maxFileSize="1000000" @upload="onUpload"/>
                        </div>
                    </div>
                   <span class="p-float-label">
                       <InputText id="email" class="w-full"></InputText>
                       <label for="email">Email</label>
                   </span>
                    <span class="p-float-label">
                        <InputText id="username" class="w-full"></InputText>
                        <label for="username">Username</label>
                    </span>
                    <span class="p-float-label">
                        <Password v-model="value1" :feedback="false" id="password" class="w-full" inputClass="w-full"/>
                        <label for="password">Password</label>
                    </span>
                    <span class="p-float-label">
                        <InputText id="display-name" class="w-full"></InputText>
                        <label for="display-name">Display Name</label>
                    </span>
                    <span class="p-float-label">
                         <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                         <label for="country-code">Designation</label>
                    </span>
                    <span class="p-float-label">
                          <InputText id="designation" class="w-full"></InputText>
                          <label for="designation">Designation</label>
                    </span>
                    <span class="p-float-label">
                           <InputText id="first-name" class="w-full"></InputText>
                           <label for="first-name">First Name</label>
                    </span>
                    <span class="p-float-label">
                            <InputText id="middle-name" class="w-full"></InputText>
                            <label for="middle-name">Middle Name</label>
                    </span>
                    <span class="p-float-label">
                            <InputText id="last-name" class="w-full"></InputText>
                            <label for="last-name">Last Name</label>
                    </span>
                    <span class="p-float-label">
                             <SelectButton v-model="gender" :options="gender_options" optionLabel="label" dataKey="value"
                                           aria-labelledby="custom">
                                <template #option="slotProps">
                                    <p>{{slotProps.option.label}}</p>
                                </template>
                            </SelectButton>
                            <label for="gender"></label>
                    </span>
                    <span class="p-float-label">
                           <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                           <label for="country-code">Country Code</label>
                    </span>
                    <span class="p-float-label">
                            <InputText id="phone" class="w-full"></InputText>
                            <label for="phone">Phone</label>
                    </span>
                    <span class="p-float-label">
                         <Editor :v-model="bio" editorStyle="height: 320px"/>
                           <label for="bio">Bio</label>
                    </span>
                    <span class="p-float-label">
                           <InputText id="website" class="w-full"></InputText>
                           <label for="website">Website</label>
                    </span>
                    <span class="p-float-label">
                            <AutoComplete v-model="selectedCountry1" :suggestions="filteredCountries" id="timezone"
                                          @complete="searchCountry($event)" optionLabel="name"
                                          class="w-full"
                                          input-class="p-inputtext-sm w-full"/>
                            <label for="timezone">Timezone</label>
                    </span>
                    <span class="p-float-label">
                           <InputText id="alternate-email" class="w-full"></InputText>
                           <label for="alternate-email">Alternate Email</label>
                    </span>
                    <span class="p-float-label">
                        <Calendar id="dob" inputId="basic" v-model="date1" autocomplete="off" class="w-full"/>
                        <label for="dob">Date of birth</label>
                    </span>
                    <span class="p-float-label">
                        <AutoComplete v-model="selectedCountry1" :suggestions="filteredCountries" id="country"
                                  @complete="searchCountry($event)" optionLabel="name"
                                  class="w-full"
                                  input-class="p-inputtext-sm w-full"/>
                        <label for="country">Country</label>
                    </span>
                    <span class="p-float-label">
                         <Dropdown v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                         <label for="country-code">Status</label>
                    </span>
                    <span class="p-float-label">
                        <SelectButton v-model="is_active" :options="is_active_options" optionLabel="brand">
                            <template #option="slotProps">
                                <span class="text-sm">{{slotProps.option.label}}</span>
                            </template>
                        </SelectButton>
                    </span>
            </template>
        </Card>
    </div>
</template>

<script>
export default {
    name: "UsersForm",
    data() {
        return {
            bio:"",
            gender: null,
            gender_options: [
                {
                    label: 'Male',
                    value: 'male'
                },
                {
                    label: 'Female',
                    value: 'female'
                },
                {
                    label: 'Others',
                    value: 'others'
                }
            ],
            menu_options:[
                {
                    label:'Save & Close',
                    icon:'pi pi-fw pi-file'
                },
                {
                    label:'Save & Clone',
                    icon:'pi pi-fw pi-pencil'
                },
                {
                    label:'Reset',
                    icon:'pi pi-fw pi-user'
                }
                ],
            is_active:null,
            is_active_options:[
                {
                    label:'Active',
                    value:'active'
                },
                {
                    label:'Inactive',
                    value:'inactive'
                }
            ]
        }
    },
    methods:{
        toggle(event) {
            this.$refs.menu.toggle(event);
        }
    }
}
</script>

<style lang="scss">
.form {
    .p-float-label {
        &:not(:last-child) {
            margin-bottom: 25px;
        }
    }
}
</style>
