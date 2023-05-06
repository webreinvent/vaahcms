<script setup>
import {onMounted, reactive, ref} from "vue";

import { vaah } from '../../vaahvue/pinia/vaah'
import {useRoute} from 'vue-router';

import {useProfileStore} from '../../stores/store-profile'
import { useRootStore } from "../../stores/root";
import FileUploader from "./components/FileUploader.vue";

const store = useProfileStore();
const route = useRoute();
const root = useRootStore();
const useVaah = vaah();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getProfile();
});
</script>
<template>
    <div v-if="root && root.assets && store.profile" class="grid justify-content-center is-relative profile">
        <div class="col-4">
            <h5 class="mb-2">Public Avatar</h5>
            <p class="text-sm">You can upload your avatar here or change it at</p>
            <a href="https://en.gravatar.com/" target="_blank">gravatar.com</a>
        </div>
        <div class="col-5">
            <Card>
                <template #content>
                    <div class="field mb-4 flex justify-content-between align-items-center">
                        <Avatar :image="store.profile.avatar"
                                v-if="store.profile"
                                class="mr-3"
                                shape="circle"
                                size="xlarge">
                        </Avatar>

                        <div class="w-max">
                            <FileUploader v-if="root.assets.urls"
                                          placeholder="Upload Avatar"
                                          :maxFileSize="200000"
                                          :is_basic="true"
                                          :auto_upload="true"
                                          :uploadUrl="root.assets.urls.upload" >
                            </FileUploader>
                        </div>
                    </div>
                </template>

                <template v-if="store.profile.avatar_url" #footer>
                    <Button class="p-button-sm w-max"
                            data-testid="profile-save"
                            @click="store.removeAvatar"
                            label="Remove"></Button>
                </template>
            </Card>
        </div>
        <div class="col-4">
            <h5 class="mb-2">Profile Details</h5>
            <p class="text-sm">This information will appear on your profile</p>
        </div>
        <div class="col-5 p-fluid mt-3">
            <Card class="form">
                <template #content v-if="store.profile">
                    <div class="p-float-label mt-3">
                        <InputText id="email"
                                   data-testid="profile-email"
                                   v-model="store.profile.email"/>
                        <label for="email">Email</label>
                    </div>
                    <div class="p-float-label">
                        <InputText id="username"
                                   v-model="store.profile.username"
                                   data-testid="profile-username"/>
                        <label for="username">Username</label>
                    </div>
                    <div class="p-float-label">
                        <InputText id="display-name"
                                   v-model="store.profile.display_name"
                                   data-testid="profile-display_name"/>
                        <label for="display-name">Display Name</label>
                    </div>
                    <div class="p-float-label">
                        <Dropdown id="title"
                                  v-model="store.profile.title"
                                  :options="store.assets.name_titles"
                                  optionLabel="name"
                                  optionValue="slug"
                                  data-testid="profile-title"/>
                        <label for="title">Title</label>
                    </div>
                    <div class="p-float-label">
                        <InputText id="first-name"
                                   v-model="store.profile.first_name"
                                   data-testid="profile-first_name"/>
                        <label for="first-name">First Name</label>
                    </div>
                    <div class="p-float-label">
                        <InputText id="middle-name"
                                   v-model="store.profile.middle_name"
                                   data-testid="profile-middle_name"/>
                        <label for="middle-name">Middle Name</label>
                    </div>
                    <div class="p-float-label">
                        <InputText id="last-name"
                                   v-model="store.profile.last_name"
                                   data-testid="profile-last_name"/>
                        <label for="last-name">Last Name</label>
                    </div>
                    <span class="p-float-label">
                         <SelectButton v-model="store.profile.gender"
                                       :options="store.gender_options"
                                       optionLabel="name"
                                       optionValue="value"
                                       dataKey="value"
                                       data-testid="profile-gender"
                                       aria-labelledby="custom">
                            <template #option="slotProps">
                                <p>{{slotProps.option.name}}</p>
                            </template>
                        </SelectButton>
                        <label for="gender"></label>
                    </span>
                    <span class="p-float-label">
                        <AutoComplete v-model="store.profile.country"
                                      :suggestions="store.filtered_country"
                                      id="country"
                                      @complete="store.searchCountry($event)"
                                      @item-select="store.setCountry($event)"
                                      optionLabel="name"
                                      optionValue="name"
                                      class="w-full"
                                      data-testid="profile-country"
                                      input-class="p-inputtext-sm w-full"/>
                        <label for="country">Country</label>
                    </span>
                    <span class="p-float-label">
                        <AutoComplete class="w-full"
                                      v-model="store.profile.country_calling_code"
                                      :suggestions="store.filtered_country_codes"
                                      @complete="store.searchCountryCode($event)"
                                      @item-select="store.setCountryCode($event)"
                                      placeholder="Enter Your Country"
                                      optionLabel="calling_code"
                                      optionValue='calling_code'
                                      name="account-country"
                                      data-testid="register-country"
                        />

                           <label for="country-code">Country Code</label>
                    </span>
                    <span class="p-float-label">
                            <InputText id="phone"
                                       class="w-full"
                                       v-model="store.profile.phone"
                                       data-testid="profile-phone"
                                       type="number"/>
                            <label for="phone">Phone</label>
                    </span>
                    <span class="p-float-label">
                           <InputText id="website"
                                      v-model="store.profile.website"
                                      data-testid="profile-website"
                                      class="w-full"/>
                           <label for="website">Website</label>
                    </span>
                    <span class="p-float-label">
                         <Dropdown v-model="store.profile.timezone"
                                   :options="store.assets.timezones"
                                   optionLabel="name"
                                   optionValue="slug"
                                   :filter="true"
                                   :showClear="true"
                                   data-testid="profile-timezone"
                                   input-class="p-inputtext-sm w-full"
                         />
                        <label for="timezone">Timezone</label>
                    </span>
                    <span class="p-float-label">
                        <InputText id="alternate-email"
                                   v-model="store.profile.alternate_email"
                                   data-testid="profile-alternate_email"
                                   class="w-full"/>
                        <label for="alternate-email">Alternate Email</label>
                    </span>
                    <span class="p-float-label">
                        <Calendar inputId="date-dob"
                                  v-model="store.profile.birth"
                                  dateFormat="mm-dd-yy"
                                  data-testid="profile-dob"
                                  class="w-full"/>
                        <label for="date-dob">Date of birth</label>
                    </span>
                    <span class="p-float-label">
                        <Editor v-model="store.profile.bio"
                                editorStyle="height: 320px"
                                name="register-bio"
                                data-testid="profile-bio"
                        />
                    </span>
                </template>
                <template #footer>
                    <Button class="p-button-sm w-max"
                            data-testid="profile-save"
                            @click="store.storeProfile"
                            label="Save Profile"></Button>
                </template>
            </Card>
        </div>
        <div class="col-4" v-if="store.mfa_methods.length != 0">
            <h5 class="mb-2">Multi-Factor Authentication</h5>
            <p class="text-sm">Multi-factor Authentication (MFA) is an authentication method that
                requires the user to provide two or more verification factors to gain access to a resource.</p>
        </div>
        <div class="col-5 p-fluid mt-3" v-if="store.mfa_methods.length != 0">
            <Card class="form">
                <template #content>
                    <div class="p-float-label"
                         v-for="method in store.mfa_methods">
                        <Checkbox class="flex"
                                  :data-testid="'profile-'+method"
                                  :inputId="'mfa-method_'+method"
                                  v-model="store.profile.mfa_methods"
                                  :value="method" />
                        <label class="ml-2" :for="'mfa-method_'+method">
                            {{ useVaah.toLabel(method) }}
                        </label>
                    </div>
                </template>
                <template #footer>
                    <Button label="Save MFA"
                            data-testid="profile-save_mfa"
                            @click="store.storeProfile()"
                            class="w-max p-button-sm"/>
                </template>
            </Card>
        </div>
        <div class="col-4">
            <h5 class="mb-2">Password</h5>
            <p class="text-sm">After a successful password update, you will be redirected to the login page where you can log in with your new password.</p>
        </div>
        <div class="col-5 p-fluid mt-3">
            <Card class="form">
                <template #content>
                    <div class="p-float-label">
                        <Password v-model="store.reset_password.current_password" id="password" toggleMask></Password>
                        <label for="password">Current Password</label>
                    </div>
                    <div class="p-float-label">
                        <Password v-model="store.reset_password.new_password" id="new-password" toggleMask></Password>
                        <label for="new-password">New Password</label>
                    </div>
                    <div class="p-float-label">
                        <Password v-model="store.reset_password.confirm_password" id="confirm-password" toggleMask></Password>
                        <label for="confirm-password">Confirm Password</label>
                    </div>
                </template>
                <template #footer>
                    <Button label="Save Password"
                            data-testid="profile-save_password"
                            @click="store.storePassword"
                            class="w-max p-button-sm"></Button>
                </template>
            </Card>
        </div>
    </div>
</template>

<style lang="scss">

.p-fileupload{
    width: 100%;
    .p-fileupload-buttonbar{
        display:none;
    }
    .p-fileupload-content{
        padding:1rem;
        border:2px dashed #bfbfbf;
        border-radius: 4px;
    }
}
</style>
