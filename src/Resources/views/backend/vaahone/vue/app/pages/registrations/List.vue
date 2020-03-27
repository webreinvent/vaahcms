<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container">

            <div class="columns">

                <!--left-->
                <div class="column">


                    <!--card-->
                    <div class="card">

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Registrations
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p class="control">
                                        <b-button tag="router-link"
                                                  :to="{name: 'reg.create'}"
                                                  icon-left="plus">
                                            Create
                                        </b-button>
                                    </p>

                                    <p class="control">

                                        <b-button @click="getList()"
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
                                            <div class="field has-addons" custom-class="is-small">
                                                <div class="control">
                                                    <b-dropdown  aria-role="list">
                                                        <button class="button" slot="trigger">
                                                            <span>Bulk Actions</span>
                                                            <b-icon icon="caret-down"></b-icon>
                                                        </button>

                                                        <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                                                        <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                                                    </b-dropdown>
                                                </div>
                                                <div class="control">
                                                    <a class="button is-primary">
                                                        Apply
                                                    </a>
                                                </div>
                                            </div>
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
                                                            @click="resetQueryString">
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
                                                <b-select placeholder="Select a status"
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

                                    <div class="block" style="margin-bottom: 0px;">


                                        <b-table :data="page.list_is_empty ? [] : page.list.data"
                                                 :checkable="true"
                                                 checkbox-position="left"
                                                 :hoverable="true"
                                        >

                                            <template slot-scope="props">
                                                <b-table-column field="id" label="ID" width="40" numeric>
                                                    {{ props.row.id }}
                                                </b-table-column>

                                                <b-table-column field="name" label="Name">
                                                    {{ props.row.name }}
                                                </b-table-column>

                                                <b-table-column field="email" label="Email">
                                                    {{ props.row.email }}
                                                </b-table-column>

                                                <b-table-column field="status" label="Status">
                                                    <span class="tag is-success">
                                                        {{ props.row.status }}
                                                    </span>
                                                </b-table-column>

                                                <b-table-column field="date" v-if="page.list_view"
                                                                label="Created At" centered>
                                                    {{ $vaah.fromNow(props.row.created_at) }}
                                                </b-table-column>

                                                <b-table-column label="Gender" v-if="page.list_view">
                                                    <span>
                                                        <b-icon pack="fas"
                                                                :icon="props.row.gender === 'Male' ? 'mars' : 'venus'">
                                                        </b-icon>
                                                        {{ props.row.gender }}
                                                    </span>
                                                </b-table-column>
                                            </template>

                                            <template slot="empty">
                                                <section class="section">
                                                    <div class="content has-text-grey has-text-centered">
                                                        <p>Nothing here.</p>
                                                    </div>
                                                </section>
                                            </template>

                                        </b-table>
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


