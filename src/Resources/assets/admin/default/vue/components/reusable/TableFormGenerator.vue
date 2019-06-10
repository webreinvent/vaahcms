<template>

    <div>

    <div class="card-body" >

        <table class="table table-striped table-sm table-condensed table-form table-form-dashed">
            <tbody>

            <!--dynamic form creator-->
            <template v-for="column in columns">

                <tr v-if="column.type == 'text'" >
                    <th width="180" class="text-right">{{column.label}}</th>
                    <td>
                        <input type="text" class="form-control"
                               v-model="new_item[column.name]"
                               :name="column.name"
                               :placeholder="column.label" />
                    </td>
                </tr>

                <tr v-else-if="column.type == 'password'">
                    <th  class="text-right">{{column.label}}</th>
                    <td>

                        <input type="password" class="form-control"
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
        <button class="btn btn-xs btn-primary" @click="emitStore">Save</button>
    </div>





    </div>

</template>

<script>

    //https://www.npmjs.com/package/vuejs-datepicker
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: "TableFormGenerator",
        props: ['columns'],
        components:{
            'datepicker': Datepicker,
        },
        data()
        {
            let obj = {
                new_item: {
                    title: "",
                    country: "",
                    status: "",
                    gender: "",
                    timezone: "",
                    country_calling_code: "",
                    invited_by: "",
                    user_id: "",
                }
            };

            return obj;
        },

        created() {
            this.mapValues();
        },
        methods: {
            //---------------------------------------------------------------------
            mapValues: function()
            {
                var self = this;
                var columns = this.columns;
                /*columns.map(function (item) {
                    self.new_item[item.name] = item.value;
                });
                */
                this.$helpers.console(columns, 'columns-->');

                /*columns.each(function (item) {
                    self.$helpers.console(item);

                })*/

                columns.map(function(item, key) {
                    console.log(item);
                    self.new_item[item.name] = item.value;
                });



            },
            //---------------------------------------------------------------------
            emitStore: function () {
                this.$emit('storeItem', this.new_item);
            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

