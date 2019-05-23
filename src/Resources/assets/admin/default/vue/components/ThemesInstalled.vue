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


                        <button class="btn btn-success btn-sm" v-on:click="getModulesSlugs($event)">
                            <i class="fas fa-sync"></i> Check Updates
                        </button>

                    </div>
                </div>

            </div>

        </div>



        <!--content body-->

        <div class="row mg-t-10 mg-b-10">
            <div class="col-sm">
                <table class="table bg-white" v-if="list">
                    <thead class="thead-light">
                    <tr class="bd-l bd-3" >
                        <th scope="col">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                <label class="custom-control-label" for="selectAll"></label>
                            </div>

                        </th>
                        <th scope="col">Module Name</th>
                        <th scope="col">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  v-for="item in list.data"
                         class="bd-l bd-3"
                         v-bind:class="{'bd-success bg-success-9': item.is_active == 1}">
                        <th scope="row">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>

                        </th>
                        <td>
                            <strong>{{item.name}}</strong><br/>

                            <a href="#" v-if="item.is_active == 1"
                               v-on:click="actions($event, 'deactivate', item, null)"
                               class="mg-r-5 text-warning">Deactivate</a>

                            <a href="#" v-else
                               v-on:click="actions($event, 'activate', item, null)"
                               class="mg-r-5">Activate</a>

                            <span v-if="item.is_sample_data_available && item.is_active == 1">
                            |
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

                        </td>
                        <td>
                            <strong v-if="item.title">
                                {{item.title}}<br/>
                            </strong>
                            <span v-if="item.excerpt">
                                {{item.excerpt}}
                            </span>
                            <br/>
                            <span class="badge badge-light">Version: {{item.version}}</span>
                            | By <a :href="item.author_website" target="_blank"
                                    class="mg-5">{{item.author_name}}</a>
                            | <a :href="item.github_url" target="_blank" class="mg-5">View Details</a>
                        </td>

                    </tr>



                    </tbody>
                </table>
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
<script src="./ModulesInstalledJs.js"></script>