<template>

    <tr>
        <th align="right">{{$vaah.toLabel(label)}}</th>
        <td colspan="2">
            <b-tag v-if="label == 'status' && value == 'active'" type="is-success">
                {{value}}
            </b-tag>
            <b-tag v-else-if="label == 'status' && value != 'active'" type="is-danger">
                {{value}}
            </b-tag>
            <b-tag v-else-if="label == 'is_active' && value == 'Yes'" type="is-success">
                {{value}}
            </b-tag>
            <b-tag v-else="label == 'is_active' && value != 1" type="is-danger">
                {{value}}
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
