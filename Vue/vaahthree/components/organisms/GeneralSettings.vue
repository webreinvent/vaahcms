<template>
    <div>
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h5 class="font-semibold text-lg">General Settings</h5>
                    <div>
                        <Button label="Expand all" class="p-button-sm mr-2" @click="expandAll"></Button>
                        <Button label="Collapse all" class="p-button-sm" @click="collapseAll"></Button>
                    </div>
                </div>
            </template>
            <template #content>
                <Accordion :multiple="true" :activeIndex="activeIndex" id="accordionTabContainer">
                    <AccordionTab>
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
                                            <InputText class="" id="site-title"/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 text-xs mb-1">Default Site Language</h5>
                                        <Dropdown
                                            class="is-small"
                                            v-model="selectedLanguage" :options="languages"
                                                  placeholder="Select a Language"/>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 text-xs mb-1">Redirect after Frontend Login</h5>
                                        <div class="p-inputgroup">
                                            <InputText/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="p-1 text-xs mb-1">Meta Description</h5>
                                        <div class="p-inputgroup">
                                            <Textarea v-model="value" :autoResize="true" class="w-full"/>
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
                    </AccordionTab>
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Date & Time</h5>
                                <p class="text-color-secondary text-xs">Global date and time settings.</p>
                            </div>
                        </template>
                        <div class="grid">
                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Date Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="dateFormat" :options="dateFormatOptions"></Dropdown>
                                    <InputText placeholder="Enter Custom date format" v-if="dateFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </div>
                            </div>
                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Time Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="timeFormat" :options="timeFormatOptions"></Dropdown>
                                    <InputText placeholder="Enter Custom time format" v-if="timeFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </div>
                            </div>
                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Date Time Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="dateTimeFormat" :options="dateTimeFormatOptions"></Dropdown>
                                    <InputText placeholder="Enter Custom date-time format" v-if="dateTimeFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </div>
                            </div>
                            <!--<div class="col-6">
                              <h5 class="text-left p-1">Date Format</h5>
                              <div class="p-inputgroup">
                                <SelectButton v-model="dateFormat" :options="dateFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="dateFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </div>
                            </div>
                            <div class="col-6">
                              <h5 class="text-left p-1">Time Format</h5>
                              <div class="p-inputgroup">
                                <SelectButton v-model="timeFormat" :options="timeFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="timeFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </div>
                            </div>
                            <div class="col-6">
                              <h5 class="text-left p-1">Date Time Format</h5>
                              <div class="p-inputgroup">
                                <SelectButton v-model="dateTimeFormat" :options="dateTimeFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="dateTimeFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </div>
                            </div>-->
                            <div class="col-12 mt-5">
                                <Button label="Save Settings" icon="pi pi-save" class="mr-2 p-button-sm"></Button>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Social Media & Links</h5>
                                <p class="text-color-secondary text-xs">Static links management.</p>
                            </div>
                        </template>
                        <div class="grid">

                            <div class="col-12 md:col-4" v-for="(item,index) in socialMediaLinks">
                                <h5 class="p-1 text-xs mb-1">{{ item.title }}</h5>
                                <div class="p-inputgroup p-fluid">
                  <span class="p-input-icon-left">
                    <i :class="'pi z-5 ' + item.icon"/>
                    <InputText type="text" :placeholder="'Enter ' + item.title + ' Link'" class="w-full p-inputtext-sm"/>
                  </span>
                                    <Button icon="pi pi-copy" class=" p-button-sm"/>
                                    <Button icon="pi pi-trash" class="p-button-danger p-button-sm"/>
                                </div>
                            </div>
                        </div>
                        <div class="grid mt-5">
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <InputText v-model="addLink" v-if="showLinkInput" class="p-inputtext-sm"></InputText>
                                    <Button label="Add Link" icon="pi pi-plus" class="p-button-sm" @click="addLinkHandler"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-8">
                                <div class="p-inputgroup justify-content-end">
                                    <Button label="Save" icon="pi pi-save" class="p-button-sm"></Button>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Scripts</h5>
                                <p class="text-color-secondary text-xs">Add scripts of Google Analytics and other tracking scripts.</p>
                            </div>
                        </template>
                        <div class="grid">
                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 text-xs mb-1">After head tag start (&lt;head&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </div>
                            </div>
                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After head tag close (&lt;/head&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </div>
                            </div>
                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 text-xs mb-1">After body tag start (&lt;body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </div>
                            </div>
                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After body tag close (&lt;/body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Meta Tags</h5>
                                <p class="text-color-secondary text-xs">Global meta tags.</p>
                            </div>
                        </template>
                        <div class="grid">
                            <div class="col-12">
                                <h5 class="p-1 text-xs mb-1">Meta Tag</h5>
                                <div class="p-inputgroup">
                                    <Dropdown input-class=""></Dropdown>
                                    <InputText></InputText>
                                    <Button label="Content" disabled=""></Button>
                                    <InputText></InputText>
                                </div>
                            </div>
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Button icon="pi pi-plus" label="Add Meta Tag" ></Button>
                                    <Button label="Save"></Button>
                                    <Button icon="pi pi-copy"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Dropdown v-model="metaOption" :options="metaOptions" option-label="label" option-value="value"></Dropdown>
                                    <Button label="Generate"></Button>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                    <AccordionTab>
                        <template #header>
                            <div class="w-full">
                                <h5 class="font-semibold text-sm">Securities</h5>
                                <p class="text-color-secondary text-xs">Enable and choose multiple methods of authentication</p>
                            </div>
                        </template>
                        <div class="grid">
                            <div class="col-12">
                                <h4 class="font-semibold text-sm">Multi-Factor Authentication</h4>
                                <p class="text-color-secondary text-xs font-semibold">Require a email OTP, sms OTP or authenticator app verification when you login with password.</p>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <div class="field-radiobutton">
                                        <RadioButton inputId="city1" name="city" value="Chicago" v-model="city" />
                                        <label for="city1">Disable</label>
                                    </div>
                                    <div class="field-radiobutton">
                                        <RadioButton inputId="city2" name="city" value="Los Angeles" v-model="city" />
                                        <label for="city2">Enable for all users</label>
                                    </div>
                                    <div class="field-radiobutton">
                                        <RadioButton inputId="city3" name="city" value="New York" v-model="city" />
                                        <label for="city3">Users will have option to enable it</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <h5 class="mb-3 font-semibold text-sm">MFA Methods</h5>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="is-small" v-model="checked" :binary="true" />
                                        <label for="binary">Email OTP Verification</label>
                                    </div>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="is-small" v-model="checked" :binary="true" />
                                        <label for="binary">SMS OTP Verification</label>
                                    </div>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="is-small" v-model="checked" :binary="true" />
                                        <label for="binary">Authenticator App (only user can enable this)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                </Accordion>
            </template>
        </Card>
    </div>
</template>

<script>
export default {
    name: "GeneralSettings",

    data() {
        return {
            activeIndex: [0],
            languages: ['English', 'Russian', 'Spanish'],
            selectedLanguage: 'English',
            visibility: 'Visible',
            visibitlityOptions: ['Visible', 'Invisible'],
            copyrightText: 'app-name',
            copyrightTextOptions: [{
                label:'Use App Name',
                value:'app-name'
            },
                {
                    label:'Custom',
                    value: 'custom'
                }
            ],
            copyrightLink: 'Use App Url',
            copyrightLinkOptions: [
                {
                    label:'Use App Url',
                    value:'app-url'
                },
                {
                    label:'Custom',
                    value: 'custom'
                }
            ],
            copyrightYear: 'Use Current Year',
            copyrightYearOptions: [
                {
                    label:'Use Current Year',
                    value:'current-year'
                },
                {
                    label:'Custom',
                    value: 'custom'
                }
            ],
            maintenanceMode: 'Disable',
            maintenanceModeOptions: ['Disable', 'Enable'],
            passwordProtection: 'Disable',
            passwordProtectionOptions: ['Disable', 'Enable'],
            laravelQueues: 'Enable',
            laravelQueuesOptions: ['Disable', 'Enable'],
            redirectAfterLogout: 'Backend',
            redirectAfterLogoutOptions: ['Backend', 'Frontend', 'Custom'],
            registrationRoles: ['Registered'],
            allowedFiles: ['jpg', 'jpeg'],
            dateFormatOptions: ['y-m-d', 'y/m/d', 'y.m.d', 'Custom'],
            dateFormat: 'y-m-d',
            timeFormatOptions: ['H:i:s', 'h:i A', 'h:i:s A', 'Custom'],
            timeFormat: 'H:i:s',
            dateTimeFormatOptions: ['Y-m-d H:i:s', 'Y-m-d h:i A', 'd-M-Y H:i', 'Custom'],
            dateTimeFormat: 'Y-m-d H:i:s',
            socialMediaLinks: [{title:'Facebook',icon:'pi-facebook'}, {title:'Twitter',icon:'pi-twitter'}, {title:'Linkedin',icon:'pi-linkedin'}, {title:'Youtube',icon:'pi-youtube'}, {title:'Instagram',icon:'pi-instagram'}, {title:'Github',icon:'pi-github'}],
            addLink: null,
            showLinkInput: true,
            metaOption:null,
            metaOptions: [
                {
                    label:'Google Webmaster',
                    value:'google-webmaster'
                },
                {
                    label:'Open Graph (Facebook)',
                    value: 'open-graph-fb'
                }
            ],

        }
    },

    methods: {
        expandAll() {
            let accordionTabs = document.getElementById('accordionTabContainer').children.length;
            for (let i = 0; i <= accordionTabs; i++) {
                this.activeIndex.push(i);
            }
        },
        collapseAll() {
            this.activeIndex = [];
        },
        addLinkHandler() {
            if (!this.showLinkInput) {
                return this.showLinkInput = true;
            } else if (this.showLinkInput && this.addLink !== "" && this.addLink !== null) {
                this.socialMediaLinks.push({title:this.addLink,icon:'pi-link'});
                this.addLink = null;
                return this.showLinkInput = true;
            }
        }
    }
}
</script>

<style lang="scss">

</style>
