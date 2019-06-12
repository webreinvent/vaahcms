<template>


        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-18 flex-grow-1"><strong>Registrations</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">

                            <router-link class="btn btn-xs btn-light btn-uppercase"
                                         :to="{ path: '/add'}">
                                <i class="fas fa-plus"></i> Add New
                            </router-link>

                            <button class="btn btn-xs btn-light btn-uppercase"
                                    :to="{ path: '/add'}">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>

                        </div>
                    </div>

                </div>
                <div class="card-body pd-b-0 ">

                    <div class="form-row">
                        <div class="form-group mg-b-0 col-md-4">
                            <label>Filter By</label>
                            <select class="custom-select custom-select-sm">
                                <option>First Name</option>
                                <option>Last Name</option>
                                <option>Status</option>
                                <option>Created At</option>
                                <option>Deleted At</option>
                            </select>

                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <table class="table table-striped table-sm table-condensed">

                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Status</td>
                            <td></td>
                            <td width="80"></td>

                        </tr>

                        <tr >
                            <td colspan="5" class="pd-0-f" >

                                <div class="search-form table-search">
                                    <input type="search" class="form-control form-control-sm"
                                           placeholder="search by name, username, email...">
                                    <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                </div>



                            </td>

                        </tr>

                        <tr>
                            <td>Pradeep Kumar</td>
                            <td>webreinvent@gmail.com</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                Dec 6, 2018
                            </td>
                            <td class="pd-0-f">
                                <div class="btn-group btn-group-xs">

                                    <button class="btn btn-xs bg-transparent">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>

                                    <router-link class="btn btn-xs bg-transparent"
                                                 :to="{ path: '/view/6'}">
                                        <i class="fas fa-chevron-right"></i>
                                    </router-link>

                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>

                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mg-b-0">
                            <li class="page-item disabled"><a class="page-link page-link-icon" href="#"><i data-feather="chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link page-link-icon" href="#"><i data-feather="chevron-right"></i></a></li>
                        </ul>
                    </nav>
                </div>

            </div>


        </div>


</template>
<script src="./ListJs.js"></script>