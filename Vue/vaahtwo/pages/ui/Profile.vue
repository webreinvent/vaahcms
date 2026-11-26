<template>
<div class="grid justify-content-center is-relative profile">
    <div class="col-4">
        <h5 class="mb-2">Public Avatar</h5>
        <p class="vc-text-13">You can upload your avatar here or change it at</p>
        <a class="vc-text-13" href="">gravatar.com</a>
    </div>
    <div class="col-5">
        <Card>
            <template #content>
                <div class="flex">
                    <Avatar image="https://www.gravatar.com/avatar/98431994177b4bb856d3f03dbee7ba03.jpg?s=80&d=mp&r=g"  class="mr-3" shape="circle" size="xlarge"/>
                    <FileUpload name="demo[]" class="w-full avatar-upload">
                        <template #header="{ chooseCallback, uploadCallback, clearCallback, files }">
                           <p></p>
                        </template>
                            <template #content="{ files, uploadedFiles, removeUploadedFileCallback, fileRemoveCallback }">

                            </template>
                        <template #empty>
                            <div class="flex align-items-center justify-content-center flex-column">
                                <i class="pi pi-cloud-upload border-2 border-circle p-3 text-400 border-400" />
                                <p class="mt-4 mb-0 vc-text-13">Drag and drop files to here to upload.</p>
                            </div>
                        </template>
                    </FileUpload>
                </div>
            </template>
        </Card>
    </div>
    <div class="col-4">
        <h5 class="mb-2">Profile Details</h5>
        <p class="vc-text-13">This information will appear on your profile</p>
    </div>
    <Fluid class="col-5 mt-3">
        <Card class="form">
            <template #content>
                <FloatLabel>
                    <InputText id="email"></InputText>
                    <label for="email">Email</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText id="username"></InputText>
                    <label for="username">Username</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText id="display-name"></InputText>
                    <label for="display-name">Display Name</label>
                </FloatLabel>
                <FloatLabel>
                    <Select id="title"></Select>
                    <label for="title">Title</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText id="first-name"></InputText>
                    <label for="first-name">First Name</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText id="middle-name"></InputText>
                    <label for="middle-name">Middle Name</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText id="last-name"></InputText>
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
                            <InputText id="phone" class="w-full" type="number"></InputText>
                            <label for="phone">Phone</label>
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
                                <span class="vc-text-14">{{slotProps.option.label}}</span>
                            </template>
                        </SelectButton>
                    </FloatLabel>
            </template>
            <template #footer>
                <Button size="small" class=" w-max" label="Save Profile"></Button>
            </template>
        </Card>
    </Fluid>
    <div class="col-4">
        <h5 class="mb-2">Password</h5>
        <p class="vc-text-13">After a successful password update, you will be redirected to the login page where you can log in with your new password.</p>
    </div>
    <Fluid class="col-5 mt-3">
        <Card class="form">
            <template #content>
                <FloatLabel>
                    <Password v-model="value3" id="password" toggleMask></Password>
                    <label for="password">Current Password</label>
                </FloatLabel>
                <FloatLabel>
                    <Password v-model="value3" id="new-password" toggleMask></Password>
                    <label for="new-password">New Password</label>
                </FloatLabel>
                <FloatLabel>
                    <Password v-model="value3" id="confirm-password" toggleMask></Password>
                    <label for="confirm-password">Confirm Password</label>
                </FloatLabel>
            </template>
            <template #footer>
                <Button size="small" label="Save Password" class="w-max"></Button>
            </template>
        </Card>
    </Fluid>
    <div class="col-12 mt-5">
        <div class="vc-text-12 text-center footer-text"><p>
            © 2022.
            <a class="vc-link" href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
            v1.6.10
            | <a class="vc-link" href="https://docs.vaah.dev/vaahcms" target="_blank">Documentation</a></p> <p class="text-center">
            Laravel v8.41.0
            | PHP v8.0.18
        </p>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Profile",
    data(){
        return{
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
            ]
        }
    }
}
</script>

<style lang="scss">


</style>
