<template>


        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-15 flex-grow-1" >
                            <strong>ID: {{id}}</strong>
                        </div>
                        <div class=" mg-l-auto btn-group btn-group-xs">


                            <button class="btn btn-card "
                                    @click="toggleEdit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <div class="dropdown">
                                <a class="btn btn-card dropdown-toggle"
                                   href="#" role="button"
                                   v-on:click="$vaahcms.btDropDown($event)"
                                   data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">Send Activation Email</a>
                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                            </div>

                            <router-link class="btn btn-card "
                                    :to="{ path: '/registrations'}">
                                <i class="fas fa-times"></i>
                            </router-link>

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <table v-if="edit == false" class="table table-striped table-sm table-condensed  table-form table-form-view">
                        <t-view v-if="columns"  :columns="columns" ></t-view>
                    </table>

                    <table v-else class="table table-striped table-sm table-condensed  table-form table-form-dashed">
                        <t-form v-if="columns"  :columns="columns" @emittedItem="updateItem" ></t-form>
                    </table>

                </div>

                <div v-if="edit == true" class="card-footer">

                    <button @click="store" class="btn btn-primary">Save</button>

                </div>


            </div>


        </div>


</template>
<script src="./ViewEditJs.js"></script>