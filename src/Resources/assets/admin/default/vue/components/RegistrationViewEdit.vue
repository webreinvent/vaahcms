<template>


        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-15 flex-grow-1"><strong>Pradeep Kumar</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">


                            <button class="btn btn-card "
                                    @click="toggleEdit">
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
                        <t-view v-if="columns"  :columns="columns" ></t-view>
                    </table>

                    <table v-else class="table table-striped table-sm table-condensed table-form table-form-dashed">
                        <t-form v-if="columns"  :columns="columns" @emittedItem="updateItem" ></t-form>
                    </table>

                </div>


            </div>


        </div>


</template>
<script src="./RegistrationViewEditJs.js"></script>