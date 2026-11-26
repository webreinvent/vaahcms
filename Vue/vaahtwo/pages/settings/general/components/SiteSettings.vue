<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useGeneralStore();
</script>

<template>
    <div v-if="store.list && store.assets && root.assets" class="grid justify-content-evenly">
        <div class="col-12 md:col-6 pr-4">
            <Fluid class="grid">
                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-site-title">{{ store.assets.language_strings.site_title }}</div>

                    <InputGroup>
                        <InputText aria-labelledby="gs-site-title" size="small" v-model="store.list.site_title" data-testid="general-site_title" class="" id="site-title" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-site_title_copy" @click="store.getCopy('site_title')" class="" />
                    </InputGroup>
                </div>

                <div class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-default-site-language">{{ store.assets.language_strings.default_site_language }}</div>

                    <Select aria-labelledby="gs-default-site-language" size="small" v-model="store.list.language" :options="store.languages" optionLabel="name" data-testid="general-site_language" optionValue="locale_code_iso_639" :placeholder="store.assets.language_strings.localization_placeholder_select_a_language" inputClass="" class="vc-dense" />

                </div>
                <div class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-redirect-after-frontend-login">{{ store.assets.language_strings.redirect_after_frontend_login }}</div>

                    <InputGroup>
                        <InputText aria-labelledby="gs-redirect-after-frontend-login" size="small" v-model="store.list.redirect_after_frontend_login" data-testid="general-login_redirection" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-login_redirection_copy" @click="store.getCopy('redirect_after_frontend_login')" class="" />
                    </InputGroup>
                </div>


                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-meta-description">{{ store.assets.language_strings.meta_description }}</div>

                    <InputGroup>
                        <Textarea aria-labelledby="gs-meta-description" v-model="store.list.site_description"
                                  :autoResize="true"
                                  class="w-full"
                        />

                        <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                                data-testid="general-site_description_copy"
                                @click="store.getCopy('site_description')"
                        />
                    </InputGroup>
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-search-engine-visibility">{{ store.assets.language_strings.search_engine_visibility }}</div>

                    <InputGroup>
                        <SelectButton size="small" v-model="store.list.search_engine_visibility" :options="store.visibitlity_options" optionLabel="name" optionValue="value" data-testid="general-visibility" :aria-label="store.assets.language_strings.search_engine_visibility" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-visibility_copy" @click="store.getCopy('vh_search_engine_visibility')" class="" />
                    </InputGroup>
                </div>

                <Fluid class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-assign-roles-on-registration">{{ store.assets.language_strings.assign_roles_on_registration }}</div>

                    <AutoComplete aria-labelledby="gs-assign-roles-on-registration" size="small" :multiple="true" v-model="store.list.registration_roles" :suggestions="store.filtered_registration_roles" @complete="store.searchRegistrationRoles($event)" data-testid="general-registration_roles" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" class="" />
                </Fluid>

                <Fluid class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-allowed-file-types-for-upload">{{ store.assets.language_strings.allowed_file_types_for_upload }}</div>

                    <AutoComplete aria-labelledby="gs-allowed-file-types-for-upload" size="small" :multiple="true" v-model="store.list.upload_allowed_files" :suggestions="store.filtered_allowed_files" @complete="store.searchAllowedFiles($event)" class="" data-testid="general-allowed_files" :placeholder="root.assets.language_strings.crud_actions.placeholder_search" />
                </Fluid>
                <Fluid class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-allowed-file-size-for-upload">{{ store.assets.language_strings.allowed_file_size_for_upload }}</div>
                    <InputGroup class="col-6 p-0">
                        <InputNumber aria-labelledby="gs-allowed-file-size-for-upload" size="small" v-model="store.list.upload_allowed_file_size" class=" h-2rem" showButtons mode="decimal" data-testid="general-allowed_file_size" :min="1" />

                    </InputGroup>
                </Fluid>

                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-is-sidebar-collapsed">{{ store.assets.language_strings.is_sidebar_collapsed }}</div>
                    <InputGroup>
                        <SelectButton size="small" v-model="store.list.is_sidebar_collapsed" optionLabel="name" optionValue="value" :options="store.trueFalseOptions" data-testid="general-is_sidebar_collapsed" class="" :aria-label="store.assets.language_strings.is_sidebar_collapsed" />
                        <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-is_sidebar_collapsed_copy" @click="store.getCopy('is_sidebar_collapsed')" />
                    </InputGroup>
                </Fluid>

                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-is-logo-compressed-with-sidebar">{{ store.assets.language_strings.is_logo_compressed_with_sidebar }}</div>
                    <InputGroup>
                        <SelectButton size="small" v-model="store.list.is_logo_compressed" optionLabel="name" optionValue="value" :options="store.trueFalseOptions" data-testid="general-is_logo_compressed" class="" :aria-label="store.assets.language_strings.is_logo_compressed_with_sidebar" />
                        <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-is_logo_compressed_copy" @click="store.getCopy('is_logo_compressed')" />
                    </InputGroup>
                </Fluid>
            </Fluid>
        </div>

        <div class="col-12 md:col-6 pl-4">
            <div class="grid">
                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-copyright-text">{{ store.assets.language_strings.copyright_text }}</div>
                    <InputGroup>

                        <SelectButton size="small" v-model="store.list.copyright_text" optionLabel="name" optionValue="value" :options="store.copyright_text_options" class="" data-testid="general-copyright_text" :aria-label="store.assets.language_strings.copyright_text" />

                        <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-copyright_custom_filed_copy" @click="store.getCopy('copyright_text')" />
                    </InputGroup>

                    <InputText aria-labelledby="gs-copyright-text" size="small" class="w-full mt-2" v-if="store.list.copyright_text === 'custom'" data-testid="general-copyright_custom_filed" v-model="store.list.copyright_text_custom" :placeholder="store.assets.language_strings.enter_custom_text" />
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-copyright-link">{{ store.assets.language_strings.copyright_link }}</div>

                    <InputGroup>

                        <SelectButton size="small" v-model="store.list.copyright_link" optionLabel="name" optionValue="value" :options="store.copyright_link_options" class="" data-testid="general-copyright_link" :aria-label="store.assets.language_strings.copyright_link" />

                        <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-copyright_custom_link_filed_copy" @click="store.getCopy('copyright_link')" />
                    </InputGroup>

                    <InputText aria-labelledby="gs-copyright-link" size="small" class="w-full mt-2" data-testid="general-copyright_custom_link_field" v-if="store.list.copyright_link === 'custom'" v-model="store.list.copyright_link_custom" :placeholder="store.assets.language_strings.enter_custom_link" />
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-copyright-year">{{ store.assets.language_strings.copyright_year }}</div>

                    <InputGroup>


                        <SelectButton size="small" v-model="store.list.copyright_year" optionLabel="name" optionValue="value" :options="store.copyright_year_options" class="" data-testid="general-copyright_year_select" :aria-label="store.assets.language_strings.copyright_year" />

                        <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-copyright_custom_year_filed_copy" @click="store.getCopy('copyright_year')" />
                    </InputGroup>

                    <InputNumber aria-labelledby="gs-copyright-year" size="small" v-model="store.list.copyright_year_custom" name="config-db_port" :placeholder="store.assets.language_strings.copyright_year" class="w-full mt-2" inputId="gs-copyright-year-custom" :useGrouping="false" :pt="{ input: { 'data-testid': `general-copyright_year` } }"/>

                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-max-number-of-forgot-password-attempts">
                        {{ store.assets.language_strings.max_number_of_forgot_password_attempts }}
                    </div>

                    <InputGroup>
                        <InputNumber aria-labelledby="gs-max-number-of-forgot-password-attempts" size="small" inputId="gs-forgotpassword-attempts" v-model="store.list.maximum_number_of_forgot_password_attempts_per_session" data-testid="general-forgotpassword_attempts" :useGrouping="false" class="" />


                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-forgotpassword_attempts_copy" @click="store.getCopy('maximum_number_of_forgot_password_attempts_per_session')" class="" />
                    </InputGroup>
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-maximum-number-of-login-attempts">{{ store.assets.language_strings.maximum_number_of_login_attempts }}</div>
                    <InputGroup>
                        <InputNumber aria-labelledby="gs-maximum-number-of-login-attempts" size="small" inputId="gs-login-attempts" data-testid="general-login_attempts" v-model="store.list.maximum_number_of_login_attempts_per_session" :useGrouping="false" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-login_attempts_copy" @click="store.getCopy('maximum_number_of_login_attempts_per_session')" class="" />
                    </InputGroup>
                </div>
                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-password-protection">{{ store.assets.language_strings.password_protection }}</div>
                    <InputGroup>
                    <SelectButton size="small" v-model="store.list.password_protection" optionLabel="name" optionValue="value" :options="store.password_protection_options" class="" data-testid="general-password_protection" :aria-label="store.assets.language_strings.password_protection" />
                    <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-password_protection_copy" @click="store.getCopy('password_protection')" />
                   </InputGroup>
                </Fluid>

                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-laravel-queues">{{ store.assets.language_strings.laravel_queues }}</div>
                    <InputGroup>
                    <SelectButton size="small" v-model="store.list.laravel_queues" optionLabel="name" optionValue="value" :options="store.laravel_queues_options" data-testid="general-laravel_queues" class="" :aria-label="store.assets.language_strings.laravel_queues" />
                    <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-laravel_queues_copy" @click="store.getCopy('laravel_queues')" />
                  </InputGroup>
                </Fluid>

                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-maintenance-mode">{{ store.assets.language_strings.maintenance_mode }}</div>
                    <InputGroup>
                    <SelectButton size="small" v-model="store.list.maintenance_mode" optionLabel="name" optionValue="value" :options="store.maintenanceModeOptions" data-testid="general-maintenance_mode" class="" :aria-label="store.assets.language_strings.maintenance_mode" />
                    <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-maintenance_mode_copy" @click="store.getCopy('maintenance_mode')" />
                  </InputGroup>
                </Fluid>

                <Fluid class="col-6">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-signup-page">{{ store.assets.language_strings.signup_page }}</div>
                    <InputGroup>
                    <SelectButton size="small" v-model="store.list.signup_page_visibility" optionLabel="name" optionValue="value" :options="store.sign_up_options" data-testid="general-signup" class="" :aria-label="store.assets.language_strings.signup_page" />
                    <Button size="small" class="" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-signup_page_visibility_copy" @click="store.getCopy('signup_page_visibility')" />
                    </InputGroup>
                </Fluid>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-redirect-after-backend-logout">{{ store.assets.language_strings.redirect_after_backend_logout }}</div>

                    <InputGroup>
                        <SelectButton size="small" v-model="store.list.redirect_after_backend_logout" optionLabel="name" optionValue="value" :options="store.redirect_after_logout_options" data-testid="general-redirect_logout" :aria-label="store.assets.language_strings.redirect_after_backend_logout" class="" />

                        <InputText aria-labelledby="gs-redirect-after-backend-logout" size="small" :placeholder="store.assets.language_strings.enter_redirection_link" v-model="store.list.redirect_after_backend_logout_url" data-testid="general-redirect_logout_custom" :disabled="store.list.redirect_after_backend_logout !== 'custom'" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-backend_logout_copy" @click="store.getCopy('redirect_after_backend_logout')" class="" />

                    </InputGroup>
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-redirect-after-backend-login">{{ store.assets.language_strings.redirect_after_backend_login }}</div>

                    <InputGroup>
                        <InputText aria-labelledby="gs-redirect-after-backend-login" size="small" v-model="store.list.redirect_after_backend_login" data-testid="general-backend_login_redirection" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-backend_login_redirection_copy" @click="store.getCopy('redirect_after_backend_login')" class="" />
                    </InputGroup>
                </div>

                <div class="col-12">
                    <div class="p-1 vaah-type-caption mb-1" id="gs-backend-home-page-link">{{ store.assets.language_strings.backend_home_page_link }}</div>

                    <InputGroup>
                        <SelectButton size="small" v-model="store.list.backend_homepage_link" optionLabel="name" optionValue="value" :options="store.redirect_after_logout_options" data-testid="general-backend_homepage_link" :aria-label="store.assets.language_strings.backend_home_page_link" class="" />

                        <InputText aria-labelledby="gs-backend-home-page-link" size="small" :placeholder="store.assets.language_strings.enter_redirection_link" v-model="store.list.backend_homepage_link_url" data-testid="general-backend_homepage_link_custom" :disabled="store.list.backend_homepage_link !== 'custom'" class="" />

                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-backend_homepage_link_copy" @click="store.getCopy('backend_homepage_link')" class="" />

                    </InputGroup>
                </div>
            </div>
        </div>
        <div class="col-12">
            <Divider class="m-0"/>
        </div>
        <div class="col-12">
            <Button size="small" :label="store.assets.language_strings.save_settings_button" icon="pi pi-save" data-testid="general-save_site" @click="store.storeSiteSettings" class="mr-2" />

            <Button size="small" :label="store.assets.language_strings.clear_cache_button" icon="pi pi-trash" data-testid="general-clear_cache" @click="store.clearCache" class="p-button-danger" />
        </div>
    </div>
</template>
