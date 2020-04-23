<script src="./IndexJs.js"></script>
<template>
    <div class="form-page-v1-layout" v-if="assets">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                General
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  icon-left="angle-double-down">
                                            Expand All
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  icon-left="angle-double-up">
                                            Collapse All
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">


                            <div class="block">


                                <b-collapse :open="false" aria-id="contentIdForA11y1">

                                    <div class="level" slot="trigger"
                                         aria-controls="contentIdForA11y1">

                                        <div class="label-left">
                                            <h4 class="title is-5">Site Settings</h4>
                                            <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="contentIdForA11y1"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block">

                                        <b-field label="Name" message="Testing Testing">
                                            <b-input></b-input>
                                        </b-field>

                                        <b-field label="Message">
                                            <b-input maxlength="200" type="textarea"></b-input>
                                        </b-field>
                                    </div>
                                </b-collapse>


                                <hr class="has-margin-top-20"/>
                            </div>

                            <div class="block">


                                <b-collapse :open="false" aria-id="contentIdForA11y1">

                                    <div class="level" slot="trigger"
                                         aria-controls="contentIdForA11y1">

                                        <div class="label-left">
                                            <h4 class="title is-5">Site Settings</h4>
                                            <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="contentIdForA11y1"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block">

                                        <b-field label="Name" message="Testing Testing">
                                            <b-input></b-input>
                                        </b-field>

                                        <b-field label="Message">
                                            <b-input maxlength="200" type="textarea"></b-input>
                                        </b-field>
                                    </div>
                                </b-collapse>


                                <hr class="has-margin-top-20"/>
                            </div>

                            <div class="block">


                                <b-collapse :open="false" aria-id="contentIdForA11y1">

                                    <div class="level" slot="trigger"
                                         aria-controls="contentIdForA11y1">

                                        <div class="label-left">
                                            <h4 class="title is-5">Site Settings</h4>
                                            <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="contentIdForA11y1"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block">

                                        <b-field label="Name" message="Testing Testing">
                                            <b-input></b-input>
                                        </b-field>

                                        <b-field label="Message">
                                            <b-input maxlength="200" type="textarea"></b-input>
                                        </b-field>
                                    </div>
                                </b-collapse>


                                <hr class="has-margin-top-20"/>
                            </div>



                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <hr/>


                            <!--repeatable-->
                            <div class="columns">
                                <div class="column  is-4" >
                                    <h4 class="title is-5">Site Settings</h4>
                                    <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                </div>
                                <div class="column is-8">

                                    <div class="card">
                                        <div class="card-content">

                                            <b-field label="Site Title"
                                                     class="has-margin-bottom-15"
                                                     expanded
                                                     :label-position="labelPosition">
                                                <b-input expanded type="text"></b-input>
                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>
                                            </b-field>

                                            <b-field label="Meta Description"
                                                     class="has-margin-bottom-15"
                                                     :label-position="labelPosition">
                                                <b-input maxlength="200" expanded type="textarea"></b-input>
                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>
                                            </b-field>

                                            <b-field  expanded
                                                      label="Copyright Text"
                                                      class="has-margin-bottom-15"
                                                     :label-position="labelPosition">

                                                <b-radio-button native-value="app_name">
                                                    <span>Use App Name</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         placeholder="Type Copyright Text">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                            <b-field  expanded
                                                      label="Copyright Link"
                                                      class="has-margin-bottom-15"
                                                      :label-position="labelPosition">

                                                <b-radio-button native-value="app_url">
                                                    <span>Use App Url</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         placeholder="Type Copyright Link">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                            <b-field  expanded
                                                      label="Copyright Year"
                                                      class="has-margin-bottom-15"
                                                      :label-position="labelPosition">

                                                <b-radio-button native-value="current">
                                                    <span>Use Current Year</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         placeholder="Type Copyright Year">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                            <div class="block">
                                                <b-field  expanded
                                                          label="Assign Role(s) on Registration"
                                                          class="has-margin-bottom-15"
                                                          :label-position="labelPosition">

                                                    <TagRolesOnRegistration :options="assets.roles"
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
                                                                  :open_on_focus="true"/>

                                                </b-field>
                                            </div>


                                            <div class="block">
                                                <b-field  expanded
                                                          label="Discourage Search Engine Visibility"

                                                          :label-position="labelPosition">

                                                    <b-radio-button :native-value="false"
                                                                    type="is-danger"
                                                                    v-model="settings.general.search_engine_visibility">
                                                        <span>Yes</span>
                                                    </b-radio-button>

                                                    <b-radio-button :native-value="true"
                                                                    type="is-success"
                                                                    v-model="settings.general.search_engine_visibility">
                                                        <span>No</span>
                                                    </b-radio-button>

                                                    <p class="control">
                                                        <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                            <b-button icon-left="copy"></b-button>
                                                        </b-tooltip>
                                                    </p>

                                                </b-field>
                                                <p class="help">asdfasd asdfads</p>
                                            </div>




                                            <b-button type="is-primary" >Save Password</b-button>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!--/repeatable-->


                            <!--repeatable-->
                            <div class="columns">
                                <div class="column " >
                                    <hr/>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column  is-4" >
                                    <h4 class="title is-5">Date & Time</h4>
                                    <h2 class="subtitle is-6">Global date and time settings.</h2>
                                </div>
                                <div class="column is-8">

                                    <div class="card">
                                        <div class="card-content">

                                            <b-field  expanded
                                                      label="Date Format"
                                                      class="has-margin-bottom-15"
                                                      :label-position="labelPosition">

                                                <b-radio-button native-value="Y-m-d"
                                                                v-model="settings.formats.date">
                                                    <span>Y-m-d</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="Y/m/d"
                                                                v-model="settings.formats.date">
                                                    <span>Y/m/d</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="Y.m.d"
                                                                v-model="settings.formats.date">
                                                    <span>Y.m.d</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom"
                                                                v-model="settings.formats.date_type">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         v-if="settings.formats.date_type"
                                                         v-model="settings.formats.date"
                                                         placeholder="Type valid date format">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                            <b-field  expanded
                                                      label="Time Format"
                                                      class="has-margin-bottom-15"
                                                      :label-position="labelPosition">

                                                <b-radio-button native-value="H:i:s"
                                                                v-model="settings.formats.time">
                                                    <span>H:i:s</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="h:i A"
                                                                v-model="settings.formats.time">
                                                    <span>h:i A</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="h:i:s A"
                                                                v-model="settings.formats.time">
                                                    <span>h:i:s A</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom"
                                                                v-model="settings.formats.time_type">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         v-if="settings.formats.time_type"
                                                         v-model="settings.formats.time"
                                                         placeholder="Type valid time format">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                            <b-field  expanded
                                                      label="Date Time Format"
                                                      class="has-margin-bottom-15"
                                                      :label-position="labelPosition">

                                                <b-radio-button native-value="H:i:s"
                                                                v-model="settings.formats.time">
                                                    <span>H:i:s</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="h:i A"
                                                                v-model="settings.formats.time">
                                                    <span>h:i A</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="h:i:s A"
                                                                v-model="settings.formats.time">
                                                    <span>h:i:s A</span>
                                                </b-radio-button>

                                                <b-radio-button native-value="custom"
                                                                v-model="settings.formats.time_type">
                                                    <span>Custom</span>
                                                </b-radio-button>

                                                <b-input expanded type="text"
                                                         v-if="settings.formats.time_type"
                                                         v-model="settings.formats.time"
                                                         placeholder="Type valid time format">
                                                </b-input>

                                                <p class="control">
                                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                        <b-button icon-left="copy"></b-button>
                                                    </b-tooltip>
                                                </p>

                                            </b-field>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!--/repeatable-->











                            <!--repeatable-->
                            <div class="columns">
                                <div class="column " >
                                    <hr/>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column  is-4" >
                                    <h4 class="title is-5">Password</h4>
                                    <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                </div>
                                <div class="column is-8">

                                    <div class="card">
                                        <div class="card-content">

                                            <b-field label="Current Password"
                                                     message="You must provide your current password in order to change it."
                                                     :label-position="labelPosition">
                                                <b-input type="password"
                                                         name="profile-current_password"
                                                         dusk="profile-current_password"
                                                         password-reveal></b-input>
                                            </b-field>


                                            <b-button type="is-primary" >Save Password</b-button>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!--/repeatable-->

                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>


