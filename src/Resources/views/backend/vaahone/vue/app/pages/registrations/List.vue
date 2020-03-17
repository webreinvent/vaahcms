<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container">

            <div class="columns">

                <!--list-->
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

                                <!--search-->
                                <div class="level">

                                    <!--left-->
                                    <div class="level-left">
                                        <router-link to="/" class="level-item">All (8)</router-link>
                                        <router-link to="/" class="level-item">Published (8)</router-link>
                                        <router-link to="/" class="level-item">Trashed (8)</router-link>
                                    </div>
                                    <!--/left-->


                                    <!--right-->
                                    <div class="level-right">
                                        <div class="level-item">
                                            <b-field class="control">
                                                <b-input placeholder="Search..."
                                                         type="search"
                                                         icon="search">
                                                </b-input>
                                            </b-field>
                                        </div>
                                    </div>
                                    <!--/right-->

                                </div>
                                <!--/search-->


                                <!--actions-->
                                <div class="level">

                                    <!--left-->
                                    <div class="level-left">
                                        <div  class="level-item">
                                            <div class="field has-addons">
                                                <div class="control">
                                                    <b-dropdown aria-role="list">
                                                        <button class="button" slot="trigger">
                                                            <span>Bulk Actions</span>
                                                            <b-icon icon="caret-down"></b-icon>
                                                        </button>

                                                        <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                                                        <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                                                    </b-dropdown>
                                                </div>
                                                <div class="control">
                                                    <a class="button is-info">
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
                                            <b-dropdown aria-role="list">
                                                <button class="button" slot="trigger">
                                                    <span>All Categories</span>
                                                    <b-icon icon="caret-down"></b-icon>
                                                </button>

                                                <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                                                <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                                            </b-dropdown>
                                        </div>

                                        <div class="level-item">
                                            <b-dropdown aria-role="list">
                                                <button class="button" slot="trigger">
                                                    <span>All Formats</span>
                                                    <b-icon icon="caret-down"></b-icon>
                                                </button>

                                                <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                                                <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                                            </b-dropdown>
                                        </div>

                                        <div class="level-item">
                                            <a class="button is-info">
                                                Filter
                                            </a>
                                        </div>

                                    </div>
                                    <!--/right-->

                                </div>
                                <!--/actions-->


                                {{page.list_is_empty}} |
                                {{page.list}}


                                <b-table :data="page.list_is_empty ? [] : page.list.data">

                                    <template slot-scope="props">
                                        <b-table-column field="id" label="ID" width="40" numeric>
                                            {{ props.row.id }}
                                        </b-table-column>

                                        <b-table-column field="first_name" label="First Name">
                                            {{ props.row.first_name }}
                                        </b-table-column>

                                        <b-table-column field="last_name" label="Last Name">
                                            {{ props.row.last_name }}
                                        </b-table-column>

                                        <b-table-column field="date" label="Date" centered>
                                <span class="tag is-success">
                                    success
                                </span>
                                        </b-table-column>

                                        <b-table-column label="Gender">
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


                                <b-table
                                    :data="data"
                                    :columns="columns"
                                    class="control"
                                    checkable
                                    :checkbox-position="checkboxPosition">
                                </b-table>

                            </div>
                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->






                </div>
                <!--/list-->

                <router-view></router-view>

            </div>


        </div>

    </div>
</template>


