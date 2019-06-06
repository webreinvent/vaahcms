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

                <div class="card-body" >

                    <table class="table table-striped table-sm table-condensed table-form table-form-dashed">
                        <tbody>

                        <!--dynamic form creator-->
                        <template v-for="column in assets.columns">

                            <tr v-if="column.type == 'text'" >
                                <th width="180" class="text-right">{{column.label}}</th>
                                <td>
                                    <input type="text" class="form-control"
                                           v-model="new_item[column.name]"
                                           :name="column.name"
                                           :placeholder="column.label" />
                                </td>
                            </tr>

                            <tr v-else-if="column.type == 'select'">
                                <th  class="text-right">{{column.label}}</th>
                                <td>

                                    <select class="custom-select" :placeholder="column.label" v-model="new_item[column.name]">
                                        <option selected value="">Select {{column.label}}</option>
                                        <option v-for="input in column.inputs" v-bind:value="input.slug">{{input.name}}</option>
                                    </select>

                                </td>
                            </tr>

                            <tr v-else-if="column.type == 'select_with_ids'">
                                <th  class="text-right">{{column.label}}</th>
                                <td>

                                    <select class="custom-select" :placeholder="column.label"
                                            v-model="new_item[column.name]">
                                        <option selected value="">Select {{column.label}}</option>
                                        <option v-for="input in column.inputs" v-bind:value="input.id">{{input.name}}</option>
                                    </select>

                                </td>
                            </tr>

                            <tr v-else-if="column.type == 'date'">
                                <th class="text-right">{{column.label}}</th>
                                <td>

                                    <datepicker :placeholder="column.label" format="yyyy-MM-dd"
                                                input-class="form-control"
                                                v-model="new_item[column.name]" ></datepicker>

                                </td>
                            </tr>

                        </template>
                        <!--/dynamic form creator-->

                        </tbody>

                    </table>


                </div>

                <div class="card-footer">
                    <button class="btn btn-xs btn-primary" @click="store">Save</button>
                </div>


            </div>


        </div>


</template>
<script src="./RegistrationAddJs.js"></script>