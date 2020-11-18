<template>

    <tr>
        <th align="right">{{$vaah.toLabel(label)}}</th>
        <td >
            <span v-if="value">
                <b-tag v-if="is_hashed">
                    #{{value}}
                </b-tag>
                <b-tag v-else>
                    {{value}}
                </b-tag>
            </span>

        </td>
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

    export default {
        name: "TableTrTag",
        props: ['label', 'value', 'is_copiable', 'is_hashed'],
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
