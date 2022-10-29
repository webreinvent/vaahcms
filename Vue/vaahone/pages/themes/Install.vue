<script src="./InstallJs.js"></script>
<template>
    <div class="column" >

        <div class="card" v-if="themes.list_is_loading">
            <Loader/>
        </div>

        <div v-else>

            <div class="card has-margin-bottom-20" >

                <!--header-->
                <header class="card-header is-borderless">

                    <div class="card-header-title">
                        Install Themes
                    </div>

                    <div class="card-header-buttons">

                        <div class="field has-addons is-pulled-right">

                            <p class="control">
                                <b-input placeholder="Search..."
                                         type="search"
                                         icon="search"
                                         v-model="themes.query_string.q"
                                         @input="delayedSearch"
                                         @keyup.enter.prevent="delayedSearch"
                                >
                                </b-input>
                            </p>

                            <p class="control">
                                <b-button type="is-light"
                                          @click="reset()"
                                          icon-left="times">
                                </b-button>
                            </p>


                        </div>


                    </div>

                </header>
                <!--/header-->


            </div>


            <div class="columns  is-multiline" v-if="themes.list">
                <div class="column is-6"
                     v-for="item in themes.list.data">
                    <div class="card">

                        <div class="card-image" v-if="item.thumbnail">
                            <figure class="image">
                                <img style="max-height: 160px;" :src="item.thumbnail">
                            </figure>
                        </div>

                        <div class="card-content">
                            <div class="media">

                                <div class="media-content">
                                    <h3 class="title is-4">{{item.title}}</h3>

                                    <div class="content">

                                        <p>{{item.excerpt}}</p>

                                        <Tags :item="item" :hide_update_tag="true"/>

                                    </div>

                                    <div >

                                        <div class="has-margin-top-10 has-margin-bottom-10">

                                            <b-progress type="is-success"
                                                        v-if="themes.active_download && themes.active_download.slug === item.slug"
                                                        size="is-hair">
                                            </b-progress>

                                            <b-progress type="is-success"
                                                        :value="0"
                                                        v-else
                                                        size="is-hair"></b-progress>
                                        </div>

                                        <p v-if="hasPermission('can-install-theme')">
                                            <b-button icon-left="check" type="is-success"
                                                      v-if="isInstalled(item)">Installed</b-button>
                                            <b-button icon-left="download" v-else @click="install(item)">Install</b-button>
                                        </p>

                                    </div>
                                </div>



                            </div>
                        </div>


                    </div>
                </div>


            </div>

            <hr style="margin-top: 0;"/>

            <div class="block" v-if="themes.list">
                <vh-pagination  :limit="1" :data="themes.list"
                                @onPageChange="paginate">
                </vh-pagination>
            </div>

        </div>



    </div>
</template>


