<template>


    <tbody>

    <template v-for="column in columns" >
        <!--dynamic form creator-->
        <tr v-if="column.type == 'text'" class="tr__view" >
            <th width="180" class="text-right">{{column.label}}</th>
            <td>
                <input type="text" class="form-control"
                       v-model="new_item[column.name]"
                       :name="column.name"
                       disabled
                       :placeholder="column.label" />
            </td>
        </tr>

        <tr v-else-if="column.type == 'password'" class="tr__view">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <input type="password" class="form-control"
                       disabled
                       v-model="new_item[column.name]"
                       :name="column.name"
                       :placeholder="column.label" />

            </td>
        </tr>

        <tr v-else-if="column.type == 'textarea'" class="tr__view">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <div v-html="new_item[column.name]"></div>

            </td>
        </tr>

        <tr v-else-if="column.type == 'select'" class="tr__view">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <select class="custom-select" disabled :placeholder="column.label" v-model="new_item[column.name]">
                    <option selected value="">Select {{column.label}}</option>
                    <option v-for="input in column.inputs" v-bind:value="input.slug">{{input.name}}</option>
                </select>

            </td>
        </tr>

        <tr v-else-if="column.type == 'select_with_ids'" class="tr__view">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <select class="custom-select" disabled :placeholder="column.label"
                        v-model="new_item[column.name]">
                    <option selected value="">Select {{column.label}}</option>
                    <option v-for="input in column.inputs" v-bind:value="input.id">{{input.name}}</option>
                </select>

            </td>
        </tr>

        <tr v-else-if="column.type == 'date'" class="tr__view">
            <th class="text-right">{{column.label}}</th>
            <td>

                <datepicker :placeholder="column.label"
                            disabled
                            format="yyyy-MM-dd"
                            input-class="form-control"
                            v-model="new_item[column.name]" ></datepicker>

            </td>
        </tr>
        <!--/dynamic form creator-->
    </template>

    </tbody>


</template>

<script>

    //https://www.npmjs.com/package/vuejs-datepicker
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: "TableViewGenerator",
        props: ['columns'],
        components:{
            'datepicker': Datepicker,
        },
        data()
        {
            let obj = {
                new_item: {
                }
            };

            return obj;
        },
        created() {
            this.mapValues();
        },
        watch: {
        },
        methods: {
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            mapValues: function()
            {
                var self = this;
                var columns = this.columns;

                columns.map(function(item, key) {
                    if(item.value)
                    {
                        self.new_item[item.name] = item.value;
                    }
                });
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

