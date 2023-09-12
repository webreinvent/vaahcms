<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";

const store = useGeneralStore();
</script>

<template>
    <div v-if="store.list" class="grid justify-content-evenly">
        <div class="col-12 md:col-6 pr-4">
            <div class="grid p-fluid">
                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Site Title</h5>

                    <div class="p-inputgroup">
                        <InputText v-model="store.list.site_title"
                                   data-testid="general-site_title"
                                   class="p-inputtext-sm"
                                   id="site-title"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-site_title_copy"
                                @click="store.getCopy('site_title')"
                                class="p-button-sm"
                        />
                    </div>
                </div>

                <div class="col-6">
                    <h5 class="p-1 text-xs mb-1">Default Site Language sdfds</h5>

                    <Dropdown v-model="store.list.language"
                              :options="store.languages"
                              optionLabel="name"
                              data-testid="general-site_language"
                              optionValue="locale_code_iso_639"
                              placeholder="Select a Language"
                              inputClass="p-inputtext-sm"
                              class="is-small"
                    />
                </div>

                <div class="col-6">
                    <h5 class="p-1 text-xs mb-1">Redirect after Frontend Login</h5>

                    <div class="p-inputgroup">
                        <InputText v-model="store.list.redirect_after_frontend_login"
                                   data-testid="general-login_redirection"
                                   class="p-inputtext-sm"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-login_redirection_copy"
                                @click="store.getCopy('redirect_after_frontend_login')"
                                class="p-button-sm"
                        />
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Meta Description</h5>

                    <div class="p-inputgroup">
                        <Textarea v-model="store.list.site_description"
                                  :autoResize="true"
                                  class="w-full"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-site_description_copy"
                                @click="store.getCopy('site_description')"
                        />
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
                                      class="p-button-sm"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-visibility_copy"
                                @click="store.getCopy('vh_search_engine_visibility')"
                                class="p-button-sm"
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
                                  class="p-inputtext-sm"
                    />
                </div>

                <div class="col-12 p-fluid">
                    <h5 class="p-1 text-xs mb-1">Allowed file types for upload</h5>

                    <AutoComplete :multiple="true"
                                  v-model="store.list.upload_allowed_files"
                                  :suggestions="store.filtered_allowed_files"
                                  @complete="store.searchAllowedFiles($event)"
                                  class="p-inputtext-sm"
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

                        <SelectButton v-model="store.list.copyright_text"
                                      optionLabel="name"
                                      optionValue="value"
                                      :options="store.copyright_text_options"
                                      class="p-button-sm"
                                      data-testid="general-password_protection"
                                      aria-labelledby="single"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-copy"
                                data-testid="general-copyright_custom_filed_copy"
                                @click="store.getCopy('copyright_text')"
                        />
                    </div>

                    <InputText class="w-full p-inputtext-sm mt-2" v-if="store.list.copyright_text === 'custom'"
                               data-testid="general-copyright_custom_filed"
                               v-model="store.list.copyright_text_custom"
                               placeholder="Enter Custom Text"

                    />
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Copyright Link</h5>

                    <div class="p-inputgroup">

                        <SelectButton v-model="store.list.copyright_link"
                                      optionLabel="name"
                                      optionValue="value"
                                      :options="store.copyright_link_options"
                                      class="p-button-sm"
                                      data-testid="general-password_protection"
                                      aria-labelledby="single"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-copy"
                                data-testid="general-copyright_custom_link_filed_copy"
                                @click="store.getCopy('copyright_link')"
                        />
                    </div>

                    <InputText class="w-full p-inputtext-sm mt-2"
                               data-testid="general-copyright_custom_link_field"
                               v-if="store.list.copyright_link === 'custom'"
                               v-model="store.list.copyright_link_custom"
                               placeholder="Enter Custom Link"
                    />
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Copyright Year</h5>

                    <div class="p-inputgroup">


                        <SelectButton v-model="store.list.copyright_year"
                                      optionLabel="name"
                                      optionValue="value"
                                      :options="store.copyright_year_options"
                                      class="p-button-sm"
                                      data-testid="general-password_protection"
                                      aria-labelledby="single"
                        />

                        <Button class="p-button-sm"
                                icon="pi pi-copy"
                                data-testid="general-copyright_custom_year_filed_copy"
                                @click="store.getCopy('copyright_year')"
                        />
                    </div>

                    <Calendar inputId="yearpicker"
                              v-model="store.list.copyright_year_custom" view="year"
                              dateFormat="yy"
                              data-testid="general-copyright_yearcalender"
                              v-if="store.list.copyright_year === 'custom'"
                              class="w-full p-inputtext-sm mt-2"
                              placeholder="Choose Copyright Year"
                    />
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">
                        Max number of forgot password attempts
                    </h5>

                    <div class="p-inputgroup">
                        <InputNumber inputId="withoutgrouping"
                                     v-model="store.list.maximum_number_of_forgot_password_attempts_per_session"
                                     data-testid="general-forgotpassword_attempts"
                                     :useGrouping="false"
                                     class="p-inputtext-sm"
                        />


                        <Button icon="pi pi-copy"
                                data-testid="general-forgotpassword_attempts_copy"
                                @click="store.getCopy('maximum_number_of_forgot_password_attempts_per_session')"
                                class="p-button-sm"
                        />
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Maximum number of login attempts</h5>
                    <div class="p-inputgroup">
                        <InputNumber inputId="withoutgrouping"
                                     data-testid="general-login_attempts"
                                     v-model="store.list.maximum_number_of_login_attempts_per_session"
                                     :useGrouping="false"
                                     class="p-inputtext-sm"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-login_attempts_copy"
                                @click="store.getCopy('maximum_number_of_login_attempts_per_session')"
                                class="p-button-sm"
                        />
                    </div>
                </div>
                <div class="col-6 p-fluid">
                    <h5 class="p-1 text-xs mb-1">Password Protection</h5>
                    <div class="p-inputgroup">
                    <SelectButton v-model="store.list.password_protection"
                                  optionLabel="name"
                                  optionValue="value"
                                  :options="store.password_protection_options"
                                  class="p-button-sm"
                                  data-testid="general-password_protection"
                                  aria-labelledby="single"
                    />
                    <Button class="p-button-sm"
                            icon="pi pi-copy"
                            data-testid="general-copyright_custom_year_filed_copy"
                            @click="store.getCopy('password_protection')"
                    />
                   </div>
                </div>

                <div class="col-6 p-fluid">
                    <h5 class="p-1 text-xs mb-1">Laravel Queues</h5>
                    <div class="p-inputgroup">
                    <SelectButton v-model="store.list.laravel_queues"
                                  optionLabel="name"
                                  optionValue="value"
                                  :options="store.laravel_queues_options"
                                  data-testid="general-laravel_queues"
                                  class="p-button-sm"
                                  aria-labelledby="single"
                    />
                    <Button class="p-button-sm"
                            icon="pi pi-copy"
                            data-testid="general-copyright_custom_year_filed_copy"
                            @click="store.getCopy('laravel_queues')"
                    />
                  </div>
                </div>

                <div class="col-6 p-fluid">
                    <h5 class="p-1 text-xs mb-1">Maintenance Mode</h5>
                    <div class="p-inputgroup">
                    <SelectButton v-model="store.list.maintenance_mode"
                                  optionLabel="name"
                                  optionValue="value"
                                  :options="store.maintenanceModeOptions"
                                  data-testid="general-maintenance_mode"
                                  class="p-button-sm"
                                  aria-labelledby="single"
                    />
                    <Button class="p-button-sm"
                            icon="pi pi-copy"
                            data-testid="general-copyright_custom_year_filed_copy"
                            @click="store.getCopy('maintenance_mode')"
                    />
                  </div>
                </div>

                <div class="col-6 p-fluid">
                    <h5 class="p-1 text-xs mb-1">Signup Page</h5>
                    <div class="p-inputgroup">
                    <SelectButton v-model="store.list.signup_page_visibility"
                                  optionLabel="name"
                                  optionValue="value"
                                  :options="store.sign_up_options"
                                  data-testid="general-signup"
                                  class="p-button-sm"
                                  aria-labelledby="single"
                    />
                    <Button class="p-button-sm"
                            icon="pi pi-copy"
                            data-testid="general-copyright_custom_year_filed_copy"
                            @click="store.getCopy('signup_page_visibility')"
                    />
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="p-1 text-xs mb-1">Redirect after Backend Logout</h5>

                    <div class="p-inputgroup">
                        <SelectButton v-model="store.list.redirect_after_backend_logout"
                                      optionLabel="name"
                                      optionValue="value"
                                      :options="store.redirect_after_logout_options"
                                      data-testid="general-redirect_logout"
                                      aria-labelledby="single"
                                      class="p-button-sm"
                        />

                        <InputText placeholder="Enter Redirection Link"
                                   v-model="store.list.redirect_after_backend_logout_url"
                                   data-testid="general-redirect_logout_custom"
                                   :disabled="store.list.redirect_after_backend_logout !== 'custom'"
                                   class="p-inputtext-sm"
                        />

                        <Button icon="pi pi-copy"
                                data-testid="general-backend_logout_copy"
                                @click="store.getCopy('redirect_after_backend_logout')"
                                class="p-button-sm"
                        />

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <Divider class="m-0"/>
        </div>
        <div class="col-12">
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
</template>
