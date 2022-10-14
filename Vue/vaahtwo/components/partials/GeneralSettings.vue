<template>
  <div>
    <!--<Accordion :activeIndex="0">
      <AccordionTab >
        <template #header>
          <div class="flex justify-content-between align-items-center w-full">
            <span>General Settings</span>
            <div>
              <Button label="Expand all" class="p-button-sm"></Button>
            </div>
          </div>
        </template>
        <Accordion :multiple="true" :activeIndex="[0]">
          <AccordionTab>
            <template #header>
              <div class="w-full">
                <div class="flex justify-content-between align-items-center">
                  <div>
                    <h5>Site Settings</h5>
                    <p class="text-color-secondary">After a successful password update, you will be redirected to the login page where you can log in with your new password.</p>
                  </div>
                  <Button label="Expand" class="p-button-sm"></Button>
                </div>

              </div>
            </template>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </AccordionTab>
          <AccordionTab>
            <template #header>
              <div class="w-full">
                <h5>Date & Time</h5>
                <p class="text-color-secondary">Global date and time settings.</p>
              </div>
            </template>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.</p>
          </AccordionTab>
          <AccordionTab>
            <template #header>
              <div class="w-full">
                <h5>Social Media & Links</h5>
                <p class="text-color-secondary">Static links management.</p>
              </div>
            </template>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.</p>
          </AccordionTab>
          <AccordionTab>
            <template #header>
              <div class="w-full">
                <h5>Scripts</h5>
                <p class="text-color-secondary">Add scripts of Google Analytics and other tracking scripts.</p>
              </div>
            </template>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </AccordionTab>
          <AccordionTab>
            <template #header>
              <div class="w-full">
                <h5>Meta Tags</h5>
                <p class="text-color-secondary">Global meta tags.</p>
              </div>
            </template>
            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </AccordionTab>
        </Accordion>
      </AccordionTab>
    </Accordion>-->
    <Card>
      <template #header>
        <div class="flex justify-content-between align-items-center w-full px-4 pt-3">
          <h2 class="font-semibold text-lg">General Settings</h2>
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
                    <h5 class="text-left p-1">Site Title</h5>
                    <div class="p-inputgroup">
                      <InputText class="" id="site-title"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-6">
                    <h5 class="text-left p-1">Default Site Language</h5>
                    <Dropdown v-model="selectedLanguage" :options="languages" placeholder="Select a Language"/>
                  </div>
                  <div class="col-6">
                    <h5 class="text-left p-1">Redirect after Frontend Login</h5>
                    <div class="p-inputgroup">
                      <InputText/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-8">
                    <h5 class="text-left p-1">Meta Description</h5>
                    <div class="p-inputgroup">
                      <Textarea v-model="value" :autoResize="true" class="w-full"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-4">
                    <h5 class="text-left p-1">Meta Description</h5>
                    <div class="p-inputgroup">
                      <SelectButton v-model="visibility" :options="visibitlityOptions" aria-labelledby="single"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-12 p-fluid">
                    <h5 class="text-left p-1">Assign Role(s) on Registration</h5>
                    <Chips v-model="registrationRoles" id="registration-roles" placeholder="Search"/>
                  </div>
                  <div class="col-12 p-fluid">
                    <h5 class="text-left p-1">Allowed file types for upload</h5>
                    <Chips v-model="allowedFiles" id="allowed-files" inputClass="w-full" class="w-full"></Chips>
                  </div>
                  <div class="col-12">
                    <h5 class="text-left p-1">Redirect after Backend Logout</h5>
                    <div class="p-inputgroup">
                      <SelectButton v-model="redirectAfterLogout" :options="redirectAfterLogoutOptions"
                                    aria-labelledby="single"/>
                      <InputText placeholder="Enter Redirection Link"
                                 :disabled="redirectAfterLogout !== 'Custom'"></InputText>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 md:col-6 pl-4">
                <div class="grid">
                  <div class="col-12">
                    <h5 class="text-left p-1">Copyright Text</h5>
                    <div class="p-inputgroup">
                      <SelectButton v-model="copyrightText" :options="copyrightTextOptions" aria-labelledby="single"/>
                      <InputText placeholder="Enter Copyright Text" :disabled="copyrightText !== 'Custom'"></InputText>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-12">
                    <h5 class="text-left p-1">Copyright Link</h5>
                    <div class="p-inputgroup">
                      <SelectButton v-model="copyrightLink" :options="copyrightLinkOptions" aria-labelledby="single"/>
                      <InputText placeholder="Enter Copyright Link" :disabled="copyrightLink !== 'Custom'"></InputText>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-12">
                    <h5 class="text-left p-1">Copyright Year</h5>
                    <div class="p-inputgroup">
                      <SelectButton v-model="copyrightYear" :options="copyrightYearOptions" aria-labelledby="single"/>
                      <Calendar inputId="yearpicker" v-model="date10" view="year" dateFormat="yy"
                                placeholder="Choose Copyright Year" :disabled="copyrightYear !== 'Custom'"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-6">
                    <h5 class="text-left p-1">Max number of forgot password attempts</h5>
                    <div class="p-inputgroup">
                      <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-6">
                    <h5 class="text-left p-1">Maximum number of login attempts</h5>
                    <div class="p-inputgroup">
                      <InputNumber inputId="withoutgrouping" mode="decimal" :useGrouping="false"/>
                      <Button icon="pi pi-copy" class=""/>
                    </div>
                  </div>
                  <div class="col-4 p-fluid">
                    <h5 class="text-left p-1">Password Protection</h5>
                    <SelectButton v-model="passwordProtection" :options="passwordProtectionOptions"
                                  aria-labelledby="single"/>
                  </div>
                  <div class="col-4 p-fluid">
                    <h5 class="text-left p-1">Laravel Queues</h5>
                    <SelectButton v-model="laravelQueues" :options="laravelQueuesOptions" aria-labelledby="single"/>
                  </div>
                  <div class="col-4 p-fluid">
                    <h5 class="text-left p-1">Maintenance Mode</h5>
                    <SelectButton v-model="maintenanceMode" :options="maintenanceModeOptions" aria-labelledby="single"/>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5">
                <Button label="Save Settings" icon="pi pi-save" class="mr-2"></Button>
                <Button label="Clear Cache" icon="pi pi-trash" class="p-button-danger"></Button>
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
                <h5 class="text-left p-1">Date Format</h5>
                <div class="p-inputgroup">
                  <Dropdown v-model="dateFormat" :options="dateFormatOptions"></Dropdown>
                  <InputText placeholder="Enter Custom date format" v-if="dateFormat === 'Custom'"></InputText>
                  <Button icon="pi pi-copy" class=""/>
                </div>
              </div>
              <div class="col-4">
                <h5 class="text-left p-1">Time Format</h5>
                <div class="p-inputgroup">
                  <Dropdown v-model="timeFormat" :options="timeFormatOptions"></Dropdown>
                  <InputText placeholder="Enter Custom time format" v-if="timeFormat === 'Custom'"></InputText>
                  <Button icon="pi pi-copy" class=""/>
                </div>
              </div>
              <div class="col-4">
                <h5 class="text-left p-1">Date Time Format</h5>
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
                <Button label="Save Settings" icon="pi pi-save" class="mr-2"></Button>
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
                <h5 class="text-left p-1">{{ item.title }}</h5>
                <div class="p-inputgroup p-fluid">
                  <span class="p-input-icon-left">
                    <i :class="'pi z-5 ' + item.icon"/>
                    <InputText type="text" :placeholder="'Enter ' + item.title + ' Link'" class="w-full"/>
                  </span>
                  <Button icon="pi pi-copy" class=""/>
                  <Button icon="pi pi-trash" class="p-button-danger"/>
                </div>
              </div>
            </div>
            <div class="grid mt-5">
              <div class="col-12 md:col-4">
                <div class="p-inputgroup">
                  <InputText v-model="addLink" v-if="showLinkInput"></InputText>
                  <Button label="Add Link" icon="pi pi-plus" @click="addLinkHandler"></Button>
                </div>
              </div>
              <div class="col-12 md:col-8">
                <div class="p-inputgroup justify-content-end">
                  <Button label="Save" icon="pi pi-save"></Button>
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
                <h5 class="text-left p-1">After head tag start (&lt;head&gt;)</h5>
                <div class="p-inputgroup">
                  <Textarea v-model="value" :autoResize="true" class="w-full"/>
                  <Button icon="pi pi-copy" class=""/>
                </div>
              </div>
              <div class="col-12 md:col-6 pl-3">
                <h5 class="text-left p-1">After head tag close (&lt;/head&gt;)</h5>
                <div class="p-inputgroup">
                  <Textarea v-model="value" :autoResize="true" class="w-full"/>
                  <Button icon="pi pi-copy" class=""/>
                </div>
              </div>
              <div class="col-12 md:col-6 pr-3">
                <h5 class="text-left p-1">After body tag start (&lt;body&gt;)</h5>
                <div class="p-inputgroup">
                  <Textarea v-model="value" :autoResize="true" class="w-full"/>
                  <Button icon="pi pi-copy" class=""/>
                </div>
              </div>
              <div class="col-12 md:col-6 pl-3">
                <h5 class="text-left p-1">After body tag close (&lt;/body&gt;)</h5>
                <div class="p-inputgroup">
                  <Textarea v-model="value" :autoResize="true" class="w-full"/>
                  <Button icon="pi pi-copy" class=""/>
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
              <div class="col-12 md:col-6">
                <h5 class="text-left p-1">Meta Tag</h5>
                <div class="p-inputgroup">

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
      copyrightText: 'Use App Name',
      copyrightTextOptions: ['Use App Name', 'Custom'],
      copyrightLink: 'Use App Url',
      copyrightLinkOptions: ['Use App Url', 'Custom'],
      copyrightYear: 'Use Current Year',
      copyrightYearOptions: ['Use Current Year', 'Custom'],
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
      showLinkInput: false,
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
        return this.showLinkInput = false;
      }
    }
  }
}
</script>

<style scoped>

</style>