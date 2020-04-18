<template>

    <tr>
        <th align="right">{{$vaah.toLabel(label)}}</th>
        <td colspan="2">
            <b-tag v-if="value" type="is-success">
                Yes
            </b-tag>
            <b-tag v-else type="is-danger">
                No
            </b-tag>
        </td>
    </tr>

</template>
<script>

    export default {
        name: "TableTrYesNo",
        props: ['label', 'value'],
        computed: {
        },
        components:{

        },

        data()
        {
            let obj = {

            };

            return obj;
        },
        created() {
        },
        mounted(){

            //---------------------------------------------------------
            //---------------------------------------------------------

        },

        watch: {

        },
        methods: {
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }

</script>
