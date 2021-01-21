<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="columns">

            <!--left-->
            <div class="column" :class="{'is-6': !page.list_view}">

                <div class="block" v-if="is_content_loading">
                    <Loader/>
                </div>

                <!--card-->
                <div class="card" v-else-if="page.assets">

                    <!--header-->
                    <header class="card-header">

                        <div class="card-header-title">
                            Queue Jobs

                            <span v-if="page.list">
                                 &nbsp; ({{page.list.total}})
                            </span>

                        </div>

                        <b-tooltip label="Reload" type="is-dark">
                            <b-button type="is-text"
                                      class="card-header-icon has-margin-top-5 has-margin-right-5"
                                      icon-left="redo-alt"></b-button>
                        </b-tooltip>

                    </header>
                    <!--/header-->

                    <b-notification type="is-info"
                                    :closable="false"
                                    class="is-light is-small">
                        This list consist of only queued/pending jobs.
                        Completed jobs gets deleted automatically .
                    </b-notification>

                    <!--content-->
                    <div class="card-content">



                        <div class="block" v-if="page.list">


                            <!--actions-->
                            <div class="level">

                                <!--left-->
                                <div class="level-left" >
                                    <div  class="level-item">
                                        <b-field >

                                            <b-select placeholder="- Bulk Actions -"
                                                      v-model="page.bulk_action.action">
                                                <option value="">
                                                    - Bulk Actions -
                                                </option>
                                                <option value="bulk-delete">
                                                    Delete
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
                                    <b-field label="">
                                        <p class="control">
                                            <b-select placeholder="- Select a status -"
                                                      v-model="query_string.status"
                                                      @input="getList()"
                                            >
                                                <option value="">
                                                    - Select a status -
                                                </option>
                                                <option value='default'>
                                                    Default
                                                </option>
                                                <option value='high'>
                                                    High
                                                </option>
                                                <option value='medium'>
                                                    Medium
                                                </option>
                                                <option value='low'>
                                                    Low
                                                </option>
                                            </b-select>
                                        </p>
                                    </b-field>
                                </div>

                                <div class="level-right">
                                    <div class="level-item ">

                                        <b-field>

                                            <b-datepicker
                                                    position="is-bottom-left"
                                                    placeholder="- Select a dates -"
                                                    v-model="selected_date"
                                                    @input="setDateRange"
                                                    range>
                                            </b-datepicker>

                                            <p class="control">
                                                <b-dropdown
                                                        v-model="query_string.date_filter_by"
                                                        @input="setDateByFilter">
                                                    <template #trigger="{ active }">
                                                        <b-button type="is-primary"
                                                                  :icon-right="active ? 'chevron-up' : 'chevron-down'" >
                                                         <span v-if="query_string.date_filter_by">
                                                             {{ $vaah.toLabel(query_string.date_filter_by) }}
                                                         </span>
                                                            <span v-else>Created at</span>
                                                        </b-button>
                                                    </template>


                                                    <b-dropdown-item value="created_at">
                                                        <span>Created at</span>
                                                    </b-dropdown-item>

                                                    <b-dropdown-item value="available_at">
                                                        <span>Available at</span>
                                                    </b-dropdown-item>

                                                    <b-dropdown-item value="reserved_at">
                                                        <span>Reserved at</span>
                                                    </b-dropdown-item>
                                                </b-dropdown>
                                            </p>
                                        </b-field>

                                    </div>
                                </div>







                            </div>
                            <!--/filters-->


                            <!--list-->
                            <div class="block ">

                                <div class="block" style="margin-bottom: 0px;" >

                                    <div v-if="page.list_view">
                                        <ListLargeView @eReloadList="getList" />
                                    </div>

                                </div>

                                <hr style="margin-top: 0;"/>

                                <div class="block" v-if="page.list">
                                    <b-pagination  :total="page.list.total"
                                                   :current.sync="page.list.current_page"
                                                   :per-page="page.list.per_page"
                                                   range-before=3
                                                   range-after=3
                                                   @change="paginate">
                                    </b-pagination>
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

            <router-view @eReloadList="getList"></router-view>

        </div>

    </div>
</template>


