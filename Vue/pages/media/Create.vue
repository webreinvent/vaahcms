<script src="./CreateJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    Create
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="setLocalAction('save-and-new')">
                                Save & New
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-close')">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-clone')">
                                    <b-icon icon="copy"></b-icon>
                                    Save & Clone
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="resetNewItem()">
                                    <b-icon icon="eraser"></b-icon>
                                    Reset
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button tag="router-link"
                                      type="is-light"
                                      :to="{name: 'media.list'}"
                                      icon-left="times">
                            </b-button>
                        </p>



                    </div>


                </div>

            </header>
            <!--/header-->

            <!--content-->
            <div class="card-content" v-if="assets">
                <div class="block">


                    <b-field label="Name" :label-position="labelPosition">
                        <b-input type="text"  name="media-name" dusk="media-name"
                                 v-model="new_item.name"></b-input>
                    </b-field>



                    <hr/>


                    <MediaUploader
                        :upload_url="root.assets.urls.upload"
                        :file_name="new_item.name"
                        :show_allowed_types="false"
                        :instant_upload="true"
                        max_size="25MB"
                        :allowed_types="assets.allowed_file_types"
                        @afterUpload="updateMediaToNewItem"/>


                    <hr/>
                    <br/>

                    <b-field label="Uploaded File Name"
                             v-if="new_item.uploaded_file_name"
                             :label-position="labelPosition">
                        <b-field expanded>
                            <b-input type="text"
                                     name="media-download_url"
                                     dusk="media-download_url"
                                     expanded
                                     disabled=""
                                     placeholder="Type slug"
                                     v-model="new_item.uploaded_file_name"></b-input>
                            <p class="control">
                                <b-tooltip label="Remove"
                                           type="is-dark">
                                    <b-button type="is-danger"
                                              @click="resetNewItem"
                                              icon-left="trash"></b-button>
                                </b-tooltip>
                            </p>
                        </b-field>
                    </b-field>



                    <b-field label="Title" :label-position="labelPosition">
                        <b-input type="text"  name="media-title" dusk="media-title"
                                 v-model="new_item.title"></b-input>
                    </b-field>

                    <b-field label="Alternate Text" :label-position="labelPosition">
                        <b-input type="text"  name="media-alt_text" dusk="media-alt_text"
                                 v-model="new_item.alt_text"></b-input>
                    </b-field>

                    <b-field label="Caption" :label-position="labelPosition">
                        <b-input type="textarea"  name="media-caption" dusk="media-caption"
                                 v-model="new_item.caption"></b-input>
                    </b-field>


                    <b-field label="Is this a downloadable media?"
                             :label-position="labelPosition">

                        <b-radio-button v-model="new_item.is_downloadable"
                                        name="media-downloadable"
                                        dusk="media-downloadable"
                                        type="is-success"
                                        size="is-small"
                                        :native-value="false">
                            <b-icon icon="lock-open"></b-icon>
                            <span>No</span>
                        </b-radio-button>

                        <b-radio-button v-model="new_item.is_downloadable"
                                        name="media-download_requires_login"
                                        dusk="media-download_requires_login"
                                        type="is-danger"
                                        size="is-small"
                                        :native-value="true">
                            <b-icon icon="lock"></b-icon>
                            <span>Yes</span>
                        </b-radio-button>

                    </b-field>

                    <div v-if="new_item.is_downloadable">

                        <b-field label="Download URL"
                             :message="assets.download_url+new_item.download_url"
                             :label-position="labelPosition">
                        <b-field expanded>
                            <b-input type="text"
                                     name="media-download_url"
                                     dusk="media-download_url"
                                     expanded
                                     placeholder="Type slug"
                                     v-model="new_item.download_url"></b-input>
                            <p class="control">
                                <b-tooltip label="Check url availability" type="is-dark">
                                    <b-button v-if="new_item.downloadable_slug_available"
                                              @click="isDownloadableSlugAvailable"
                                              type="is-success"
                                              icon-left="check"></b-button>
                                    <b-button v-else
                                              @click="isDownloadableSlugAvailable"
                                              icon-left="question"></b-button>
                                </b-tooltip>
                            </p>
                            <p class="control">
                                <b-tooltip label="Copy Link" type="is-dark">
                                    <b-button icon-left="copy"></b-button>
                                </b-tooltip>
                            </p>
                        </b-field>
                    </b-field>



                    </div>

                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


