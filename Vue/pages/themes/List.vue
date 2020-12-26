<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">


        <div class="container" v-if="page">



            <div class="columns">



                <!--left-->
                <div class="column" :class="page.list_view_class">

                    <div class="block" v-if="is_content_loading">
                        <Loader/>
                    </div>

                    <!--card-->
                    <div class="card" v-else-if="page.assets">

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Themes
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p v-if="hasPermission('can-install-theme')" class="control">

                                        <b-button type="is-light"
                                                  tag="router-link"
                                                  @click="setSixColumns()"
                                                  :to="{name: 'themes.install'}"
                                                  icon-left="plus">
                                            Install
                                        </b-button>

                                    </p>

                                    <p v-if="hasPermission('can-update-theme')" class="control">

                                        <b-button type="is-light"
                                                  :loading="is_fetching_updates"
                                                  @click="checkUpdate()"
                                                  icon-left="cloud-download-alt">
                                            Check Updates
                                        </b-button>

                                    </p>

                                    <p class="control">

                                        <b-button type="is-light"
                                                  @click="sync()"
                                                  :loading="is_btn_loading"
                                                  icon-left="redo-alt">
                                        </b-button>

                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">



                            <div class="block" v-if="page.list">


                                <!--actions-->
                                <div class="level">

                                    <!--left-->
                                    <div v-if="hasPermission('can-update-theme')" class="level-left" >
                                        <div  class="level-item">
                                            <b-field label="">
                                                <b-select placeholder="- Select a filter -"
                                                          v-model="query_string.status"
                                                          @input="setFilter()">
                                                    <option value="">
                                                        - Select a filter -
                                                    </option>
                                                    <optgroup label="Status">
                                                        <option value='active'>
                                                            Active
                                                        </option>
                                                        <option value='inactive'>
                                                            Inactive
                                                        </option>
                                                        <option value='update_available'>
                                                            Update Available
                                                        </option>
                                                    </optgroup>


                                                </b-select>

                                            </b-field>
                                        </div>
                                    </div>
                                    <!--/left-->


                                    <!--right-->
                                    <div class="level-right">

                                        <div class="level-item">

                                            <b-field>

                                                <b-input placeholder="Search"
                                                         type="text"
                                                         icon="search"
                                                         @input="delayedSearch"
                                                         @keyup.enter.prevent="delayedSearch"
                                                         v-model="query_string.q">
                                                </b-input>

                                                <p class="control">
                                                    <button class="button is-primary"
                                                            @click="getList">
                                                        Filter
                                                    </button>
                                                </p>
                                                <p class="control">
                                                    <button class="button is-primary"
                                                            @click="resetPage">
                                                        Reset
                                                    </button>
                                                </p>

                                            </b-field>

                                        </div>

                                    </div>
                                    <!--/right-->

                                </div>
                                <!--/actions-->


                                <!--list-->
                                <div class="block ">

                                    <div class="block" style="margin-bottom: 0px;" >

                                        <div v-if="page.list_view">
                                            <ListLargeView @eReloadList="getAssets"/>
                                        </div>

                                        <div v-else>
                                            <ListSmallView @eReloadList="getAssets"/>
                                        </div>

                                    </div>

                                    <hr style="margin-top: 0;"/>

                                    <div class="block" v-if="page.list">
                                        <vh-pagination  :limit="1" :data="page.list"
                                                        @onPageChange="paginate">
                                        </vh-pagination>
                                    </div>

                                </div>
                                <!--/list-->


                            </div>
                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

                <router-view @eReloadList="getList" ></router-view>

            </div>


        </div>


    </div>
</template>


