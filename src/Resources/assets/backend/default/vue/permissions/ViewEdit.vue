<template>


    <div class="col-sm">

        <div class="card">

            <t-loader v-if="!columns"></t-loader>


            <div v-if="columns">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-15 flex-grow-1" >
                            <strong>ID: {{id}}</strong>
                        </div>
                        <div class=" mg-l-auto ">

                            <div class="btn-group btn-group-xs">
                                <button class="btn btn-xs btn-light btn-uppercase "
                                        v-if="edit == true"
                                        @click="store">
                                    <i class="fas fa-check"></i> Save
                                </button>

                                <button class="btn btn-xs btn-light btn-uppercase"
                                        @click="toggleEdit">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <div class="dropdown btn btn-xs btn-light btn-uppercase">
                                    <button class=" btn btn-card  dropdown-toggle"
                                            role="button"
                                            v-on:click="$vaahcms.btDropDown($event)"
                                            data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#" >Send Activation Email</a>
                                        <a class="dropdown-item text-danger" href="#" v-on:click="actions($event, 'delete', {id:id}, {})">Delete</a>
                                    </div>
                                </div>

                            </div>

                            <router-link class="btn btn-card "
                                         :to="{ path: '/users'}">
                                <i class="fas fa-times"></i>
                            </router-link>

                        </div>
                    </div>

                </div>
                <div class="card-body" >

                    <perfect-scrollbar>

                        <div class="alert alert-danger" v-if="getColumnValue('deleted_at')">
                            This record is deleted
                        </div>

                        <table v-if="edit == false" class="table table-striped table-sm table-condensed  table-form table-form-view">
                            <t-view v-if="columns"  :columns="columns" ></t-view>
                        </table>

                        <table v-else class="table table-striped table-sm table-condensed  table-form table-form-dashed">
                            <t-form v-if="columns"  :columns="columns" @eUpdateItem="updateItem" ></t-form>
                        </table>

                    </perfect-scrollbar>

                </div>
            </div>


        </div>


    </div>


</template>
<script src="./ViewEditJs.js"></script>
