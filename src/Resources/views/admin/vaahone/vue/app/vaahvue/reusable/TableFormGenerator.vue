<template>


    <tbody>

    <!--dynamic form creator-->
    <template v-for="column in columns" v-if="column.editable == true">

        <tr v-if="column.type == 'text'" :class="column.tr_class" >
            <th width="180" class="text-right">{{column.label}}</th>
            <td>
                <input type="text" class="form-control"
                       v-model="new_item[column.name]"
                       :name="column.name"
                       :disabled="column.disabled"
                       :placeholder="column.label" />
            </td>
        </tr>

        <tr v-else-if="column.type == 'password'" :class="column.tr_class">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <input type="password" class="form-control"
                       v-model="new_item[column.name]"
                       :name="column.name"
                       :placeholder="column.label" />

            </td>
        </tr>

        <tr v-else-if="column.type == 'textarea'" :class="column.tr_class">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <textarea type="password" class="form-control"
                          v-model="new_item[column.name]"
                          :name="column.name"
                          :placeholder="column.label"></textarea>

            </td>
        </tr>

        <tr v-else-if="column.type == 'select'" :class="column.tr_class">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <select class="custom-select" :placeholder="column.label" v-model="new_item[column.name]">
                    <option >Select {{column.label}}</option>
                    <option v-for="input in column.inputs" v-bind:value="input.slug">{{input.name}}</option>
                </select>

            </td>
        </tr>

        <tr v-else-if="column.type == 'select_with_ids'" :class="column.tr_class">
            <th  class="text-right">{{column.label}}</th>
            <td>

                <select class="custom-select" :placeholder="column.label"
                        v-model="new_item[column.name]">
                    <option value="">Select {{column.label}}</option>
                    <option v-for="input in column.inputs" v-bind:value="input.id">{{input.name}}</option>
                </select>

            </td>
        </tr>

        <tr v-else-if="column.type == 'date'" :class="column.tr_class">
            <th class="text-right">{{column.label}}</th>
            <td>

                <datepicker :placeholder="column.label" format="yyyy-MM-dd"
                            input-class="form-control"
                            v-model="new_item[column.name]" ></datepicker>

            </td>
        </tr>

    </template>

    </tbody>
    <!--/dynamic form creator-->

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
                new_item: null
            };

            return obj;
        },

        created() {
            this.mapValues();
        },
        watch: {
            'new_item': {
                handler: function (newVal) {

                    console.log('test-->', newVal);

                    this.emitItem();
                },
                deep: true
            }
        },
        methods: {
            //---------------------------------------------------------------------
            mapValues: function()
            {
                var new_item = {};
                var columns = this.columns;

                columns.map(function(item, key) {
                    if(item.value)
                    {
                        new_item[item.name] = item.value;
                    }
                });

                this.new_item = new_item;
            },
            //---------------------------------------------------------------------
            emitItem: function () {
                this.$root.$emit('emitUpdatedItemEvent', this.new_item);
            },
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

