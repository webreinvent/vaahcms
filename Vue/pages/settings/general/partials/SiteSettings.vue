<script src="./SiteSettingsJs.js"></script>
<template>

    <div class="block is-marginless">

        <b-collapse :open="false" aria-id="site_settings">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="site_settings">

                <div class="label-left">
                    <h4 class="title is-5">Site Settings</h4>
                    <h2 class="subtitle is-6">After a successful password update, you
                        will be redirected to the login page where you can
                        log in with your new password.</h2>
                </div>
                <div class="label-right is-hidden-mobile">
                    <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                    </b-button>
                </div>

            </div>


            <div class="block has-margin-top-10 has-padding-10">

                <div class="columns is-multiline has-background-white-bis columns-settings">
                    <div class="column is-half">
                        <div class="block has-padding-10">

                            <b-field label="Site Title"
                                     expanded
                                     grouped
                                     :label-position="labelPosition">
                                <b-field expanded>
                                    <b-input expanded
                                             v-model="list.site_title"
                                             type="text"></b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                            <b-button icon-left="copy"
                                                      @click="copySetting('site_title')">
                                            </b-button>
                                    </p>
                                    </b-tooltip>
                                </b-field>
                            </b-field>

                            <b-field label="Meta Description"

                                     :label-position="labelPosition">
                                <b-input maxlength="200" expanded
                                         v-model="list.site_description"
                                         type="textarea"></b-input>
                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                <p class="control">
                                    <b-button icon-left="copy"
                                              @click="copySetting('site_description')">
                                    </b-button>
                                </p>
                                </b-tooltip>
                            </b-field>


                            <b-field  label="Default Site Language"
                                      :label-position="labelPosition">

                                <b-select placeholder="Default Site Language"
                                          v-model="list.language">
                                    <option v-for="language in assets.languages"
                                            :value="language.locale_code_iso_639">
                                        {{language.name}}
                                    </option>
                                </b-select>

                            </b-field>

                            <b-field  expanded
                                      label="Search Engine Visibility"
                                      :message="inputs.search_engine_visibility.message"
                                      :type="inputs.search_engine_visibility.type"
                                      :label-position="labelPosition">

                                <b-field>
                                    <b-radio-button native-value="1"
                                                    type="is-success"
                                                    v-model="list.search_engine_visibility">
                                        <span>Visible</span>
                                    </b-radio-button>

                                    <b-radio-button native-value="0"
                                                    type="is-danger"
                                                    v-model="list.search_engine_visibility">
                                        <span>Invisible</span>
                                    </b-radio-button>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                        <b-button icon-left="copy"
                                                  @click="copySetting('vh_search_engine_visibility()',true)">
                                        </b-button>
                                    </p>
                                    </b-tooltip>
                                </b-field>



                            </b-field>

                            <b-field label="Redirect after Frontend Login"
                                     expanded
                                     grouped
                                     :label-position="labelPosition">
                                <b-field expanded>
                                    <b-input expanded
                                             v-model="list.redirect_after_frontend_login"
                                             type="text"
                                             placeholder="Enter url"></b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                        <b-button icon-left="copy"
                                                  @click="copySetting('redirect_after_frontend_login')">
                                        </b-button>
                                    </p>
                                    </b-tooltip>
                                </b-field>
                            </b-field>




                            <b-field label="Maximum number of forgot password attempts per session"
                                     expanded
                                     grouped
                                     :label-position="labelPosition">
                                <b-field expanded>
                                    <b-input expanded
                                             v-model="list.maximum_number_of_forgot_password_attempts_per_session"
                                             type="number"></b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <p class="control">
                                            <b-button icon-left="copy"
                                                      @click="copySetting('maximum_number_of_forgot_password_attempts_per_session')">
                                            </b-button>
                                        </p>
                                    </b-tooltip>
                                </b-field>
                            </b-field>


                            <b-field label="Maximum number of login attempts per session"
                                     expanded
                                     grouped
                                     :label-position="labelPosition">
                                <b-field expanded>
                                    <b-input expanded
                                             v-model="list.maximum_number_of_login_attempts_per_session"
                                             type="number"></b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <p class="control">
                                            <b-button icon-left="copy"
                                                      @click="copySetting('maximum_number_of_login_attempts_per_session')">
                                            </b-button>
                                        </p>
                                    </b-tooltip>
                                </b-field>
                            </b-field>


                        </div>

                    </div>
                    <div class="column is-half">
                        <div class="block has-padding-10">


                            <b-field  expanded
                                      grouped
                                      label="Copyright Text"
                                      :label-position="labelPosition">

                                <b-field expanded>
                                    <b-radio-button v-model="list.copyright_text"
                                                    type="is-success"
                                                    native-value="app_name" >
                                        <span>Use App Name</span>
                                    </b-radio-button>
                                    <b-radio-button
                                        v-model="inputs.copyright_text_custom"
                                        native-value="1">
                                        <span>Custom</span>
                                    </b-radio-button>

                                    <b-input v-if="inputs.copyright_text_custom"
                                             v-model="list.copyright_text"
                                             expanded type="text"
                                             placeholder="Type Copyright Text">
                                    </b-input>

                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                        <b-button icon-left="copy"
                                                  @click="copySetting('copyright_text')">
                                        </b-button>
                                    </p>
                                    </b-tooltip>
                                </b-field>


                            </b-field>

                            <b-field  expanded
                                      grouped
                                      label="Copyright Link"
                                      :label-position="labelPosition">

                                <b-field expanded>
                                    <b-radio-button v-model="list.copyright_link"
                                                    type="is-success"
                                                    native-value="app_url" >
                                        <span>Use App Url</span>
                                    </b-radio-button>
                                    <b-radio-button
                                        v-model="inputs.copyright_link_custom"
                                        native-value="true">
                                        <span>Custom</span>
                                    </b-radio-button>

                                    <b-input v-if="inputs.copyright_link_custom"
                                             v-model="list.copyright_link"
                                             expanded type="text"
                                             placeholder="Type Copyright Link">
                                    </b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                        <b-button icon-left="copy"
                                                  @click="copySetting('copyright_link')">
                                        </b-button>
                                    </p>
                                    </b-tooltip>

                                </b-field>

                            </b-field>

                            <b-field  expanded
                                      grouped
                                      label="Copyright Year"
                                      :label-position="labelPosition">

                                <b-field expanded>
                                    <b-radio-button v-model="list.copyright_year"
                                                    type="is-success"
                                                    native-value="use_current_year" >
                                        <span>Use Current Year</span>
                                    </b-radio-button>
                                    <b-radio-button
                                        v-model="inputs.copyright_year_custom"
                                        native-value="true">
                                        <span>Custom</span>
                                    </b-radio-button>

                                    <b-input v-if="inputs.copyright_year_custom"
                                             v-model="list.copyright_year"
                                             expanded type="text"
                                             placeholder="Type Copyright Year">
                                    </b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control">
                                            <b-button icon-left="copy"
                                                      @click="copySetting('copyright_year')">
                                            </b-button>
                                    </p>
                                    </b-tooltip>

                                </b-field>


                            </b-field>

                            <div class="block">
                                <b-field  expanded
                                          label="Assign Role(s) on Registration"
                                          :label-position="labelPosition">

                                    <TagRolesOnRegistration :options="assets.roles"
                                                            :allow_new="true"
                                                            v-model="list.registration_roles"
                                                            :selected_value="list.registration_roles"
                                                            @onSelect="onSelectRegistrationRoles"
                                                            :open_on_focus="true"/>

                                </b-field>
                            </div>

                            <div class="block">
                                <b-field  expanded
                                          label="Allowed file types for upload"
                                          class="has-margin-bottom-15"
                                          :label-position="labelPosition">

                                    <TagFileTypes :options="assets.file_types"
                                                  :allow_new="true"
                                                  v-model="list.upload_allowed_files"
                                                  :selected_value="list.upload_allowed_files"
                                                  @onSelect="onSelectFileType"
                                                  :open_on_focus="true"/>

                                </b-field>
                            </div>





                            <b-field  expanded
                                      :message="inputs.maintenance_mode.message"
                                      :type="inputs.maintenance_mode.type"
                                      label="Maintenance Mode"
                                      :label-position="labelPosition">

                                <b-field>
                                    <b-radio-button native-value="0"
                                                    type="is-success"
                                                    v-model="list.maintenance_mode">
                                        <span>Disable</span>
                                    </b-radio-button>

                                    <b-radio-button native-value="1"
                                                    type="is-danger"
                                                    v-model="list.maintenance_mode">
                                        <span>Enable</span>
                                    </b-radio-button>
                                </b-field>



                            </b-field>

                            <b-field  expanded
                                      :type="inputs.password_protection.type"
                                      :message="inputs.password_protection.message"
                                      label="Password Protection"
                                      :label-position="labelPosition">

                                <b-field expanded>

                                    <b-radio-button type="is-success"
                                                    v-model="list.password_protection"
                                                    native-value="0">
                                        <span>Disable</span>
                                    </b-radio-button>

                                    <b-radio-button type="is-danger"
                                                    v-model="list.password_protection"
                                                    native-value="1">
                                        <span>Enable</span>
                                    </b-radio-button>

                                    <b-input expanded type="password"
                                             v-if="list.password_protection == 1"
                                             v-model="list.site_password"
                                             password-reveal
                                             placeholder="Enter password">
                                    </b-input>

                                </b-field>


                            </b-field>


                            <b-field  expanded
                                      :type="inputs.laravel_queues.type"
                                      :message="inputs.laravel_queues.message"
                                      label="Laravel Queues"
                                      :label-position="labelPosition">

                                <b-field expanded>

                                    <b-radio-button type="is-danger"
                                                    v-model="list.laravel_queues"
                                                    native-value="0">
                                        <span>Disable</span>
                                    </b-radio-button>

                                    <b-radio-button type="is-success"
                                                    v-model="list.laravel_queues"
                                                    native-value="1">
                                        <span>Enable</span>
                                    </b-radio-button>

                                </b-field>


                            </b-field>


                            <b-field  expanded
                                      label="Redirect after Backend Logout"
                                      :label-position="labelPosition">

                                <b-field expanded>

                                    <b-radio-button type="is-success"
                                                    v-model="list.redirect_after_backend_logout"
                                                    native-value="backend">
                                        <span>Backend</span>
                                    </b-radio-button>

                                    <b-radio-button type="is-info"
                                                    v-model="list.redirect_after_backend_logout"
                                                    native-value="frontend">
                                        <span>Frontend</span>
                                    </b-radio-button>

                                    <b-radio-button type="is-primary"
                                                    v-model="list.redirect_after_backend_logout"
                                                    native-value="custom">
                                        <span>Custom</span>
                                    </b-radio-button>

                                    <b-input expanded type="text"
                                             v-if="list.redirect_after_backend_logout === 'custom'"
                                             v-model="list.redirect_after_backend_logout_url"
                                             placeholder="Enter url">
                                    </b-input>
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                    <p class="control" v-if="list.redirect_after_backend_logout === 'custom'">
                                            <b-button icon-left="copy"
                                                      @click="copySetting('redirect_after_backend_logout')">
                                            </b-button>
                                    </p>
                                    </b-tooltip>

                                </b-field>

                            </b-field>


                        </div>

                    </div>

                    <div class="column">
                        <div class="block has-padding-left-10 has-padding-right-10">
                            <b-button type="is-primary has-margin-right-10"
                                      :loading="is_loading"
                                      @click="storeSiteSettings" >
                                Save Settings
                            </b-button>
                            <b-button type="is-danger"
                                      :loading="btn_is_loading"
                                      @click="clearCache" >
                                Clear Cache
                            </b-button>
                        </div>
                    </div>

                </div>

            </div>
        </b-collapse>

        <hr class="is-marginless"/>
    </div>

</template>
