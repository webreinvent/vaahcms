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
                                                  @click="expandAll()"
                                                  icon-left="angle-double-down">
                                            Expand All
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="collapseAll()"
                                                  icon-left="angle-double-up">
                                            Collapse All
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content is-paddingless">


                            <!--site_settings-->
                            <div class="block is-marginless">

                                <b-collapse :open="false" aria-id="site_settings">

                                    <div class="level has-padding-10" slot="trigger"
                                         aria-controls="site_settings">

                                        <div class="label-left">
                                            <h4 class="title is-5">Site Settings</h4>
                                            <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="site_settings"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block has-margin-top-20 has-padding-10">

                                        <div class="columns has-background-white-bis is-paddingless">
                                            <div class="column is-half">
                                                <div class="block has-padding-10">

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


                                                    <b-field  label="Default Site Language"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-select placeholder="Default Site Language">
                                                            <option value="open-graph">
                                                                Open Graph
                                                            </option>
                                                            <option value="facebook">
                                                                Facebook
                                                            </option>
                                                            <option value="twitter">
                                                                Twitter
                                                            </option>
                                                        </b-select>

                                                    </b-field>




                                                    <div class="block">
                                                        <b-field  expanded
                                                                  label="Search Engine Visibility"

                                                                  :label-position="labelPosition">

                                                            <b-radio-button :native-value="true"
                                                                            type="is-success"

                                                                            v-model="settings.general.search_engine_visibility">
                                                                <span>Visible</span>
                                                            </b-radio-button>

                                                            <b-radio-button :native-value="false"
                                                                            type="is-danger"
                                                                            v-model="settings.general.search_engine_visibility">
                                                                <span>Invisible</span>
                                                            </b-radio-button>

                                                            <p class="control">
                                                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                    <b-button icon-left="copy"></b-button>
                                                                </b-tooltip>
                                                            </p>

                                                        </b-field>
                                                        <p class="help">asdfasd asdfads</p>
                                                    </div>


                                                    <div class="block">
                                                        <b-field  expanded
                                                                  label="Maintenance Mode"

                                                                  :label-position="labelPosition">

                                                            <b-radio-button :native-value="true"
                                                                            type="is-success"

                                                                            v-model="settings.general.maintenance_mode">
                                                                <span>Disable</span>
                                                            </b-radio-button>

                                                            <b-radio-button :native-value="false"
                                                                            type="is-danger"
                                                                            v-model="settings.general.maintenance_mode">
                                                                <span>Enable</span>
                                                            </b-radio-button>



                                                        </b-field>
                                                        <p class="help">asdfasd asdfads</p>
                                                    </div>




                                                    <b-button type="is-primary" >Save</b-button>

                                                </div>

                                            </div>
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


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

                                                    <b-field  expanded
                                                              label="Password Protection"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-radio-button type="is-success" native-value="false">
                                                            <span>Disable</span>
                                                        </b-radio-button>

                                                        <b-radio-button type="is-danger" native-value="true">
                                                            <span>Enable</span>
                                                        </b-radio-button>

                                                        <b-input expanded type="text"
                                                                 placeholder="Enter password">
                                                        </b-input>


                                                    </b-field>


                                                </div>

                                            </div>
                                        </div>



                                    </div>
                                </b-collapse>

                                <hr class="is-marginless"/>
                            </div>
                            <!--/site_settings-->

                            <!--repeatable-->
                            <div class="block is-marginless">

                                <b-collapse :open="false" aria-id="date_time_settings">

                                    <div class="level has-padding-10" slot="trigger"
                                         aria-controls="date_time_settings">

                                        <div class="label-left">
                                            <h4 class="title is-5">Date & Time</h4>
                                            <h2 class="subtitle is-6">Global date and time settings.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="date_time_settings"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block has-margin-top-20 has-padding-10">

                                        <div class="columns has-background-white-bis is-paddingless">
                                            <div class="column is-half">
                                                <div class="block has-padding-10">



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



                                                    <b-button type="is-primary" >Save Password</b-button>

                                                </div>

                                            </div>
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


                                                </div>

                                            </div>
                                        </div>



                                    </div>
                                </b-collapse>

                                <hr class="is-marginless"/>
                            </div>
                            <!--/repeatable-->


                            <!--repeatable-->
                            <div class="block is-marginless">

                                <b-collapse :open="false" aria-id="social_links">

                                    <div class="level has-padding-10" slot="trigger"
                                         aria-controls="social_links">

                                        <div class="label-left">
                                            <h4 class="title is-5">Social Media & Links</h4>
                                            <h2 class="subtitle is-6">Static links management.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="social_links"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block has-margin-top-20 has-padding-10">

                                        <div class="columns has-background-white-bis is-paddingless">
                                            <div class="column is-half">
                                                <div class="block has-padding-10">



                                                    <b-field  expanded
                                                              v-for="link in settings.links"
                                                              :label="link.name"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-input expanded type="text"
                                                                 v-model="link.name"
                                                                 placeholder="Link Label">
                                                        </b-input>

                                                        <b-input expanded type="text"
                                                                 v-model="link.url"
                                                                 placeholder="Link Url">
                                                        </b-input>



                                                        <p class="control">
                                                            <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                <b-button icon-left="copy"></b-button>
                                                            </b-tooltip>
                                                        </p>
                                                        <p class="control">
                                                            <b-tooltip label="Delete" type="is-dark">
                                                                <b-button icon-left="trash"></b-button>
                                                            </b-tooltip>
                                                        </p>

                                                    </b-field>


                                                    <b-field>
                                                        <p class="control">
                                                            <b-button type="is-primary" icon-left="plus">Add Link</b-button>
                                                        </p>
                                                        <p class="control">
                                                            <b-button type="is-primary">Save</b-button>
                                                        </p>
                                                    </b-field>




                                                </div>

                                            </div>
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


                                                </div>

                                            </div>
                                        </div>



                                    </div>
                                </b-collapse>

                                <hr class="is-marginless"/>
                            </div>
                            <!--/repeatable-->

                            <!--repeatable-->
                            <div class="block is-marginless">

                                <b-collapse :open="false" aria-id="scripts">

                                    <div class="level has-padding-10" slot="trigger"
                                         aria-controls="scripts">

                                        <div class="label-left">
                                            <h4 class="title is-5">Scripts</h4>
                                            <h2 class="subtitle is-6">Add scripts of Google Analytics and other tracking scripts.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="scripts"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block has-margin-top-20 has-padding-10">

                                        <div class="columns has-background-white-bis is-paddingless">
                                            <div class="column is-half">
                                                <div class="block has-padding-10">



                                                    <b-field  expanded
                                                              label="After head tag start (<head>)"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-input expanded type="textarea"
                                                                 v-model="settings.scripts.after_head_start"
                                                                 placeholder="">
                                                        </b-input>

                                                        <p class="control">
                                                            <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                <b-button icon-left="copy"></b-button>
                                                            </b-tooltip>
                                                        </p>


                                                    </b-field>

                                                    <b-field  expanded
                                                              label="Before head tag close (</head>)"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-input expanded type="textarea"
                                                                 v-model="settings.scripts.after_head_start"
                                                                 placeholder="">
                                                        </b-input>

                                                        <p class="control">
                                                            <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                <b-button icon-left="copy"></b-button>
                                                            </b-tooltip>
                                                        </p>


                                                    </b-field>

                                                    <b-field>
                                                        <p class="control">
                                                            <b-button type="is-primary">Save</b-button>
                                                        </p>
                                                    </b-field>




                                                </div>

                                            </div>
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


                                                    <b-field  expanded
                                                              label="After body tag start (<body>)"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-input expanded type="textarea"
                                                                 v-model="settings.scripts.after_body_start"
                                                                 placeholder="">
                                                        </b-input>

                                                        <p class="control">
                                                            <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                <b-button icon-left="copy"></b-button>
                                                            </b-tooltip>
                                                        </p>


                                                    </b-field>

                                                    <b-field  expanded
                                                              label="Before body tag close (</body>)"
                                                              class="has-margin-bottom-15"
                                                              :label-position="labelPosition">

                                                        <b-input expanded type="textarea"
                                                                 v-model="settings.scripts.before_body_close"
                                                                 placeholder="">
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
                                </b-collapse>

                                <hr class="is-marginless"/>
                            </div>
                            <!--/repeatable-->

                            <!--repeatable-->
                            <div class="block is-marginless">

                                <b-collapse :open="false" aria-id="social_links">

                                    <div class="level has-padding-10" slot="trigger"
                                         aria-controls="social_links">

                                        <div class="label-left">
                                            <h4 class="title is-5">Meta Tags</h4>
                                            <h2 class="subtitle is-6">Global meta tags.</h2>
                                        </div>
                                        <div class="label-right">
                                            <b-button aria-controls="social_links"  slot="trigger">Expand</b-button>
                                        </div>

                                    </div>


                                    <div class="block has-margin-top-20 has-padding-10">

                                        <div class="columns has-background-white-bis is-paddingless">
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


                                                    <div class="block" v-for="meta in settings.meta_tags">

                                                        <b-field :label="meta.label" :label-position="labelPosition">

                                                            <p class="control" v-if="meta.attribute">
                                                                <a class="button is-static">
                                                                    {{ meta.attribute }}                                                                </a>
                                                            </p>

                                                            <b-select v-else placeholder="Select attribute">
                                                                <option
                                                                    v-for="attr in assets.vh_meta_attributes"
                                                                    :value="attr.slug"
                                                                    :key="attr.slug">
                                                                    {{ attr.name }}
                                                                </option>
                                                            </b-select>


                                                            <p class="control" v-if="meta.property_value">
                                                                <a class="button is-static">
                                                                    {{meta.property_value}}
                                                                </a>
                                                            </p>

                                                            <b-input v-else v-model="meta.property_value"></b-input>

                                                            <p class="control">
                                                                <a class="button is-static">
                                                                    Content:
                                                                </a>
                                                            </p>
                                                            <b-input expanded v-model="meta.content"></b-input>

                                                            <p class="control">
                                                                <b-tooltip label="Delete" type="is-dark">
                                                                    <b-button icon-left="trash"></b-button>
                                                                </b-tooltip>
                                                            </p>

                                                        </b-field>

                                                    </div>




                                                    <b-field>

                                                        <b-field>
                                                            <p class="control">
                                                                <b-button type="is-success" icon-left="plus">Add Meta Tag</b-button>
                                                            </p>
                                                            <p class="control">
                                                                <b-button type="is-primary">Save</b-button>
                                                            </p>
                                                            <p class="control">
                                                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                                                    <b-button type="is-primary" icon-left="copy"></b-button>
                                                                </b-tooltip>
                                                            </p>
                                                        </b-field>

                                                        <b-field class="has-margin-left-20">
                                                            <b-select placeholder="Select Meta Tags Group">
                                                                <option value="open-graph">
                                                                    Open Graph
                                                                </option>
                                                                <option value="facebook">
                                                                    Facebook
                                                                </option>
                                                                <option value="twitter">
                                                                    Twitter
                                                                </option>
                                                            </b-select>
                                                            <p class="control">
                                                                <b-button type="is-primary">Generate</b-button>
                                                            </p>
                                                        </b-field>

                                                    </b-field>



                                                </div>

                                            </div>
                                            <div class="column is-half">
                                                <div class="block has-padding-10">


                                                </div>

                                            </div>
                                        </div>



                                    </div>
                                </b-collapse>

                                <hr class="is-marginless"/>
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


