<template>
    <div>

        <div class="row">
            <div class="col-sm">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mg-b-0 tx-spacing--1">Modules</h4>
                    </div>
                    <div class="d-none d-md-block">

                        <router-link class="btn btn-sm pd-x-15 btn-primary btn-uppercase"
                                     :to="{ path: '/add'}">
                            <i data-feather="plus"></i> Add New
                        </router-link>

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
                            <nav class="nav">
                                <a href="" class="nav-link pd-l-0">All (30)</a>
                                <a href="" class="nav-link active">Active (20)</a>
                                <a href="" class="nav-link">Inactive (11)</a>
                                <a href="" class="nav-link">Updates Available (0)</a>

                            </nav>
                        </div>

                        <div class="d-none d-md-block">
                            <div class="search-form">
                                <input type="search" class="form-control" placeholder="Search">
                                <button class="btn" type="button"><i data-feather="search"></i></button>
                            </div>
                        </div>

                    </div>


                </div>


            </div>

        </div>
        <!--/content header-->

        <!--content body-->

        <div class="row">

            <div class="col-sm-3">


                <div class="input-group input-group-sm">
                    <select class="custom-select" id="inputGroupSelect04">
                        <option selected>Bulk Actions</option>
                        <option >Activate</option>
                        <option value="1">Deactivate</option>
                        <option value="2">Update</option>
                        <option value="3">Delete</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">Apply</button>
                    </div>
                </div>





            </div>

        </div>

        <div class="row mg-t-10">
            <div class="col-sm">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
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
                    <tr>
                        <th scope="row">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>

                        </th>
                        <td>
                            <strong>.PHP on PAGES</strong><br/>

                            <a href="#" class="mg-r-5">Deactivate</a>
                            | <a href="#" class="mg-5">Edit</a>
                            | <a href="#" class="mg-5">Settings</a>

                        </td>
                        <td>
                            Adds .PHP to pages. you can follow us on twitter @wphelpline

                            <br/>
                            <span class="badge badge-light">Version 1.0.2</span>
                            | By <a href="#" class="mg-5">WebReinvent</a>
                            | <a href="#" class="mg-5">View Details</a>
                        </td>

                    </tr>

                    <tr>
                        <th scope="row">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>

                        </th>
                        <td>
                            <strong>.PHP on PAGES</strong><br/>

                            <a href="#" class="mg-r-5">Deactivate</a>
                            | <a href="#" class="mg-5">Edit</a>
                            | <a href="#" class="mg-5">Settings</a>

                        </td>
                        <td>
                            Adds .PHP to pages. you can follow us on twitter @wphelpline

                            <br/>
                            <span class="badge badge-light">Version 1.0.2</span>
                            | By <a href="#" class="mg-5">WebReinvent</a>
                            | <a href="#" class="mg-5">View Details</a>
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!--/content body-->
    </div>
</template>
<script>

    export default {

        props: [],
        components:{

        },
        data()
        {
            let obj = {
                urls:{
                    current: window.location.href,
                },
            };

            return obj;
        },
        watch: {



        },
        mounted() {

            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

        },
        methods: {
            //---------------------------------------------------------------------


            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }
</script>