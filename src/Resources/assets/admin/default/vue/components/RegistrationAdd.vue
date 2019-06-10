<template>


        <div class="col-sm">

            <div class="card" v-if="assets">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-15 flex-grow-1"><strong>Add New Registration</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">

                            <router-link class="btn btn-card "
                                    :to="{ path: '/'}">
                                <i class="fas fa-times"></i>
                            </router-link>

                        </div>
                    </div>

                </div>

                <t-form :columns="assets.columns" @storeItem="store" ></t-form>

            </div>


        </div>


</template>
<script src="./RegistrationAddJs.js"></script>