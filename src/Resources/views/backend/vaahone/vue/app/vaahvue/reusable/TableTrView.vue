<template>


    <tr>
        <th width="130" align="right">{{label}}</th>
        <td>{{value}}</td>
        <td width="20">
            <span v-if="is_copiable">
                <vh-copy :data="''+value+''"
                         confirm_dialog="buefy">
                <b-icon icon="copy"></b-icon>
            </vh-copy>
            </span>

        </td>
    </tr>


</template>

<script>
    import {VaahHelper as Vaah} from "./../helpers/VaahHelper";

    export default {
        name: "TableTrView",
        props: ['value', 'label', 'is_copiable', 'is_upper_case'],
        computed:{
            label: function () {
                return this.label.replace("_", " ");
            }
        },
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
            toLabel: function(str)
            {
                return str.replace("_", " ");
            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

