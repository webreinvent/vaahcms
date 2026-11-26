<template>
    <div class="user-form form">
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center">
                    <h5 class="font-semibold vc-text-16">Create</h5>
                    <InputGroup class="justify-content-end">
                        <Button size="small" label="Save & New" icon="pi pi-pencil" class=""/>
                        <Button size="small" @click="toggle" class="" icon="pi pi-caret-down"/>
                        <Button size="small" icon="pi pi-times" class=""/>
                    </InputGroup>
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
                   <FloatLabel>
                       <InputText id="email" class="w-full"></InputText>
                       <label for="email">Email</label>
                   </FloatLabel>
                    <FloatLabel>
                        <InputText id="username" class="w-full"></InputText>
                        <label for="username">Username</label>
                    </FloatLabel>
                    <FloatLabel>
                        <Password v-model="value1" :feedback="false" id="password" class="w-full" inputClass="w-full"/>
                        <label for="password">Password</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="display-name" class="w-full"></InputText>
                        <label for="display-name">Display Name</label>
                    </FloatLabel>
                    <FloatLabel>
                         <Select v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                         <label for="country-code">Designation</label>
                    </FloatLabel>
                    <FloatLabel>
                          <InputText id="designation" class="w-full"></InputText>
                          <label for="designation">Designation</label>
                    </FloatLabel>
                    <FloatLabel>
                           <InputText id="first-name" class="w-full"></InputText>
                           <label for="first-name">First Name</label>
                    </FloatLabel>
                    <FloatLabel>
                            <InputText id="middle-name" class="w-full"></InputText>
                            <label for="middle-name">Middle Name</label>
                    </FloatLabel>
                    <FloatLabel>
                            <InputText id="last-name" class="w-full"></InputText>
                            <label for="last-name">Last Name</label>
                    </FloatLabel>
                    <FloatLabel>
                             <SelectButton v-model="gender" :options="gender_options" optionLabel="label" dataKey="value"
                                           aria-labelledby="custom">
                                <template #option="slotProps">
                                    <p>{{slotProps.option.label}}</p>
                                </template>
                            </SelectButton>
                            <label for="gender"></label>
                    </FloatLabel>
                    <FloatLabel>
                           <Select v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                           <label for="country-code">Country Code</label>
                    </FloatLabel>
                    <FloatLabel>
                            <InputText id="phone" class="w-full"></InputText>
                            <label for="phone">Phone</label>
                    </FloatLabel>
                    <FloatLabel>
                         <Editor :v-model="bio" editorStyle="height: 320px"/>
                           <label for="bio">Bio</label>
                    </FloatLabel>
                    <FloatLabel>
                           <InputText id="website" class="w-full"></InputText>
                           <label for="website">Website</label>
                    </FloatLabel>
                    <FloatLabel>
                            <AutoComplete size="small" v-model="selectedCountry1" :suggestions="filteredCountries" id="timezone" @complete="searchCountry($event)" optionLabel="name" class="w-full" input-class=" w-full"/>
                            <label for="timezone">Timezone</label>
                    </FloatLabel>
                    <FloatLabel>
                           <InputText id="alternate-email" class="w-full"></InputText>
                           <label for="alternate-email">Alternate Email</label>
                    </FloatLabel>
                    <FloatLabel>
                        <DatePicker id="dob" inputId="basic" v-model="date1" autocomplete="off" class="w-full"/>
                        <label for="dob">Date of birth</label>
                    </FloatLabel>
                    <FloatLabel>
                        <AutoComplete size="small" v-model="selectedCountry1" :suggestions="filteredCountries" id="country" @complete="searchCountry($event)" optionLabel="name" class="w-full" input-class=" w-full"/>
                        <label for="country">Country</label>
                    </FloatLabel>
                    <FloatLabel>
                         <Select v-model="selectedCity1" :options="cities" optionLabel="name" optionValue="code" id="country-code" class="w-full"/>
                         <label for="country-code">Status</label>
                    </FloatLabel>
                    <FloatLabel>
                        <SelectButton v-model="is_active" :options="is_active_options" optionLabel="brand">
                            <template #option="slotProps">
                                <span class="vc-text-12">{{slotProps.option.label}}</span>
                            </template>
                        </SelectButton>
                    </FloatLabel>
            </template>
        </Card>
    </div>
</template>

<script>
import {labelEditorToolbarWhenReady} from '../../vaahvue/utils/editorToolbarLabels';

export default {
    name: "UsersForm",
    mounted() {
        // UT-94 (M6-T4a Batch 19) — this showcase renders the same rich-text
        // editor as the app's own forms, so its toolbar (and its dropdown
        // pickers) need the same accessible names.
        labelEditorToolbarWhenReady();
    },
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
    /* M3-T2 (F10): v3 float-label wrapper class → v4 (OpenVue FloatLabel)
       `p-floatlabel`. */
    .p-floatlabel {
        &:not(:last-child) {
            margin-bottom: 25px;
        }
    }
}
</style>
