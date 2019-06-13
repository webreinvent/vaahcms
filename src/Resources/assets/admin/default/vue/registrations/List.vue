<template>


        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-18 flex-grow-1"><strong>Registrations</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">

                            <router-link class="btn btn-xs btn-light btn-uppercase"
                                         :to="{ path: '/create'}">
                                <i class="fas fa-plus"></i> Add New
                            </router-link>

                            <button class="btn btn-xs btn-light btn-uppercase" @click="toggleShowFilters">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>

                        </div>
                    </div>

                </div>
                <div class="card-body pd-b-0 " v-if="show_filters">

                    <div class="form-row">
                        <div class="form-group mg-b-0 col-md-4">
                            <label>Filter By</label>
                            <select v-model="filters.sort_by" class="custom-select custom-select-sm">
                                <option value="first_name">First Name</option>
                                <option value="status">Status</option>
                                <option value="created_at">Created At</option>
                                <option value="created_by">Deleted At</option>
                            </select>

                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <table v-if="list" class="table table-striped table-sm table-condensed table-sortable">

                        <thead>

                            <tr>
                                <th class="sortable"
                                    width="80"
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
                                <th class="sortable"
                                    v-bind:class="{
                                    'asc': filters.sort_by === 'email' && filters.sort_type === 'asc',
                                    'desc': filters.sort_by === 'email' && filters.sort_type === 'desc',
                                     }"
                                    v-on:click="setSorting('email')">Email

                                </th>
                                <th class="sortable"
                                    width="120"
                                    v-bind:class="{
                                    'asc': filters.sort_by === 'status' && filters.sort_type === 'asc',
                                    'desc': filters.sort_by === 'status' && filters.sort_type === 'desc',
                                     }"
                                    v-on:click="setSorting('status')">Status
                                </th>
                                <th v-if="!table_collapsed" width="180" >Created At</th>
                                <th width="80"></th>

                            </tr>

                        </thead>

                        <tbody>


                        <tr >

                            <td colspan="6" class="pd-0-f" >

                                <div class="search-form table-search">
                                    <input type="search" class="form-control form-control-sm"
                                           v-model="filters.q"
                                           v-on:keyup.enter="getList"
                                           placeholder="search by id, name, username, email...">
                                    <button class="btn " @click="getList"
                                            type="button"><i class="fas fa-search"></i></button>
                                </div>


                            </td>

                        </tr>

                        <tr  v-for="item in list.data">
                            <td>{{item.id}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.email}}</td>
                            <td>

                                <span class="badge badge-info">{{item.status}}</span>

                            </td>
                            <td v-if="!table_collapsed">
                                {{$helpers.dateTimeForHumans(item.created_at)}}
                            </td>
                            <td class="pd-0-f">
                                <div class="btn-group btn-group-xs">

                                    <button class="btn btn-xs bg-transparent">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>

                                    <router-link class="btn btn-xs bg-transparent"
                                                 :to="{ path: '/view/'+item.id}">
                                        <i class="fas fa-chevron-right"></i>
                                    </router-link>

                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>

                </div>
                <div class="card-footer" v-if="list">
                    <pagination  :limit="6" :data="list" @pagination-change-page="getList"></pagination>
                </div>

            </div>


        </div>


</template>
<script src="./ListJs.js"></script>