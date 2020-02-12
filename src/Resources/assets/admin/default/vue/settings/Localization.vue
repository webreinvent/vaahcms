<script src="./LocalizationJs.js"></script>
<template>

    <div class="row">

        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-18 flex-grow-1"><strong>Localization</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">

                            <router-link class="btn btn-xs btn-light btn-uppercase"
                                         :to="{ path: '/registrations/create'}">
                                <i class="fas fa-plus"></i> Add Category
                            </router-link>

                            <router-link class="btn btn-xs btn-light btn-uppercase"
                                         :to="{ path: '/registrations/create'}">
                                <i class="fas fa-check"></i> Translation
                            </router-link>

                            <button class="btn btn-xs btn-light btn-uppercase" >
                                <i class="fas fa-sync-alt"></i> Sync
                            </button>

                        </div>
                    </div>

                </div>
                <div class="card-body pd-b-0 " v-if="assets">

                    <div class="form-row">
                        <div class="form-group mg-b-0 col-md-4">
                            <label>Filter By</label>
                            <select v-model="filters.sort_by"
                                    v-on:change="getList"
                                    class="custom-select custom-select-sm">
                                <option value="">Select Sort By</option>
                                <option v-if="assets"
                                        v-for="category in assets.categories"
                                        :value="category">{{category}}</option>
                            </select>

                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group mg-b-0 col-md-4">
                            <label>Add New Category</label>
                            <div class="input-group input-group-sm" style="max-width: 350px;">
                                <input type="text" class="form-control" placeholder="Category Name" />

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" @click="bulkAction"
                                            type="button">Save</button>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">

                        <label>Enable Translations</label>
                        <br clear="all"/>

                        <div class="form-row">


                            <div class="form-group col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="lang-en" >
                                    <label class="custom-control-label"
                                           for="lang-en">English (en)</label>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="lang-es" >
                                    <label class="custom-control-label"
                                           for="lang-es">Spanish (es)</label>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
                <div class="card-body">


                    <div class="row mg-b-10">

                        <div class="col-sm-12">





                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="media align-items-stretch">
                                <ul class="nav nav-tabs flex-column"  role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           data-toggle="tab" href="#tab-lang-en"
                                           role="tab"
                                           aria-selected="true">en</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           data-toggle="tab" href="#tab-lang-es"
                                           role="tab"
                                           aria-selected="true">es</a>
                                    </li>

                                </ul>
                                <div class="media-body">
                                    <div class="tab-content bd bd-gray-300 bd-l-0 pd-t-8  pd-r-20  pd-b-20 pd-l-20" >
                                        <div class="tab-pane fade show active" id="tab-lang-en"
                                             role="tabpanel" aria-labelledby="home-tab4">



                                            <div class="d-flex mg-b-20">

                                                <div class="flex-grow-1 pd-t-5"><h6>English</h6></div>
                                                <div class="">
                                                    <div class="input-group input-group-sm" style="max-width: 350px;">
                                                        <select class="custom-select" v-model="bulk_action" style="max-width: 150px" >
                                                            <option value="">Select Category</option>
                                                            <option value="bulk_change_status">Change Status</option>
                                                            <option value="bulk_delete">Delete</option>
                                                            <option value="bulk_restore">Restore</option>
                                                        </select>
                                                        <select class="custom-select" width="max-width: 150px"
                                                                v-if="bulk_action && bulk_action == 'bulk_change_status'"
                                                                v-model="bulk_action_data">
                                                            <option value="">Select Status</option>
                                                            <option value="activation_pending">Activation Pending</option>
                                                            <option value="registered">Registered</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" @click="bulkAction" type="button">Show</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>





                                            <table class="table table-striped table-form-merge">

                                                <tr>
                                                    <td width="20">
                                                        <button  class="btn btn-xs" style="padding: 0px;">
                                                            <i class="fas fa-copy"> </i>
                                                        </button>
                                                    </td>
                                                    <td width="150">

                                                        <input type="text" class="form-control-merge" placeholder="Type Slug" value="" />

                                                    </td>
                                                    <td >
                                                        <input type="text" class="form-control-merge" placeholder="Type Value" value="" />
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td width="20">
                                                        <a href="#" class="btn btn-xs" style="padding: 0px;">
                                                            <i class="fas fa-copy"> </i>
                                                        </a>
                                                    </td>
                                                    <td>slug</td>
                                                    <td>Text</td>
                                                </tr>

                                            </table>

                                        </div>
                                        <div class="tab-pane fade" id="tab-lang-es"
                                             role="tabpanel" aria-labelledby="profile-tab4">
                                            <h6>ES</h6>
                                            <p class="mg-b-0">Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat.</p>
                                        </div>

                                    </div>
                                </div><!-- media-body -->
                            </div>

                        </div>

                    </div>

                    <table class="table table-striped">

                    </table>

                </div>
                <div class="card-footer" v-if="list && list.last_page > 1">
                    <pagination  :limit="6" :data="list" @pagination-change-page="getList"></pagination>
                </div>

            </div>


        </div>


    </div>

</template>
