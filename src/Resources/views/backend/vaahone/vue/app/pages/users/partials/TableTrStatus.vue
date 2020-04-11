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
            <b-tag v-else-if="label == 'is_active' && value != 1" type="is-danger">
                {{value}}
            </b-tag>
            <b-tooltip label="Copy Id" type="is-dark">
                <b-button v-if="label == 'registration_id'" @click="$vaah.copy(value)" type="is-light" class="is-small">
                    #{{value}}
                </b-button>
            </b-tooltip>
        </td>
    </tr>

</template>
<script>

    import BTooltip from "buefy/src/components/tooltip/Tooltip";
    export default {
        name: "TableTrActedBy",
        props: ['label', 'value'],
        computed: {
        },
        components:{
            BTooltip

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
