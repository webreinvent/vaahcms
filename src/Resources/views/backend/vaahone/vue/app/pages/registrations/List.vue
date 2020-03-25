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
                                            <b-field class="control">
                                                <b-input placeholder="Search..."
                                                         type="search"
                                                         v-model="query_string.q"
                                                         @input="delayedSearch"
                                                         icon="search">
                                                </b-input>
                                            </b-field>
                                        </div>

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

                                <!--list-->
                                <div class="block ">

                                    <div class="block" style="margin-bottom: 0px;">

                                        {{page.split_view}}

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


