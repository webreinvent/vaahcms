<template>
    <div>

        <div class="row">
            <div class="col-sm">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mg-b-0 tx-spacing--1">Add Modules</h4>
                    </div>

                    <div class="d-flex flex-row-reverse">

                        <div >


                            <router-link class="btn btn-sm pd-x-15 btn-primary btn-uppercase"
                                         :to="{ path: '/modules'}">
                                <i class="fas fa-upload"></i> Upload
                            </router-link>

                            <router-link class="btn btn-sm pd-x-15 btn-light btn-uppercase"
                                         :to="{ path: '/modules'}">
                                <i class="fas fa-arrow-left"></i> Back
                            </router-link>

                        </div>

                        <div class="mg-r-10" >

                            <div class="search-form input-group-sm">
                                <input type="search" class="form-control" v-model="filters.q"
                                       v-on:keyup.enter="getModules()"
                                       placeholder="Search">
                                <button class="btn" v-on:click="getModules()" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>



                        </div>


                    </div>

                </div>

            </div>

        </div>



        <!--content body-->

        <div class="row" v-if="!list">
            <div class="col">
                <t-loader></t-loader>
            </div>
        </div>

        <div class="row mg-t-10 mg-b-10" v-if="list">
            <div class="col-sm-6" v-for="item in list.data" >

                <div class="card">
                    <div class="card-body">

                        <div class="media">
                            <img :src="item.thumbnail" class="wd-200  mg-r-20" alt="">
                            <div class="media-body">

                                <div class="row">

                                    <div class="col-sm-12">
                                        <h5 class="mg-b-15 tx-inverse">{{item.title}}</h5>

                                        <p>{{item.excerpt}}</p>

                                        <p>

                                            <button type="button" v-on:click="download($event, item)"
                                                    class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </button>

                                            <button type="button" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-sync"></i> Update
                                            </button>


                                        </p>

                                        <p class="mg-b-0">
                                            <a href="#">More Details </a>

                                            | By <a target="_blank" :href="item.author_website">{{item.author_name}}</a>
                                        </p>

                                    </div>


                                </div>

                            </div>

                        </div>


                    </div>

                    <div class="card-footer">

                        <div class="progress mg-b-10 hide">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated wd-100p"
                                 role="progressbar"></div>
                        </div>

                        <div class="row">
                            <div class="col" v-if="item.downloads">
                                {{item.downloads}}+ Active Installs
                            </div>

                            <div class="col text-right">
                                Last Updated: {{item.updated_at}}
                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>

        <div class="row">

            <div class="col">
                <pagination  v-if="list" :limit="6" :data="list" @pagination-change-page="getModules"></pagination>
            </div>

        </div>

        <!--/content body-->

    </div>
</template>
<script src="./AddJs.js"></script>