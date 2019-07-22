<template>
    <div class="row">

        <div class="col-sm mg-b-10">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-18 flex-grow-1">
                            <strong>Roles
                                <span v-if="list">
                                    ({{list.total}})
                                </span>
                            </strong>
                        </div>
                        <div class=" mg-l-auto btn-group btn-group-xs">

                            <router-link class="btn btn-xs btn-light btn-uppercase"
                                         :to="{ path: '/roles/create'}">
                                <i class="fas fa-plus"></i> Add New
                            </router-link>

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
                            <select v-model="filters.sort_by"
                                    v-on:change="getList"
                                    class="custom-select custom-select-sm">
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
                                <select class="custom-select" v-model="bulk_action" style="max-width: 150px" >
                                    <option value="">Bulk Actions</option>
                                    <option value="bulk_change_status">Change Status</option>
                                    <option value="bulk_delete">Delete</option>
                                    <option value="bulk_restore">Restore</option>
                                </select>
                                <select class="custom-select" width="max-width: 150px"
                                        v-if="bulk_action && bulk_action == 'bulk_change_status'"
                                v-model="bulk_action_data">
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

                    <t-loader v-if="!list"></t-loader>

                    <table v-if="list" class="table table-striped table-sm table-condensed table-sortable mg-b-0">

                        <thead>

                            <tr>
                                <th width="20">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" v-on:click="toggleSelectAll" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="sortable"
                                    width="50"
                                    v-bind:class="{
                                    'asc': filters.sort_by === 'id' && filters.sort_type === 'asc',
                                    'desc': filters.sort_by === 'id' && filters.sort_type === 'desc',
                                     }"
                                    v-on:click="setSorting('id')">
                                    ID
                                </th>
                                <th class="sortable"
                                    width="150"
                                    v-bind:class="{
                                    'asc': filters.sort_by === 'first_name' && filters.sort_type === 'asc',
                                    'desc': filters.sort_by === 'first_name' && filters.sort_type === 'desc',
                                     }"
                                    v-on:click="setSorting('first_name')">
                                    Name
                                </th>
                                <th>Slug</th>
                                <th class="sortable"
                                    width="80"
                                    v-bind:class="{
                                    'asc': filters.sort_by === 'is_active' && filters.sort_type === 'asc',
                                    'desc': filters.sort_by === 'is_active' && filters.sort_type === 'desc',
                                     }"
                                    v-on:click="setSorting('is_active')">Is Active
                                </th>
                                <th width="80" >Users</th>
                                <th width="80" >Permissions</th>
                                <th v-if="!table_collapsed" width="140" >Created At</th>
                                <th width="80"></th>
                            </tr>

                        </thead>

                        <tbody>


                        <tr>



                            <td colspan="9" class="pd-0-f" >

                                <div class="search-form table-search">
                                    <input type="search" class="form-control form-control-sm"
                                           v-model="filters.q"
                                           v-on:keyup.enter="getList"
                                           placeholder="search by id, name, slug...">
                                    <button class="btn " @click="getList"
                                            type="button"><i class="fas fa-search"></i></button>
                                </div>


                            </td>

                        </tr>


                        <template  v-for="item in list.data">
                        <tr :class="{'tr-active': item.id == active_item.id}"  >
                            <td>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           :checked="$vaahcms.existInArray(selected_items, item.id)"
                                           @click="toggleSelectedItem(item.id)"
                                           :id="'check-'+item.id">
                                    <label class="custom-control-label" :for="'check-'+item.id"></label>
                                </div>

                            </td>
                            <td>{{item.id}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.slug}}</td>
                            <td>


                                <button v-if="item.is_active == 1"
                                        @click="changeActiveStatus(item)"
                                        class="btn btn-tiny btn-success">
                                    Yes
                                </button>

                                <button v-else
                                        @click="changeActiveStatus(item)"
                                        class="btn btn-tiny btn-danger">
                                    No
                                </button>

                            </td>

                            <td >

                                <router-link class="btn btn-tiny btn-primary"
                                             :to="{ path: '/roles/users/'+item.id}">
                                    {{item.count_users}}
                                </router-link>

                            </td>
                            <td >
                                <router-link class="btn btn-tiny btn-primary"
                                             :to="{ path: '/roles/permissions/'+item.id}">
                                    {{item.count_permissions}}
                                </router-link>

                            </td>

                            <td v-if="!table_collapsed">
                                {{$vaahcms.dateTimeForHumans(item.created_at)}}
                            </td>


                            <td class="pd-0-f">
                                <div class="btn-group btn-group-xs">

                                    <button class="btn btn-xs bg-transparent">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>

                                    <router-link class="btn btn-xs bg-transparent"
                                                 :to="{ path: '/roles/view/'+item.id}">
                                        <i class="fas fa-chevron-right"></i>
                                    </router-link>

                                </div>
                            </td>
                        </tr>
                        </template>

                        </tbody>

                    </table>

                </div>
                <div class="card-footer" v-if="list && list.last_page > 1">
                    <pagination  :limit="6" :data="list" @pagination-change-page="getList"></pagination>
                </div>

            </div>


        </div>

        <router-view></router-view>

    </div>

</template>
<script src="./ListJs.js"></script>