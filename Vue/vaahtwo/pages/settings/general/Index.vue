<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah'

import {useGeneralStore} from "../../../stores/settings/store-general_setting";

const store = useGeneralStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});
</script>
<template>
    <div>
        <Card>
            <template #header>
                <div class="flex justify-content-between align-items-center w-full">
                    <h5 class="font-semibold text-lg">General Settings</h5>
                    <div>
                        <Button label="Expand all" class="p-button-sm mr-2" @click="store.expandAll"></Button>
                        <Button label="Collapse all" class="p-button-sm" @click="store.collapseAll"></Button>
                    </div>
                </div>
            </template>

            <template #content>
                <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer">
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

                        <div v-if="store.list" class="grid justify-content-evenly">
                            <div class="col-12 md:col-6 pr-4">
                                <div class="grid p-fluid">
                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Site Title</h5>
                                        <div class="p-inputgroup">
                                            <InputText v-model="store.list.site_title"
                                                       data-testid="general-site_title"
                                                       class="" id="site-title"
                                            />

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-site_title_copy"
                                                    @click="store.getCopy('site_title')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <h5 class="p-1 text-xs mb-1">Default Site Language</h5>
                                        <Dropdown v-model="store.list.language"
                                                  :options="store.languages"
                                                  optionLabel="name"
                                                  data-testid="general-site_language"
                                                  optionValue="locale_code_iso_639"
                                                  placeholder="Select a Language"
                                        />
                                    </div>

                                    <div class="col-6">
                                        <h5 class="p-1 text-xs mb-1">Redirect after Frontend Login</h5>
                                        <div class="p-inputgroup">
                                            <InputText v-model="store.list.redirect_after_frontend_login"
                                                       data-testid="general-login_redirection"
                                            />
                                            <Button icon="pi pi-copy"
                                                    data-testid="general-login_redirection_copy"
                                                    @click="store.getCopy('redirect_after_frontend_login')"/>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Meta Description</h5>
                                        <div class="p-inputgroup">
                                            <Textarea v-model="store.list.site_description"
                                                      :autoResize="true" class="w-full"/>
                                            <Button icon="pi pi-copy"
                                                    data-testid="general-site_description_copy"
                                                    @click="store.getCopy('site_description')"
                                                    class="has-max-height"/>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Search Engine Visibility</h5>
                                        <div class="p-inputgroup">
                                            <SelectButton v-model="store.list.search_engine_visibility"
                                                          :options="store.visibitlity_options"
                                                          optionLabel="name"
                                                          optionValue="value"
                                                          data-testid="general-visibility"
                                                          aria-labelledby="single"
                                            />

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-visibility_copy"
                                                    @click="store.getCopy('vh_search_engine_visibility')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-12 p-fluid">
                                        <h5 class="p-1 text-xs mb-1">Assign Role(s) on Registration</h5>
                                        <AutoComplete :multiple="true"
                                              v-model="store.list.registration_roles"
                                              :suggestions="store.filtered_registration_roles"
                                              @complete="store.searchRegistrationRoles($event)"
                                              data-testid="general-registration_roles"
                                              placeholder="Search"
                                        />
                                    </div>

                                    <div class="col-12 p-fluid">
                                        <h5 class="p-1 text-xs mb-1">Allowed file types for upload</h5>
                                        <AutoComplete :multiple="true"
                                              v-model="store.list.upload_allowed_files"
                                              :suggestions="store.filtered_allowed_files"
                                              @complete="store.searchAllowedFiles($event)"

                                              data-testid="general-allowed_files"
                                              placeholder="Search"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pl-4">
                                <div class="grid">
                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Copyright Text</h5>
                                        <div class="p-inputgroup">
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-app-name"
                                                             name="copyright_text"
                                                             value="app_name"
                                                             data-testid="general-copyright"
                                                             v-model="store.list.copyright_text"
                                                />

                                                <label for="copyright-app-name">Use App Name</label>
                                            </div>

                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom"
                                                             name="copyright_text"
                                                             value="custom"
                                                             data-testid="general-copyright_custom"
                                                             v-model="store.list.copyright_text"
                                                />

                                                <label for="copyright-custom">Custom</label>
                                            </div>

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-copyright_custom_filed_copy"
                                                    @click="store.getCopy('copyright_text')"
                                            />
                                        </div>

                                        <InputText class="w-full" v-if="store.list.copyright_text === 'custom'"
                                                   data-testid="general-copyright_custom_filed"
                                                   v-model="store.list.copyright_text_custom"
                                                   placeholder="Enter Custom Text"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Copyright Link</h5>
                                        <div class="p-inputgroup">
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-link"
                                                             name="copyright_link"
                                                             value="app_url"
                                                             data-testid="general-copyright_link"
                                                             v-model="store.list.copyright_link"
                                                />

                                                <label for="copyright-link">Use App Url</label>
                                            </div>

                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom_link"
                                                             name="copyright_link"
                                                             value="custom"
                                                             data-testid="general-copyright_custom_link"
                                                             v-model="store.list.copyright_link"
                                                />

                                                <label for="copyright-custom_link">Custom</label>
                                            </div>

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-copyright_custom_link_filed_copy"
                                                    @click="store.getCopy('copyright_link')"
                                            />
                                        </div>

                                        <InputText class="w-full"
                                                   data-testid="general-copyright_custom_link_field"
                                                   v-if="store.list.copyright_link === 'custom'"
                                                   v-model="store.list.copyright_link_custom"
                                                   placeholder="Enter Custom Link"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Copyright Year</h5>
                                        <div class="p-inputgroup">
                                            <div class="field-radiobutton mr-2">
                                                <RadioButton inputId="copyright-year"
                                                             data-testid="general-copyright_year"
                                                             name="copyright_year"
                                                             value="use_current_year"
                                                             v-model="store.list.copyright_year"
                                                />

                                                <label for="copyright-year">Use Current year</label>
                                            </div>

                                            <div class="field-radiobutton">
                                                <RadioButton inputId="copyright-custom_year"
                                                             data-testid="general-copyright_year_custom"
                                                             name="copyright_year"
                                                             value="custom"
                                                             v-model="store.list.copyright_year"
                                                />

                                                <label for="copyright-custom_year">Custom</label>
                                            </div>

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-copyright_custom_year_filed_copy"
                                                    @click="store.getCopy('copyright_year')"
                                            />
                                        </div>

                                        <Calendar inputId="yearpicker"
                                                  v-model="store.list.copyright_year_custom" view="year"
                                                  dateFormat="yy"
                                                  data-testid="general-copyright_yearcalender"
                                                  v-if="store.list.copyright_year === 'custom'"
                                                  input-class="w-full" class="w-full"
                                                  placeholder="Choose Copyright Year"
                                        />
                                    </div>

                                    <div class="col-6">
                                        <h5 class="p-1 text-xs mb-1">
                                            Max number of forgot password attempts
                                        </h5>

                                        <div class="p-inputgroup">
                                            <InputNumber inputId="withoutgrouping"
                                                         v-model="store.list.maximum_number_of_forgot_password_attempts_per_session"
                                                         data-testid="general-forgotpassword_attempts"
                                                         :useGrouping="false"
                                            />

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-forgotpassword_attempts_copy"
                                                    @click="store.getCopy('maximum_number_of_forgot_password_attempts_per_session')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <h5 class="p-1 text-xs mb-1">Maximum number of login attempts</h5>
                                        <div class="p-inputgroup">
                                            <InputNumber inputId="withoutgrouping"
                                                         data-testid="general-login_attempts"
                                                         v-model="store.list.maximum_number_of_login_attempts_per_session"
                                                         :useGrouping="false"
                                            />

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-login_attempts_copy"
                                                    @click="store.getCopy('maximum_number_of_login_attempts_per_session')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-6 p-fluid">
                                        <h5 class="p-1 text-xs mb-1">Password Protection</h5>
                                        <SelectButton v-model="store.list.password_protection"
                                                      optionLabel="name"
                                                      optionValue="value"
                                                      :options="store.password_protection_options"
                                                      class="p-button-sm"
                                                      data-testid="general-password_protection"
                                                      aria-labelledby="single"
                                        />
                                    </div>

                                    <div class="col-6 p-fluid">
                                        <h5 class="p-1 text-xs mb-1">Laravel Queues</h5>
                                        <SelectButton v-model="store.list.laravel_queues"
                                                      optionLabel="name"
                                                      optionValue="value"
                                                      :options="store.laravel_queues_options"
                                                      data-testid="general-laravel_queues"
                                                      class="p-button-sm" aria-labelledby="single"
                                        />
                                    </div>

                                    <div class="col-6 p-fluid">
                                        <h5 class="p-1 text-xs mb-1">Maintenance Mode</h5>

                                        <SelectButton v-model="store.list.maintenance_mode"
                                                      optionLabel="name"
                                                      optionValue="value"
                                                      :options="store.maintenanceModeOptions"
                                                      data-testid="general-maintenance_mode"
                                                      class="p-button-sm" aria-labelledby="single"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <h5 class="p-1 text-xs mb-1">Redirect after Backend Logout</h5>
                                        <div class="p-inputgroup">
                                            <SelectButton v-model="store.list.redirect_after_backend_logout"
                                                          optionLabel="name"
                                                          optionValue="value"
                                                          :options="store.redirect_after_logout_options"
                                                          data-testid="general-redirect_logout"
                                                          aria-labelledby="single" class="p-button-sm"
                                            />

                                            <InputText placeholder="Enter Redirection Link"
                                                       v-model="store.list.redirect_after_backend_logout_url"
                                                       data-testid="general-redirect_logout_custom"
                                                       :disabled="store.list.redirect_after_backend_logout !== 'custom'"
                                            />

                                            <Button icon="pi pi-copy"
                                                    data-testid="general-backend_logout_copy"
                                                    @click="store.getCopy('redirect_after_backend_logout')"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <Button label="Save Settings"
                                        icon="pi pi-save"
                                        data-testid="general-save_site"
                                        @click="store.storeSiteSettings"
                                        class="mr-2 p-button-sm"
                                />

                                <Button label="Clear Cache"
                                        icon="pi pi-trash"
                                        data-testid="general-clear_cache"
                                        @click="store.clearCache"
                                        class="p-button-danger p-button-sm"
                                />
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

                        <div v-if="store.list" class="grid">
                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Date Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.list.date_format"
                                              data-testid="general-date_format"
                                              :options="store.date_format_options"
                                    />

                                    <InputText placeholder="Enter Custom date format"
                                               v-model="store.list.date_format_custom"
                                               data-testid="general-date_format_custom"
                                               v-if="store.list.date_format === 'custom'"
                                               class="p-inputtext-sm"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-date_format_copy"
                                            @click="store.getCopy('date_format')"
                                            class="p-button-sm"
                                    />
                                </div>
                            </div>

                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Time Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.list.time_format"
                                              data-testid="general-time_format"
                                              :options="store.time_format_options"
                                    />

                                    <InputText placeholder="Enter Custom time format"
                                               v-model="store.list.time_format_custom"
                                               data-testid="general-time_format_custom"
                                               v-if="store.list.time_format === 'custom'"
                                               class="p-inputtext-sm"
                                    />
                                    <Button icon="pi pi-copy"
                                            data-testid="general-time_format_copy"
                                            @click="store.getCopy('time_format')"
                                            class="p-button-sm"
                                    />
                                </div>
                            </div>

                            <div class="col-4">
                                <h5 class="p-1 text-xs mb-1">Date Time Format</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.list.datetime_format"
                                              data-testid="general-datetime_format"
                                              :options="store.date_time_format_options"
                                    />

                                    <InputText placeholder="Enter Custom date-time format"
                                               v-model="store.list.datetime_format_custom"
                                               data-testid="general-datetime_format_custom"
                                               v-if="store.list.datetime_format === 'custom'"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-datetime_format_copy"
                                            @click="store.getCopy('datetime_format')"
                                    />
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <Button label="Save Settings"
                                        @click="store.storeSiteSettings()"
                                        data-testid="general-date_format_save"
                                        icon="pi pi-save"
                                        class="mr-2 p-button-sm"
                                />
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
                            <div class="col-12 md:col-4" v-for="(item,index) in store.social_media_links">
                                <h5 class="p-1 text-xs mb-1">{{ vaah().toLabel(item.label) }}</h5>
                                <div class="p-inputgroup p-fluid">
                                    <span class="p-input-icon-left">
                                        <i :class="item.icon?'pi z-5 '+item.icon:'pi z-5 pi-link'"/>
                                        <InputText type="text"
                                                   :data-testid="'general-'+item.label+'field'"
                                                   v-model="item.value"
                                                   :placeholder="'Enter ' + item.label + ' Link'"
                                                   class="w-full p-inputtext-sm"
                                        />
                                    </span>

                                    <Button icon="pi pi-copy"
                                            data-testid="general-link_copy"
                                            :disabled="!item.id"
                                            @click="store.getCopy(item.key)"
                                            class=" p-button-sm"
                                    />

                                    <Button icon="pi pi-trash"
                                            data-testid="general-link_remove"
                                            @click="store.removeVariable(item)"
                                            class="p-button-danger p-button-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid mt-5">
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <InputText v-model="store.add_link"
                                               data-testid="general-add_link_field"
                                               icon= "pi pi-link"
                                               v-if="store.show_link_input"
                                               class="p-inputtext-sm"
                                    />

                                    <Button label="Add Link"
                                            icon="pi pi-plus"
                                            class="p-button-sm"
                                            data-testid="general-add_link_btn"
                                            :disabled="!store.add_link"
                                            @click="store.addLinkHandler"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-8">
                                <div class="p-inputgroup justify-content-end">
                                    <Button label="Save"
                                            icon="pi pi-save"
                                            data-testid="general-link_save"
                                            @click="store.storeLinks()"
                                            class="p-button-sm"
                                    />
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
                                    <Textarea v-model="store.script_tag.script_after_head_start"
                                              :autoResize="true"
                                              data-testid="general-script_head_start"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_head_start_copy"
                                            @click="store.getCopy('script_after_head_start')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After head tag close (&lt;/head&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_before_head_close"
                                              :autoResize="true"
                                              data-testid="general-script_head_close"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_head_close_copy"
                                            @click="store.getCopy('script_before_head_close')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pr-3">
                                <h5 class="p-1 text-xs mb-1">After body tag start (&lt;body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_after_body_start"
                                              :autoResize="true"
                                              data-testid="general-script_body_start"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_body_start_copy"
                                            @click="store.getCopy('script_after_body_start')"
                                            class="has-max-height"/>
                                </div>
                            </div>

                            <div class="col-12 md:col-6 pl-3">
                                <h5 class="p-1 text-xs mb-1">After body tag close (&lt;/body&gt;)</h5>
                                <div class="p-inputgroup">
                                    <Textarea v-model="store.script_tag.script_before_body_close"
                                              :autoResize="true"
                                              data-testid="general-script_body_close"
                                              class="w-full"
                                    />

                                    <Button icon="pi pi-copy"
                                            data-testid="general-script_body_close_copy"
                                            @click="store.getCopy('script_before_body_close')"
                                            class="has-max-height"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid mt-5">
                            <div class="col-12">
                                <div class="p-inputgroup justify-content-end">
                                    <Button label="Save"
                                            icon="pi pi-save"
                                            data-testid="general-script_save"
                                            @click="store.storeScript()"
                                            class="p-button-sm"
                                    />
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
                            <div class="col-12" v-if="store.meta_tag" v-for="(item,index) in store.meta_tag">
                                <h5 class="p-1 text-xs mb-1">Meta Tag</h5>
                                <div class="p-inputgroup">
                                    <Dropdown v-model="item.value.attribute"
                                              :options="store.assets.vh_meta_attributes"
                                              optionLabel="name"
                                              optionValue="slug"
                                              data-testid="general-metatags_attributes"
                                              placeholder="Select any"
                                    />

                                    <InputText v-model="item.value.attribute_value"
                                               data-testid="general-metatags_attributes_value"
                                               class="p-inputtext-sm"
                                    />
                                    <Button label="Content" disabled="" />
                                    <InputText v-model="item.value.content"
                                               data-testid="general-metatags_attributes_content"></InputText>
                                    <Button icon="pi pi-trash"
                                            data-testid="general-remove_tag"
                                            @click="store.removeMetaTags(item)"/>
                                </div>
                            </div>
                            <div class="col-12 md:col-8">
                                <div class="p-inputgroup">
                                    <Button icon="pi pi-plus"
                                            data-testid="general-add_newtag"
                                            @click="store.addMetaTags"
                                            label="Add Meta Tag"></Button>
                                    <Button label="Save"
                                            @click="store.storeTags"
                                            data-testid="general-meta_tag-save" ></Button>
                                    <Button icon="pi pi-copy"
                                            data-testid="general-meta_tag_copy"
                                            @click="store.getCopy('meta_tags')"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.tag_type"
                                              :options="[
                                                  {name:'Google Webmaster',value:'google-webmaster'},
                                                  {name:'Open Graph (Facebook)',value:'open-graph'},
                                              ]"
                                              data-testid="general-gegnerate_tag"
                                              optionLabel="name"
                                              optionValue="value"
                                              placeholder="Select a type"/>
                                    <Button label="Generate" @click="store.generateTags"></Button>
                                </div>
                            </div>
                        </div>
                    </AccordionTab>
                </Accordion>
            </template>
        </Card>
    </div>
</template>
