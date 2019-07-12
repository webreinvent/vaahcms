<template>
    <div>

        <div class="row">
            <div class="col-sm">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mg-b-0 tx-spacing--1">Themes</h4>
                    </div>
                    <div class="d-none d-md-block">

                        <router-link class="btn btn-sm pd-x-15 btn-primary btn-uppercase"
                                     :to="{ path: '/add'}">
                            <i class="fas fa-plus"></i> Add New
                        </router-link>


                        <button class="btn btn-success btn-sm" v-on:click="getThemesSlugs($event)">
                            <i class="fas fa-sync"></i> Check Updates
                        </button>

                    </div>
                </div>

            </div>

        </div>


        <!--content header-->
        <div class="row mg-b-10 mg-t-10">

            <div class="col-sm  ">

                <div class="bd-b bd-1 pd-b-10">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div>

                        </div>

                        <div class="d-none d-md-block">
                            <div class="search-form">
                                <input type="search" class="form-control" v-model="filters.q"
                                       v-on:keyup.enter="getList()"
                                       placeholder="Search">
                                <button class="btn" v-on:click="getList()" type="button">
                                    <i class="fas fa-search"></i>
                                </button>

                            </div>


                        </div>

                    </div>


                </div>


            </div>

        </div>
        <!--/content header-->


        <!--content body-->

        <div class="row mg-t-10 mg-b-10" v-if="list">

            <div class="col-3 mg-t-10 mg-b-10" v-for="item in list.data" >

                    <div class="card ">
                        <img v-bind:src="item.thumbnail" class="card-img-top" >
                        <div class="card-body">
                            <h6 class="card-title">{{item.title}}</h6>
                            <p class="card-text">
                                <span class="badge badge-light">{{item.name}}/{{item.slug}}</span>
                                <span class="badge badge-light">{{item.version}}</span>
                            </p>
                            <p class="card-text">{{item.excerpt}}</p>




                        </div>

                        <div class="card-footer">

                            <div class="">

                                <a href="#" v-if="item.is_active == 1"
                                   v-on:click="actions($event, 'deactivate', item, null)"
                                   class="mg-r-5 text-warning">Deactivate</a>

                                <a href="#" v-else
                                   v-on:click="actions($event, 'activate', item, null)"
                                   class="mg-r-5">Activate</a>

                                <span v-if="item.is_sample_data_available && item.is_active == 1">

                                <a href="#"
                                   v-on:click="actions($event, 'importSampleData', item, null)"
                                   class="mg-r-5 mg-l-5">Import Sample Data</a>

                                </span>

                                <strong v-if="item.is_update_available">
                                    | <a href="#" v-on:click="installUpdates($event, item.slug)" class="mg-5 text-success">Update</a>
                                </strong>

                                <span v-if="!item.is_active">
                                | <a href="#"
                                     v-on:click="actions($event, 'delete', item, null)"
                                     class="mg-5 text-danger">Delete</a>
                                </span>

                            </div>

                        </div>

                    </div>

            </div>



        </div>

        <div class="row">

            <div class="col">
                <pagination  v-if="list" :limit="6" :data="list" @pagination-change-page="getList"></pagination>
            </div>

        </div>


        <!--/content body-->
    </div>
</template>
<script src="./ThemesInstalledJs.js"></script>