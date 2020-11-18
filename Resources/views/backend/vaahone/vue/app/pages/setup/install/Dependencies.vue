<script src="./DependenciesJs.js"></script>
<template>

    <div v-if="assets">

        <!--columns-->
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                <b-notification type="is-info" aria-close-label="Close notification">
                    This step will will install dependencies.
                </b-notification>


                <div class="columns  is-multiline" v-if="config.dependencies">
                    <div class="column is-6"
                         v-if="config.dependencies"
                         v-for="item in config.dependencies">
                        <div class="card">

                            <!--<div class="card-image" v-if="item.thumbnail">
                                <figure class="image">
                                    <img style="max-height: 160px;" :src="item.thumbnail">
                                </figure>
                            </div>-->

                            <div class="card-content">
                                <div class="media">

                                    <div class="media-content">
                                        <div class="level">

                                            <div class="level-left">
                                                <h3 class="title is-4">{{item.name}}</h3>
                                            </div>

                                            <div class="level-right">
                                                <b-button size="is-small"
                                                          type="is-success"
                                                          rounded
                                                          class="pull-right"
                                                          v-if="item.installed"
                                                          icon-left="check">
                                                </b-button>
                                                <b-button size="is-small"
                                                          type="is-light"
                                                          v-else
                                                          rounded
                                                          class="pull-right"
                                                          icon-left="download">
                                                </b-button>
                                            </div>

                                        </div>

                                        <p class="has-margin-bottom-20">

                                            <b-tag >{{item.type}}</b-tag>
                                            <b-tag >{{item.slug}}</b-tag>
                                            <b-tag>{{item.version}}</b-tag>

                                        </p>
                                        <p>{{item.title}}</p>

                                        <p>
                                        Developed By:
                                        <a target="_blank" :href="item.author_website">
                                            {{item.author_name}}
                                        </a>
                                        </p>

                                        <div v-if="item.is_sample_data_available">

                                            <div class="has-margin-top-10 has-margin-bottom-10">

                                                <b-progress type="is-success"
                                                            v-if="active_dependency && item.slug === active_dependency.slug "
                                                            size="is-hair"></b-progress>
                                                <b-progress type="is-success"
                                                            :value="0"
                                                            v-else
                                                            size="is-hair"></b-progress>
                                            </div>

                                            <p>
                                                <b-checkbox v-model="item.import_sample_data">
                                                    Import Sample Data
                                                </b-checkbox>
                                            </p>

                                        </div>






                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <b-progress type="is-success"
                            size="is-tiny"
                            v-model="config.count_installed_progress"
                ></b-progress>


                <b-button type="is-success"
                          v-if="config.count_installed_progress === 100"
                          icon-left="check"
                          :loading="btn_is_installing"
                          @click="installDependencies()">
                    Download & Install Dependencies
                </b-button>

                <b-button type="is-info"
                          v-else
                          icon-left="download"
                          :loading="btn_is_installing"
                          @click="installDependencies()">
                    Download & Install Dependencies
                </b-button>

                <b-button type="is-light"
                          @click="skipDependencies()">
                    Skip
                </b-button>

                <hr>

                <div class="level">
                    <div class="level-left">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      size="small"
                                      tag="router-link"
                                      :to="{name: 'setup.install.migrate'}">
                                Back
                            </b-button>
                        </div>

                    </div>

                    <div class="level-right">

                        <div class="level-item">
                            <b-button type="is-primary"
                                      @click="validateDependencies()"
                                      size="small">
                                Save & Next
                            </b-button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!--/columns-->


    </div>


</template>

