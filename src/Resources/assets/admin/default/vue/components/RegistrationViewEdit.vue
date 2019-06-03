<template>


        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-15 flex-grow-1"><strong>Pradeep Kumar</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">


                            <button class="btn btn-card "
                                    @click="toggleEditing">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <router-link class="btn btn-card "
                                    :to="{ path: '/add'}">
                                <i class="fas fa-ellipsis-h"></i>
                            </router-link>


                            <router-link class="btn btn-card "
                                    :to="{ path: '/'}">
                                <i class="fas fa-times"></i>
                            </router-link>

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <table v-if="edit == false" class="table table-striped table-sm table-condensed table-form">
                        <tbody>
                        <tr>
                            <th width="150" class="text-right">First Name</th>
                            <td><span>Pradeep</span></td>
                        </tr>

                        <tr>
                            <th class="text-right">Last Name</th>
                            <td><span>Kumar</span></td>
                        </tr>

                        <tr>
                            <th class="text-right">Registered At</th>
                            <td><span>25 Dec, 2019</span></td>
                        </tr>
                        </tbody>
                    </table>

                    <table v-else class="table table-striped table-sm table-condensed table-form table-form-dashed">
                        <tbody>
                        <tr>
                            <th width="150" class="text-right">First Name</th>
                            <td>
                                <input class="form-control" value="Pradeep" placeholder="First Name" />
                            </td>
                        </tr>

                        <tr>
                            <th width="150" class="text-right">Last Name</th>
                            <td>
                                <input class="form-control" placeholder="Last Name" />
                            </td>
                        </tr>

                        <tr>
                            <th class="text-right">Registered At</th>
                            <td>

                                <select class="custom-select">
                                    <option>Jan</option>
                                    <option>Feb</option>
                                </select>

                            </td>
                        </tr>
                        </tbody>

                    </table>


                </div>


            </div>


        </div>


</template>
<script src="./RegistrationViewEditJs.js"></script>