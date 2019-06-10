<template>


    <tbody>

    <template v-for="column in columns">
        <!--dynamic form creator-->
        <tr >
            <th width="180" class="text-right">{{column.label}}</th>
            <td>
                {{column.value}}
            </td>
        </tr>

        <!--/dynamic form creator-->
    </template>

    </tbody>


</template>

<script>



    export default {
        name: "TableViewGenerator",
        props: ['columns'],
        components:{

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

        },
        watch: {
        },
        methods: {
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

