@extends("vaahcms::admin.default.layouts.app")

@section('vaahcms_extend_admin_css')

@endsection


@section('vaahcms_extend_admin_js')

@endsection

@section('content')

    <div id="vh-app">


        <!--app nav-->
        <nav class="navbar navbar-expand-lg navbar-app navbar-light">

            <a class="navbar-brand tx-bold tx-spacing--2" href="#">VAAH</a>

            <button class="navbar-toggler order-2" type="button" data-toggle="collapse"
                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <i data-feather="menu" class="wd-20 ht-20"></i>
            </button>

            <div class="collapse navbar-collapse order-2 " id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Registrations</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Role</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Permissions</a>
                    </li>
                    <li class="nav-item nav-separator"></li>

                    <li class="nav-item active">
                        <a class="nav-link" href="#">Permissions</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>

                </ul>



            </div>
        </nav>
        <!--/app nav-->

        <div class="content-body">
        <div class="row">

            <div class="col-sm mg-b-10">

                <div class="card">
                    <div class="card-header">

                        <div class="d-flex">
                            <div class="align-self-center tx-18 flex-grow-1">
                                <strong>Roles
                                    <span v-if="list">
                                    (2)
                                </span>
                                </strong>
                            </div>
                            <div class=" mg-l-auto btn-group btn-group-xs">

                                <a href="#" class="btn btn-xs btn-light btn-uppercase">
                                    <i class="fas fa-plus"></i> Add New
                                </a>

                                <button class="btn btn-xs btn-light btn-uppercase" @click="toggleShowFilters">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>

                                <button class="btn btn-xs btn-light btn-uppercase" @click="reloadList">
                                    <i class="fas fa-sync-alt"></i>
                                </button>

                            </div>
                        </div>

                    </div>
                    <div class="card-body pd-b-0 " v-if="show_filters">

                        <div class="form-row">
                            <div class="form-group mg-b-0 col-md-4">
                                <label>Filter By</label>
                                <select class="custom-select custom-select-sm">
                                    <option value="">Select Sort By</option>
                                    <option value="first_name">First Name</option>
                                    <option value="status">Status</option>
                                    <option value="created_at">Created At</option>
                                    <option value="deleted_at">Show Deleted</option>
                                </select>

                            </div>

                        </div>

                    </div>
                    <div class="card-body">


                        <div class="row mg-b-10">

                            <div class="col-sm-12">


                                <div class="input-group input-group-sm" style="max-width: 350px;">
                                    <select class="custom-select" style="max-width: 150px" >
                                        <option value="">Bulk Actions</option>
                                        <option value="bulk_change_status">Change Status</option>
                                        <option value="bulk_delete">Delete</option>
                                        <option value="bulk_restore">Restore</option>
                                    </select>
                                    <select class="custom-select" width="max-width: 150px">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" @click="bulkAction" type="button">Apply</button>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <table  class="table table-striped table-sm table-condensed table-sortable mg-b-0">

                            <thead>

                            <tr>
                                <th width="20">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"  id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="sortable asc"
                                    width="50">
                                    ID
                                </th>
                                <th class="sortable desc"
                                    width="150">
                                    Name
                                </th>
                                <th>Slug</th>
                                <th >Is Active
                                </th>
                                <th width="80" >Users</th>
                                <th width="80" >Permissions</th>
                                <th width="140" >Created At</th>
                                <th width="80"></th>
                            </tr>

                            </thead>

                            <tbody>


                            <tr>



                                <td colspan="9" class="pd-0-f" >

                                    <div class="search-form table-search">
                                        <input type="search" class="form-control form-control-sm"
                                               placeholder="search by id, name, slug...">
                                        <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                    </div>


                                </td>

                            </tr>

                            <tr  >
                                <td>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label" ></label>
                                    </div>

                                </td>
                                <td>12</td>
                                <td>Name</td>
                                <td>Slug</td>
                                <td>


                                    <button class="btn btn-tiny btn-success">
                                        Yes
                                    </button>


                                </td>

                                <td >

                                    <a href="#" class="btn btn-tiny btn-primary">
                                        3
                                    </a>

                                </td>
                                <td >
                                    <a href="#" class="btn btn-tiny btn-primary">
                                        3
                                    </a>

                                </td>

                                <td >
                                    2012-02-02
                                </td>


                                <td class="pd-0-f">
                                    <div class="btn-group btn-group-xs">

                                        <button class="btn btn-xs bg-transparent">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>

                                        <button class="btn btn-xs bg-transparent">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                            </tbody>

                        </table>

                    </div>
                    <div class="card-footer" >
                        footer
                    </div>

                </div>


            </div>

        </div>
        </div>



    </div>

@endsection
