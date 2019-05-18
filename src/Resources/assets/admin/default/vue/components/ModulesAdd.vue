<template>
    <div>

        <div class="row">
            <div class="col-sm">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mg-b-0 tx-spacing--1">Add Modules</h4>
                    </div>
                    <div class="d-none d-md-block">

                        <router-link class="btn btn-sm pd-x-15 btn-light btn-uppercase"
                                     :to="{ path: '/'}">
                            Back
                        </router-link>

                    </div>


                </div>

            </div>

        </div>



        <!--content body-->


        <div class="row mg-t-10">
            <div class="col-sm-6">


                <div class="card">



                    <div class="card-body">

                        <div class="media">
                            <img src="http://themepixels.me/dashforge/assets/img/placehold.jpg" class="wd-200  mg-r-20" alt="">
                            <div class="media-body">

                                <div class="row">

                                    <div class="col-sm-12">
                                        <h5 class="mg-b-15 tx-inverse">Pods – Custom Content Types and Fields</h5>

                                        <p>Pods is a framework for creating, managing, and deploying customized content types and fields.</p>

                                        <p>

                                        <button type="button" class="btn btn-outline-primary">
                                            <i data-feather="download"></i> Download
                                        </button>
                                        <button type="button" class="btn btn-outline-info">
                                            <i data-feather="refresh-ccw"></i> Update
                                        </button>


                                        </p>

                                        <p class="pd-b-0">
                                            <a href="#">More Details </a>

                                            | By <a href="#">Pods Framework Team</a>
                                        </p>

                                    </div>


                                </div>

                            </div>

                        </div>


                    </div>

                    <div class="card-footer">

                        <div class="row">
                            <div class="col">
                                70,000+ Active Installs
                            </div>

                            <div class="col text-right">
                                Last Updated: 5 months ago
                            </div>

                        </div>


                    </div>

                </div>



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