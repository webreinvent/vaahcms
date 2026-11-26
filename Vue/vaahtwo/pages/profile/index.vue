<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
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

import { useConfirm } from "openvue/useconfirm";
import {labelEditorToolbarWhenReady} from '../../vaahvue/utils/editorToolbarLabels';
const confirm = useConfirm();
onMounted(async () => {
    // UT-64 — Quill renders its toolbar without accessible names.
    labelEditorToolbarWhenReady();

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
        <!-- UT-129 (UAT sweep) — the screen's single top-level heading. The
             profile screen has no visible title element (it opens with a
             card), so the <h1> is announced but not rendered. -->
        <h1 class="vaah-sr-only">Profile</h1>
        <div class="col-4">
            <h2 class="mb-2 vaah-type-section">Public Avatar</h2>
            <p class="vaah-type-secondary">You can upload your avatar here or change it at</p>
            <a href="https://en.gravatar.com/" target="_blank">gravatar.com</a>
        </div>
        <div class="col-5">
            <Card>
                <template #content>
                    <div class="field mb-4 flex justify-content-between align-items-center">
                        <Avatar :image="store.profile.avatar"
                                v-if="store.profile"
                                class="mr-3 border-circle"
                                shape="circle"
                                size="xlarge">
                        </Avatar>

                        <div class="w-max">
                            <FileUploader v-if="root.assets.urls"
                                          placeholder="Upload Avatar"
                                          :maxFileSize="10000000"
                                          :is_basic="true"
                                          :auto_upload="true"
                                          :uploadUrl="root.assets.urls.upload" >
                            </FileUploader>
                        </div>
                    </div>
                </template>

                <template v-if="store.profile.avatar_url" #footer>
                    <Button size="small" class=" w-max" data-testid="profile-remove_avatar" @click="store.removeAvatar" label="Remove"></Button>
                </template>
            </Card>
        </div>
        <div class="col-4">
            <h2 class="mb-2 vaah-type-section">Profile Details</h2>
            <p class="vaah-type-secondary">This information will appear on your profile</p>
        </div>
        <Fluid class="col-5 mt-3">
            <Card class="form">
                <template #content v-if="store.profile">
                    <FloatLabel class="mt-3">
                        <InputText id="email"
                                   data-testid="profile-email"
                                   v-model="store.profile.email"/>
                        <label for="email">Email</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="username"
                                   v-model="store.profile.username"
                                   data-testid="profile-username"/>
                        <label for="username">Username</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="display-name"
                                   v-model="store.profile.display_name"
                                   data-testid="profile-display_name"/>
                        <label for="display-name">Display Name</label>
                    </FloatLabel>
                    <FloatLabel>
                        <Select inputId="title"
                                  v-model="store.profile.title"
                                  :options="store.assets.name_titles"
                                  optionLabel="name"
                                  optionValue="slug"
                                  data-testid="profile-title"/>
                        <label for="title">Title</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="first-name"
                                   v-model="store.profile.first_name"
                                   data-testid="profile-first_name"/>
                        <label for="first-name">First Name</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="middle-name"
                                   v-model="store.profile.middle_name"
                                   data-testid="profile-middle_name"/>
                        <label for="middle-name">Middle Name</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="last-name"
                                   v-model="store.profile.last_name"
                                   data-testid="profile-last_name"/>
                        <label for="last-name">Last Name</label>
                    </FloatLabel>
                    <FloatLabel>
                         <SelectButton v-model="store.profile.gender"
                                       :options="store.gender_options"
                                       optionLabel="name"
                                       optionValue="value"
                                       dataKey="value"
                                       data-testid="profile-gender"
                                       aria-label="Gender">
                            <template #option="slotProps">
                                <p>{{slotProps.option.name}}</p>
                            </template>
                        </SelectButton>
                        <label for="gender"></label>
                    </FloatLabel>
                    <FloatLabel>
                        <AutoComplete size="small" v-model="store.profile.country" :suggestions="store.filtered_country" inputId="country" @complete="store.searchCountry($event)" @item-select="store.setCountry($event)" optionLabel="name" optionValue="name" class="w-full" data-testid="profile-country" input-class=" w-full"/>
                        <label for="country">Country</label>
                    </FloatLabel>
                    <FloatLabel>
                        <AutoComplete class="w-full"
                                      inputId="country-code"
                                      v-model="store.profile.country_calling_code"
                                      :suggestions="store.filtered_country_codes"
                                      @complete="store.searchCountryCode($event)"
                                      @item-select="store.setCountryCode($event)"
                                      placeholder="Enter Your Country"
                                      optionLabel="calling_code"
                                      optionValue='calling_code'
                                      name="account-country"
                                      data-testid="profile-country_calling_code"
                        />

                           <label for="country-code">Country Code</label>
                    </FloatLabel>
                    <FloatLabel>
                            <InputText id="phone"
                                       class="w-full"
                                       v-model="store.profile.phone"
                                       data-testid="profile-phone"
                                       type="number"/>
                            <label for="phone">Phone</label>
                    </FloatLabel>
                    <FloatLabel>
                           <InputText id="website"
                                      v-model="store.profile.website"
                                      data-testid="profile-website"
                                      class="w-full"/>
                           <label for="website">Website</label>
                    </FloatLabel>
                    <FloatLabel>
                         <Select size="small" inputId="timezone" v-model="store.profile.timezone" :options="store.assets.timezones" optionLabel="name" optionValue="slug" :filter="true" :showClear="true" data-testid="profile-timezone" input-class=" w-full" />
                        <label for="timezone">Timezone</label>
                    </FloatLabel>
                    <FloatLabel>
                        <InputText id="alternate-email"
                                   v-model="store.profile.alternate_email"
                                   data-testid="profile-alternate_email"
                                   class="w-full"/>
                        <label for="alternate-email">Alternate Email</label>
                    </FloatLabel>
                    <FloatLabel>
                        <DatePicker inputId="date-dob"
                                  v-model="store.profile.birth"
                                  dateFormat="mm-dd-yy"
                                  data-testid="profile-dob"
                                  class="w-full"/>
                        <label for="date-dob">Date of birth</label>
                    </FloatLabel>
                    <FloatLabel>
                        <Editor v-model="store.profile.bio"
                                aria-label="Bio"
                                editorStyle="height: 160px"
                                name="register-bio"
                                data-testid="profile-bio"
                        />
                    </FloatLabel>
                </template>
                <template #footer>
                    <Button size="small" class=" w-max" data-testid="profile-save" @click="store.storeProfile" label="Save Profile"></Button>
                </template>
            </Card>
        </Fluid>
        <div class="col-4" v-if="store.mfa_methods.length != 0">
            <h2 class="mb-2 vaah-type-section">Multi-Factor Authentication</h2>
            <p class="vaah-type-secondary">Multi-factor Authentication (MFA) is an authentication method that
                requires the user to provide two or more verification factors to gain access to a resource.</p>
        </div>
        <Fluid class="col-5 mt-3">
            <Card class="form">
                <template #content>
                    <FloatLabel v-for="method in store.mfa_methods" :key="method">
                        <Checkbox class="flex"
                                  :data-testid="'profile-'+method"
                                  :inputId="'mfa-method_'+method"
                                  v-model="store.profile.mfa_methods"
                                  :value="method" />
                        <label class="ml-2" :for="'mfa-method_'+method">
                            {{ useVaah.toLabel(method) }}
                        </label>
                    </FloatLabel>
                </template>
                <template #footer>
                    <Button size="small" label="Save MFA" data-testid="profile-save_mfa" @click="store.storeProfile()" class="w-max"/>
                </template>
            </Card>
        </Fluid>
        <div class="col-4">
            <h2 class="mb-2 vaah-type-section">Password</h2>
            <p class="vaah-type-secondary">After a successful password update, you will be redirected to the login page where you can log in with your new password.</p>
        </div>
        <Fluid class="col-5 mt-3">
            <Card class="form">
                <template #content>
                    <FloatLabel>
                        <Password v-model="store.reset_password.current_password" inputId="password" :pt="{ pcInputText: { root: { 'data-testid': 'profile-current_password' } } }" toggleMask></Password>
                        <label for="password">Current Password</label>
                    </FloatLabel>
                    <FloatLabel>
                        <Password v-model="store.reset_password.new_password" inputId="new-password" :pt="{ pcInputText: { root: { 'data-testid': 'profile-new_password' } } }" toggleMask></Password>
                        <label for="new-password">New Password</label>
                    </FloatLabel>
                    <FloatLabel>
                        <Password v-model="store.reset_password.confirm_password" inputId="confirm-password" :pt="{ pcInputText: { root: { 'data-testid': 'profile-confirm_password' } } }" toggleMask></Password>
                        <label for="confirm-password">Confirm Password</label>
                    </FloatLabel>
                </template>
                <template #footer>
                    <Button size="small" label="Save Password" data-testid="profile-save_password" @click="store.storePassword" class="w-max"></Button>
                </template>
            </Card>
        </Fluid>
    </div>
</template>

<style scoped>
/* UT-127 (UAT sweep) — the "gravatar.com" link in the Public Avatar card is
   an inline <a>: its hit area was exactly its text box (15px tall), below
   the contract's 24px minimum interactive size — the same defect class
   UT-107 (footer) and UT-126 (dashboard meta line) closed. Symmetric
   padding on the inline element (no display change, so the line box does
   not move) grows the target to 25px. `p + a` pins the rule to this link
   only. */
p + a {
    padding: 5px 2px;
}
</style>
