<template>

    <tr>
        <th align="right">{{$vaah.toLabel(label)}}</th>
        <td colspan="2">
            <b-tag v-if="value">
                {{value.name}}
            </b-tag>
        </td>
    </tr>

</template>
<script>

    export default {
        name: "TableTrActedBy",
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
