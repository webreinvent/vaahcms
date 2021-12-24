<script src="./IndexJs.js"></script>

<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Update VaahCMS
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="checkForUpdate()"
                                                  :loading="is_check_update_loading"
                                                  icon-left="sync">
                                            Check for Update
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <b-notification v-model="backend_update" type="is-info is-light">

                            <div v-if="release">
                                A newer version <b>{{remote_version}}</b> of VaahCMS is available.

                                <hr/>

                                <b>New Updates:</b>

                                <div class="content">

                                    {{release.body}}
                                </div>

                                <div class="mt-5">
                                    <b-field :label-position="labelPosition">
                                        <b-radio-button :disabled="!is_checkbox_active"
                                                        @input="is_button_active = true"
                                                        v-model="backup_database"
                                                        size="is-small"
                                                        :native-value=true>
                                            <span>Yes</span>
                                        </b-radio-button>

                                        <b-radio-button :disabled="!is_checkbox_active"
                                                        @input="is_button_active = false"
                                                        type="is-danger"
                                                        size="is-small"
                                                        v-model="backup_database"
                                                        :native-value=false>
                                            <span>No</span>
                                        </b-radio-button>
                                        <div class="has-text-weight-bold ml-2 mt-1 ">
                                            Have you taken the backup of your files & database?
                                        </div>
                                    </b-field>

                                    <b-button :disabled="!is_button_active" @click="onUpdate">
                                        Update Now
                                    </b-button>
                                </div>

                                <div v-if="is_update_step_visible" class="ml-3 mt-4">
                                    <ol>

                                        <li> Download latest version (It can take up to 3 to 5 minutes)

                                            <b-icon v-if="status.download_latest_version === 'success'"
                                                    pack="fas"
                                                    icon="check"
                                                    type="is-success"
                                            >
                                            </b-icon>

                                            <b-icon v-else-if="status.download_latest_version === 'pending'"
                                                    pack="fas"
                                                    icon="sync-alt"
                                                    custom-class="fa-spin">
                                            </b-icon>

                                            <b-icon v-else-if="status.download_latest_version === 'failed'"
                                                    pack="fas"
                                                    icon="times"
                                                    type="is-danger"
                                            >
                                            </b-icon>

                                        </li>
                                        <li> Publish assets
                                            <b-icon v-if="status.publish_assets === 'success'"
                                                    pack="fas"
                                                    icon="check"
                                                    type="is-success"
                                            >
                                            </b-icon>

                                            <b-icon v-else-if="status.publish_assets === 'pending'"
                                                    pack="fas"
                                                    icon="sync-alt"
                                                    custom-class="fa-spin">
                                            </b-icon>

                                            <b-icon v-else-if="status.publish_assets === 'failed'"
                                                    pack="fas"
                                                    icon="times"
                                                    type="is-danger">
                                            </b-icon>
                                        </li>
                                        <li> Run Migrations and Seeds
                                            <b-icon v-if="status.migration_and_seeds === 'success'"
                                                    pack="fas"
                                                    icon="check"
                                                    type="is-success"
                                            >
                                            </b-icon>

                                            <b-icon v-else-if="status.migration_and_seeds === 'pending'"
                                                    pack="fas"
                                                    icon="sync-alt"
                                                    custom-class="fa-spin">
                                            </b-icon>

                                            <b-icon v-else-if="status.migration_and_seeds === 'failed'"
                                                    pack="fas"
                                                    icon="times"
                                                    type="is-danger">
                                            </b-icon>
                                        </li>
                                        <li> Clear Cache
                                            <b-icon v-if="status.clear_cache === 'success'"
                                                    pack="fas"
                                                    icon="check"
                                                    type="is-success"
                                            >
                                            </b-icon>

                                            <b-icon v-else-if="status.clear_cache === 'pending'"
                                                    pack="fas"
                                                    icon="sync-alt"
                                                    custom-class="fa-spin">
                                            </b-icon>

                                            <b-icon v-else-if="status.clear_cache === 'failed'"
                                                    pack="fas"
                                                    icon="times"
                                                    type="is-danger">
                                            </b-icon>
                                        </li>
                                        <li> Reload
                                            <b-icon v-if="status.page_refresh === 'pending'"
                                                    pack="fas"
                                                    icon="check"
                                                    type="is-success"
                                            >
                                            </b-icon>

                                            <b-icon v-else-if="status.page_refresh === 'success'"
                                                    pack="fas"
                                                    icon="sync-alt"
                                                    custom-class="fa-spin">
                                            </b-icon>

                                            <b-icon v-else-if="status.page_refresh === 'failed'"
                                                    pack="fas"
                                                    icon="times"
                                                    type="is-danger">
                                            </b-icon>
                                        </li>

                                    </ol>
                                </div>
                            </div>

                        </b-notification>

                        <b-notification v-model="manual_update" type="is-danger is-light">

                            <div v-if="release">
                                A newer version <b>{{remote_version}}</b> of VaahCMS is available.
                                This is a <b>major release</b>. You have to do manual upgrade to update VaahCms.

                                <hr/>

                                <b>New Updates:</b>

                                <div class="content">

                                    {{release.body}}
                                </div>

                                <b>Steps of Manually Upgrade</b>
                                <ol class="ml-4">
                                    <li>Go to Root path</li>
                                    <li>Verify <b>version</b> of <b>webreinvent/vaahcms</b> in Composer.json</li>
                                    <li>Run <b>Composer Update</b></li>
                                    <li>Publish assets</li>
                                    <li>Run Migrations and Seeds</li>
                                    <li>Clear Cache</li>
                                </ol>


                            </div>

                        </b-notification>

                        <div v-if="root.assets
                            && root.assets.vaahcms
                            && root.assets.vaahcms.version"
                             class="card-content has-text-centered is-size-6
                             has-text-weight-bold has-text-danger">


                            {{ update_message }} v{{root.assets.vaahcms.version}}



                        </div>


                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>


