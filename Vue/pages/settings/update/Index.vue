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
                                                  icon-left="sync">
                                            Check for Update
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <b-notification v-if="release && update_available" type="is-info is-light">


                            A newer version <b>{{remote_version}}</b> of VaahCMS is available.

                            <hr/>

                            <b>New Updates:</b>

                            <div class="content" v-html="release.body">

                            </div>

                            <p>
                                <b-field>
                                    <b-checkbox v-model="is_button_active">
                                        Have you taken the backup of your files & database?
                                    </b-checkbox>
                                </b-field>
                            </p>

                            <p><b-button :disabled="!is_button_active" @click="onUpdate">
                                Update Now
                            </b-button></p>

                            <ol>

                                <li> Download latest version

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




                        </b-notification>

                        <div v-if="root.assets
                            && root.assets.vaahcms
                            && root.assets.vaahcms.version"
                             class="card-content">


                            Current version of VaahCMS is v{{root.assets.vaahcms.version}}



                        </div>


                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>


