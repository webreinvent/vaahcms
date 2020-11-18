<template>

    <tr v-if="value">
        <th width="130" align="right">{{toLabel(label)}}</th>
        <td>{{value}}</td>
        <td width="20">
            <a :href="value" target="_blank">
                <b-icon icon="external-link-alt"></b-icon>
            </a>
        </td>
    </tr>

</template>
<script>

    import {VaahHelper as Vaah} from "../helpers/VaahHelper";

    export default {
        name: "TableTrUrl",
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
            toLabel: function(str)
            {
                if(!str)
                {
                    return null;
                }

                return Vaah.toLabel(str);
                //return str;
            },
            //---------------------------------------------------------------------
        }
    }

</script>
