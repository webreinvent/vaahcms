<template>
    <div>
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h5 class="font-semibold vc-text-16">General Settings</h5>
                    <div>
                        <Button size="small" label="Expand all" class=" mr-2" @click="expandAll"></Button>
                        <Button size="small" label="Collapse all" class="" @click="collapseAll"></Button>
                    </div>
                </div>
            </template>
            <template #content>
                <Accordion :multiple="true" :value="activeIndex" id="accordionTabContainer">
                    <AccordionPanel :value="0">
                        <AccordionHeader>                            <div class="w-full">
                                <div>
                                    <h5 class="font-semibold vc-text-14">Site Settings</h5>
                                    <p class="text-color-secondary vc-text-13">After a successful password update, you will be redirected to
                                        the login page where you can log in with your new password.</p>
                                </div>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid justify-content-evenly">
                            <div class="col-12 md:col-6 pr-4">
                                <Fluid class="grid">
                                    <div class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Site Title</h5>
                                        <InputGroup>
                                            <InputText class="" id="site-title"/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </InputGroup>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 vc-text-12 mb-1">Default Site Language</h5>
                                        <Select
                                            class="vc-dense"
                                            v-model="selectedLanguage" :options="languages"
                                                  placeholder="Select a Language"/>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 vc-text-12 mb-1">Redirect after Frontend Login</h5>
                                        <InputGroup>
                                            <InputText/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </InputGroup>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="p-1 vc-text-12 mb-1">Meta Description</h5>
                                        <InputGroup>
                                            <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                            <Button icon="pi pi-copy" class="has-max-height"/>
                                        </InputGroup>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="p-1 vc-text-12 mb-1">Meta Description</h5>
                                        <InputGroup>
                                            <SelectButton v-model="visibility" :options="visibitlityOptions" aria-labelledby="single"/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </InputGroup>
                                    </div>
                                    <Fluid class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Assign Role(s) on Registration</h5>
                                        <AutoComplete v-model="registrationRoles" id="registration-roles" placeholder="Search" :multiple="true" :typeahead="false"/>
                                    </Fluid>
                                    <Fluid class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Allowed file types for upload</h5>
                                        <AutoComplete v-model="allowedFiles" id="allowed-files" inputClass="w-full" class="w-full" :multiple="true" :typeahead="false"/>
                                    </Fluid>
                                    <div class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Redirect after Backend Logout</h5>
                                        <InputGroup>
                                            <SelectButton size="small" v-model="redirectAfterLogout" :options="redirectAfterLogoutOptions" aria-labelledby="single" class=""/>
                                            <InputText placeholder="Enter Redirection Link"
                                                       :disabled="redirectAfterLogout !== 'Custom'"></InputText>
                                        </InputGroup>
                                    </div>
                                </Fluid>
                            </div>
                            <div class="col-12 md:col-6 pl-4">
                                <div class="grid">
                                    <div class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Copyright Text</h5>
                                        <InputGroup>
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-app-name" name="city" value="app-name" v-model="copyrightText" />
                                                <label for="copyright-app-name">Use App Name</label>
                                            </div>
                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightText" />
                                                <label for="copyright-custom">Custom</label>
                                            </div>
                                        </InputGroup>
                                        <InputText class="w-full" v-if="copyrightText === 'custom'" placeholder="Enter Custom Text"></InputText>
                                    </div>
                                    <div class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Copyright Link</h5>
                                        <InputGroup>
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-link" name="city" value="app-name" v-model="copyrightLink" />
                                                <label for="copyright-link">Use App Url</label>
                                            </div>
                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightLink" />
                                                <label for="copyright-custom">Custom</label>
                                            </div>
                                        </InputGroup>
                                        <InputText class="w-full" v-if="copyrightLink === 'custom'" placeholder="Enter Custom Link"></InputText>
                                    </div>
                                    <div class="col-12">
                                        <h5 class="p-1 vc-text-12 mb-1">Copyright Year</h5>
                                        <InputGroup>
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-year" name="city" value="app-name" v-model="copyrightYear" />
                                                <label for="copyright-year">Use Current year</label>
                                            </div>
                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightYear" />
                                                <label for="copyright-custom">Custom</label>
                                            </div>
                                        </InputGroup>
                                        <DatePicker inputId="yearpicker" v-model="date10" view="year" dateFormat="yy"  v-if="copyrightYear === 'custom'" input-class="w-full" class="w-full"
                                                  placeholder="Choose Copyright Year" />
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 vc-text-12 mb-1">Max number of forgot password attempts</h5>
                                        <InputGroup>
                                            <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </InputGroup>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="p-1 vc-text-12 mb-1">Maximum number of login attempts</h5>
                                        <InputGroup>
                                            <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                                            <Button icon="pi pi-copy" class=""/>
                                        </InputGroup>
                                    </div>
                                    <Fluid class="col-4">
                                        <h5 class="p-1 vc-text-12 mb-1">Password Protection</h5>
                                        <SelectButton size="small" v-model="passwordProtection" :options="passwordProtectionOptions" class="" aria-labelledby="single"/>
                                    </Fluid>
                                    <Fluid class="col-4">
                                        <h5 class="p-1 vc-text-12 mb-1">Laravel Queues</h5>
                                        <SelectButton size="small" v-model="laravelQueues" :options="laravelQueuesOptions" class="" aria-labelledby="single"/>
                                    </Fluid>
                                    <Fluid class="col-4">
                                        <h5 class="p-1 vc-text-12 mb-1">Maintenance Mode</h5>
                                        <SelectButton size="small" v-model="maintenanceMode" :options="maintenanceModeOptions" class="" aria-labelledby="single"/>
                                    </Fluid>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <Button size="small" label="Save Settings" icon="pi pi-save" class="mr-2"></Button>
                                <Button size="small" label="Clear Cache" icon="pi pi-trash" class="p-button-danger"></Button>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel :value="1">
                        <AccordionHeader>                            <div class="w-full">
                                <h5 class="font-semibold vc-text-14">Date & Time</h5>
                                <p class="text-color-secondary vc-text-13">Global date and time settings.</p>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid">
                            <div class="col-4">
                                <h5 class="p-1 vc-text-12 mb-1">Date Format</h5>
                                <InputGroup>
                                    <Select v-model="dateFormat" :options="dateFormatOptions"></Select>
                                    <InputText placeholder="Enter Custom date format" v-if="dateFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </InputGroup>
                            </div>
                            <div class="col-4">
                                <h5 class="p-1 vc-text-12 mb-1">Time Format</h5>
                                <InputGroup>
                                    <Select v-model="timeFormat" :options="timeFormatOptions"></Select>
                                    <InputText placeholder="Enter Custom time format" v-if="timeFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </InputGroup>
                            </div>
                            <div class="col-4">
                                <h5 class="p-1 vc-text-12 mb-1">Date Time Format</h5>
                                <InputGroup>
                                    <Select v-model="dateTimeFormat" :options="dateTimeFormatOptions"></Select>
                                    <InputText placeholder="Enter Custom date-time format" v-if="dateTimeFormat === 'Custom'"></InputText>
                                    <Button icon="pi pi-copy" class=""/>
                                </InputGroup>
                            </div>
                            <!--<div class="col-6">
                              <h5 class="text-left p-1">Date Format</h5>
                              <InputGroup>
                                <SelectButton v-model="dateFormat" :options="dateFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="dateFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </InputGroup>
                            </div>
                            <div class="col-6">
                              <h5 class="text-left p-1">Time Format</h5>
                              <InputGroup>
                                <SelectButton v-model="timeFormat" :options="timeFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="timeFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </InputGroup>
                            </div>
                            <div class="col-6">
                              <h5 class="text-left p-1">Date Time Format</h5>
                              <InputGroup>
                                <SelectButton v-model="dateTimeFormat" :options="dateTimeFormatOptions" aria-labelledby="single"/>
                                <InputText v-if="dateTimeFormat === 'Custom'"></InputText>
                                <Button icon="pi pi-copy" class=""/>
                              </InputGroup>
                            </div>-->
                            <div class="col-12 mt-5">
                                <Button size="small" label="Save Settings" icon="pi pi-save" class="mr-2"></Button>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel :value="2">
                        <AccordionHeader>                            <div class="w-full">
                                <h5 class="font-semibold vc-text-14">Social Media & Links</h5>
                                <p class="text-color-secondary vc-text-13">Static links management.</p>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid">

                            <div class="col-12 md:col-4" v-for="(item,index) in socialMediaLinks">
                                <h5 class="p-1 vc-text-12 mb-1">{{ item.title }}</h5>
                                <Fluid><InputGroup>
                  <!-- UT-117 — v3's `p-input-icon-left` span has no rule in
                       the v4 engine (the icon is no longer an overlay on the
                       field); the engine's `InputGroupAddon` is the v4
                       equivalent. `:fluid="false"` keeps the two actions
                       out of the v4 `<Fluid>` component's fluid context
                       (which renders every descendant Button
                       `p-button-fluid`, i.e. width: 100%). -->
                  <InputGroupAddon>
                    <i :class="'pi z-5 ' + item.icon"/>
                  </InputGroupAddon>
                    <InputText size="small" type="text" :placeholder="'Enter ' + item.title + ' Link'" class="w-full"/>
                                    <Button size="small" :fluid="false" icon="pi pi-copy" aria-label="Copy to clipboard" class=""/>
                                    <Button size="small" :fluid="false" icon="pi pi-trash" aria-label="Remove link" class="p-button-danger"/>
                                </InputGroup></Fluid>
                            </div>
                        </div>
                        <div class="grid mt-5">
                            <div class="col-12 md:col-4">
                                <InputGroup>
                                    <InputText size="small" v-model="addLink" v-if="showLinkInput" class=""></InputText>
                                    <Button size="small" label="Add Link" icon="pi pi-plus" class="" @click="addLinkHandler"></Button>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-8">
                                <InputGroup class="justify-content-end">
                                    <Button size="small" label="Save" icon="pi pi-save" class=""></Button>
                                </InputGroup>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel :value="3">
                        <AccordionHeader>                            <div class="w-full">
                                <h5 class="font-semibold vc-text-14">Scripts</h5>
                                <p class="text-color-secondary vc-text-13">Add scripts of Google Analytics and other tracking scripts.</p>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid">
                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 vc-text-12 mb-1">After head tag start (&lt;head&gt;)</h5>
                                <InputGroup>
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 vc-text-12 mb-1">After head tag close (&lt;/head&gt;)</h5>
                                <InputGroup>
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 vc-text-12 mb-1">After body tag start (&lt;body&gt;)</h5>
                                <InputGroup>
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 vc-text-12 mb-1">After body tag close (&lt;/body&gt;)</h5>
                                <InputGroup>
                                    <Textarea v-model="value" :autoResize="true" class="w-full"/>
                                    <Button icon="pi pi-copy" class="has-max-height"/>
                                </InputGroup>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel :value="4">
                        <AccordionHeader>                            <div class="w-full">
                                <h5 class="font-semibold vc-text-14">Meta Tags</h5>
                                <p class="text-color-secondary vc-text-13">Global meta tags.</p>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid">
                            <div class="col-12">
                                <h5 class="p-1 vc-text-12 mb-1">Meta Tag</h5>
                                <InputGroup>
                                    <Select input-class=""></Select>
                                    <InputText></InputText>
                                    <Button label="Content" disabled=""></Button>
                                    <InputText></InputText>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-4">
                                <InputGroup>
                                    <Button icon="pi pi-plus" label="Add Meta Tag" ></Button>
                                    <Button label="Save"></Button>
                                    <Button icon="pi pi-copy"></Button>
                                </InputGroup>
                            </div>
                            <div class="col-12 md:col-4">
                                <InputGroup>
                                    <Select v-model="metaOption" :options="metaOptions" option-label="label" option-value="value"></Select>
                                    <Button label="Generate"></Button>
                                </InputGroup>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel :value="5">
                        <AccordionHeader>                            <div class="w-full">
                                <h5 class="font-semibold vc-text-14">Securities</h5>
                                <p class="text-color-secondary vc-text-13">Enable and choose multiple methods of authentication</p>
                            </div>
                        </AccordionHeader>
                        <AccordionContent>

                        
                        <div class="grid">
                            <div class="col-12">
                                <h4 class="font-semibold vc-text-14">Multi-Factor Authentication</h4>
                                <p class="text-color-secondary vc-text-13 font-semibold">Require a email OTP, sms OTP or authenticator app verification when you login with password.</p>
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
                                    <h5 class="mb-3 font-semibold vc-text-14">MFA Methods</h5>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="vc-dense" v-model="checked" :binary="true" />
                                        <label for="binary">Email OTP Verification</label>
                                    </div>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="vc-dense" v-model="checked" :binary="true" />
                                        <label for="binary">SMS OTP Verification</label>
                                    </div>
                                    <div class="field-checkbox">
                                        <Checkbox inputId="binary" class="vc-dense" v-model="checked" :binary="true" />
                                        <label for="binary">Authenticator App (only user can enable this)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        </AccordionContent>
                    </AccordionPanel>
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
