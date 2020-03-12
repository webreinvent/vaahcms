<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container">

            <!--header-->


            <!--levels-->
            <div class="level">

                <!--left-->
                <div class="level-left">
                    <div class="level-item">
                        <h2 class="title  is-bottom-marginless">Posts</h2>
                    </div>
                </div>
                <!--/left-->


                <!--right-->
                <div class="level-right">
                    <div class="level-item">
                        <b-button class="is-full-width-mobile" icon-left="plus">
                            Add
                        </b-button>
                    </div>
                </div>
                <!--/right-->

            </div>
            <!--levels-->

            <!--levels-->
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
            <!--levels-->


            <!--levels-->
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
                                <span>All Dates</span>
                                <b-icon icon="caret-down"></b-icon>
                            </button>

                            <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                            <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                        </b-dropdown>
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
            <!--levels-->
            
            <!--/header-->


            <!--body-->
            <div class="columns">
                <div class="column is-12">
                    <b-table
                        :data="data"
                        :columns="columns"
                        class="control"
                        checkable
                        :checkbox-position="checkboxPosition">
                    </b-table>
                </div>
            </div>
            <!--/body-->

            <!--footer-->
            <div class="columns">
                <div class="column is-4">
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
                <div class="column is-6">
                    <b-pagination
                        total="200"
                        range-before="3"
                        range-after="1"
                        order="default"
                        size="default"
                        per-page="10"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                    </b-pagination>
                </div>
                <div class="column is-2 has-text-right">
                    <span>8 items</span>
                </div>
            </div>
            <!--/footer-->


        </div>

    </div>
</template>


