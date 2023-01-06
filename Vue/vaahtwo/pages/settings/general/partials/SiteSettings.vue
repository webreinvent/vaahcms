<script setup>
import {onMounted, ref} from "vue";
import {useRoute} from 'vue-router';

import {useSettingStore} from '../../stores/store-settings';
import { vaah } from '../../vaahvue/pinia/vaah';

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useSettingStore();
const route = useRoute();
const useVaah = vaah();

</script>

<template>
    <div v-if="store.assets && store.list">
        <template #header>
            <div class="w-full">
                <div>
                    <h5 class="font-semibold text-sm">Site Settings</h5>
                    <p class="text-color-secondary text-xs">After a successful password update, you will be redirected to
                        the login page where you can log in with your new password.</p>
                </div>
            </div>
        </template>
        <div class="grid justify-content-evenly">
            <div class="col-12 md:col-6 pr-4">
                <div class="grid p-fluid">
                    <div class="col-12">
                        <h5 class="p-1 text-xs mb-1">Site Title</h5>
                        <div class="p-inputgroup">
                            <InputText class="" v-model="store.list.site_title" id="site-title"/>
                            <Button icon="pi pi-copy" class=""/>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="p-1 text-xs mb-1">Default Site Language</h5>
                        <Dropdown v-model="store.list.language"
                                  :options="store.assets.languages"
                                  placeholder="Select a Language"/>
                    </div>
                    <div class="col-6">
                        <h5 class="p-1 text-xs mb-1">Redirect after Frontend Login</h5>
                        <div class="p-inputgroup">
                            <InputText v-model="store.list.redirect_after_frontend_login" />
                            <Button icon="pi pi-copy" class=""/>
                        </div>
                    </div>
                    <div class="col-7">
                        <h5 class="p-1 text-xs mb-1">Meta Description</h5>
                        <div class="p-inputgroup">
                            <Textarea v-model="store.list.site_description" :autoResize="true" class="w-full"/>
                            <Button icon="pi pi-copy" class="has-max-height"/>
                        </div>
                    </div>
                    <div class="col-5">
                        <h5 class="p-1 text-xs mb-1">Meta Description</h5>
                        <div class="p-inputgroup">
                            <SelectButton v-model="visibility" :options="visibitlityOptions" aria-labelledby="single"/>
                            <Button icon="pi pi-copy" class=""/>
                        </div>
                    </div>
                    <div class="col-12 p-fluid">
                        <h5 class="p-1 text-xs mb-1">Assign Role(s) on Registration</h5>
                        <Chips v-model="registrationRoles" id="registration-roles" placeholder="Search"/>
                    </div>
                    <div class="col-12 p-fluid">
                        <h5 class="p-1 text-xs mb-1">Allowed file types for upload</h5>
                        <Chips v-model="allowedFiles" id="allowed-files" inputClass="w-full" class="w-full"></Chips>
                    </div>
                    <div class="col-12">
                        <h5 class="p-1 text-xs mb-1">Redirect after Backend Logout</h5>
                        <div class="p-inputgroup">
                            <SelectButton v-model="redirectAfterLogout" :options="redirectAfterLogoutOptions"
                                          aria-labelledby="single" class="p-button-sm"/>
                            <InputText placeholder="Enter Redirection Link"
                                       :disabled="redirectAfterLogout !== 'Custom'"></InputText>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 md:col-6 pl-4">
                <div class="grid">
                    <div class="col-12">
                        <h5 class="p-1 text-xs mb-1">Copyright Text</h5>
                        <div class="p-inputgroup">
                            <div class="field-radiobutton mr-2">
                                <RadioButton inputId="copyright-app-name" name="city" value="app-name" v-model="copyrightText" />
                                <label for="copyright-app-name">Use App Name</label>
                            </div>
                            <div class="field-radiobutton">
                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightText" />
                                <label for="copyright-custom">Custom</label>
                            </div>
                        </div>
                        <InputText class="w-full" v-if="copyrightText === 'custom'" placeholder="Enter Custom Text"></InputText>
                    </div>
                    <div class="col-12">
                        <h5 class="p-1 text-xs mb-1">Copyright Link</h5>
                        <div class="p-inputgroup">
                            <div class="field-radiobutton mr-2">
                                <RadioButton inputId="copyright-link" name="city" value="app-name" v-model="copyrightLink" />
                                <label for="copyright-link">Use App Url</label>
                            </div>
                            <div class="field-radiobutton">
                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightLink" />
                                <label for="copyright-custom">Custom</label>
                            </div>
                        </div>
                        <InputText class="w-full" v-if="copyrightLink === 'custom'" placeholder="Enter Custom Link"></InputText>
                    </div>
                    <div class="col-12">
                        <h5 class="p-1 text-xs mb-1">Copyright Year</h5>
                        <div class="p-inputgroup">
                            <div class="field-radiobutton mr-2">
                                <RadioButton inputId="copyright-year" name="city" value="app-name" v-model="copyrightYear" />
                                <label for="copyright-year">Use Current year</label>
                            </div>
                            <div class="field-radiobutton">
                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightYear" />
                                <label for="copyright-custom">Custom</label>
                            </div>
                        </div>
                        <Calendar inputId="yearpicker" v-model="date10" view="year" dateFormat="yy"  v-if="copyrightYear === 'custom'" input-class="w-full" class="w-full"
                                  placeholder="Choose Copyright Year" />
                    </div>
                    <div class="col-6">
                        <h5 class="p-1 text-xs mb-1">Max number of forgot password attempts</h5>
                        <div class="p-inputgroup">
                            <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                            <Button icon="pi pi-copy" class=""/>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="p-1 text-xs mb-1">Maximum number of login attempts</h5>
                        <div class="p-inputgroup">
                            <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                            <Button icon="pi pi-copy" class=""/>
                        </div>
                    </div>
                    <div class="col-4 p-fluid">
                        <h5 class="p-1 text-xs mb-1">Password Protection</h5>
                        <SelectButton v-model="passwordProtection" :options="passwordProtectionOptions" class="p-button-sm"
                                      aria-labelledby="single"/>
                    </div>
                    <div class="col-4 p-fluid">
                        <h5 class="p-1 text-xs mb-1">Laravel Queues</h5>
                        <SelectButton v-model="laravelQueues" :options="laravelQueuesOptions" class="p-button-sm" aria-labelledby="single"/>
                    </div>
                    <div class="col-4 p-fluid">
                        <h5 class="p-1 text-xs mb-1">Maintenance Mode</h5>
                        <SelectButton v-model="maintenanceMode" :options="maintenanceModeOptions" class="p-button-sm" aria-labelledby="single"/>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                <Button label="Save Settings" icon="pi pi-save" class="mr-2 p-button-sm"></Button>
                <Button label="Clear Cache" icon="pi pi-trash" class="p-button-danger p-button-sm"></Button>
            </div>
        </div>
    </div>
</template>

<style lang="scss">

</style>
