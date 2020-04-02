<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column" :class="{'is-7': !page.list_view}">

                    <div class="block" v-if="is_content_loading">
                        <Loader/>
                    </div>

                    <!--card-->
                    <div class="card" v-else-if="page.assets">

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Registrations
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p class="control">
                                        <b-button tag="router-link"
                                                  type="is-light"
                                                  :to="{name: 'reg.create'}"
                                                  icon-left="plus">
                                            Create
                                        </b-button>
                                    </p>

                                    <p class="control">

                                        <b-button @click="reload()"
                                                  type="is-light"
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
                                    <div class="level-left">
                                        <div  class="level-item">
                                            <b-field>

                                                <b-select placeholder="- Bulk Actions -"
                                                          v-model="page.bulk_action.action">
                                                    <option value="">
                                                        - Bulk Actions -
                                                    </option>
                                                    <option
                                                        v-for="option in page.assets.bulk_actions"
                                                        :value="option.slug"
                                                        :key="option.slug">
                                                        {{ option.name }}
                                                    </option>
                                                </b-select>

                                                <b-select placeholder="- Select Status -"
                                                          v-if="page.bulk_action.action == 'bulk-change-status'"
                                                          v-model="page.bulk_action.data.status">
                                                    <option value="">
                                                        - Select Status -
                                                    </option>
                                                    <option
                                                        v-for="option in page.assets.registration_statuses"
                                                        :value="option.slug"
                                                        :key="option.slug">
                                                        {{ option.name }}
                                                    </option>
                                                </b-select>


                                                <p class="control">
                                                    <button class="button is-primary"
                                                            @click="actions">
                                                        Apply
                                                    </button>
                                                </p>

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
                                                <p class="control">
                                                    <button class="button is-primary"
                                                            @click="toggleFilters()"
                                                            slot="trigger">
                                                        <b-icon icon="ellipsis-v"></b-icon>
                                                    </button>
                                                </p>
                                            </b-field>

                                        </div>

                                    </div>
                                    <!--/right-->

                                </div>
                                <!--/actions-->

                                <!--filters-->
                                <div class="level" v-if="page.show_filters">

                                    <div class="level-left">



                                        <div class="level-item">

                                            <b-field label="">
                                                <b-select placeholder="- Select a status -"
                                                          v-model="query_string.status"
                                                          @input="getList()"
                                                >
                                                    <option value="">
                                                        - Select a status -
                                                    </option>
                                                    <option
                                                        v-for="option in page.assets.registration_statuses"
                                                        :value="option.slug"
                                                        :key="option.slug">
                                                        {{ option.name }}
                                                    </option>
                                                </b-select>
                                            </b-field>


                                        </div>

                                        <div class="level-item">
                                            <div class="field">
                                                <b-checkbox v-model="query_string.trashed"
                                                            @input="getList"
                                                >
                                                    Include Trashed
                                                </b-checkbox>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <!--/filters-->


                                <!--list-->
                                <div class="block ">

                                    <div class="block" style="margin-bottom: 0px;" >

                                        <div v-if="page.list_view">
                                            <ListLargeView/>
                                        </div>

                                        <div v-else>
                                            <ListSmallView/>
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

                <router-view></router-view>

            </div>


        </div>

    </div>
</template>


