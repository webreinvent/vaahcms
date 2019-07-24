<template>


        <div class="col-sm">

            <div class="card" >

                <div if="!list">
                    <t-loader v-if="!list"></t-loader>


                    <div class="card-header" >

                        <div class="d-flex" v-if="item">
                            <div class="align-self-center tx-15 flex-grow-1">
                                <strong>{{item.name}} > Permissions
                                </strong>
                            </div>
                            <div class=" mg-l-auto btn-group btn-group-xs">

                                <router-link class="btn btn-card "
                                        :to="{ path: '/roles'}">
                                    <i class="fas fa-times"></i>
                                </router-link>

                            </div>
                        </div>

                    </div>

                    <div class="card-body" v-if="list" >

                        <div class="form-group">
                            <input type="text" class="form-control" v-model="filters.q"
                                   v-on:keyup.enter="getList(1)"
                                   placeholder="Search Roles">
                        </div>

                        <table class="table table-striped table-sm table-condensed  table-form table-form-view">

                            <thead>
                            <th>Role</th>
                            <th width="120">Has Permission</th>
                            </thead>
                            <tbody>
                            <tr v-for="item in list.data">
                                <td>{{item.name}}</td>
                                <td v-if="id != 1">

                                    <button v-if="item.pivot.is_active == 1"
                                            @click="toggleActiveStatus(item)"
                                            class="btn btn-tiny btn-success">
                                        Yes
                                    </button>

                                    <button v-else
                                            @click="toggleActiveStatus(item)"
                                            class="btn btn-tiny btn-danger">
                                        No
                                    </button>


                                </td>

                                <td v-else>
                                    <button class="btn btn-tiny btn-secondary">
                                        Yes
                                    </button>
                                </td>

                            </tr>
                            </tbody>

                        </table>



                    </div>

                    <div class="card-footer" v-if="list && list.last_page > 1">
                        <pagination  :limit="6" :data="list" @pagination-change-page="getList"></pagination>
                    </div>

                </div>

            </div>


        </div>


</template>
<script src="./PermissionsJs.js"></script>