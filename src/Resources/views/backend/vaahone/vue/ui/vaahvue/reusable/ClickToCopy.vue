<template>


    <b-tag>


        <span v-if="text_string">
            <b-icon
                    pack="far"
                    icon="copy"
                    size="is-small">
            </b-icon>
            <VaahVueClickToCopy
                    :data="data"
                    :label="text"
                    :confirm_dialog="'buefy'">
            </VaahVueClickToCopy>
        </span>

    </b-tag>


</template>

<script>

    import VaahVueClickToCopy from 'vaah-vue-clicktocopy'

    export default {
        name: "ClickToCopy",
        props: ['text', 'data'],
        components:{
            VaahVueClickToCopy,
        },
        data()
        {
            let obj = {
                text_string: null
            };

            return obj;
        },
        watch:{
            text: function (newVal, oldVal) {
                this.text_string = newVal;
            }
        },
        mounted() {

            //---------------------------------------------------------------------
            this.text_string = this.text;
            //---------------------------------------------------------------------
            if(!this.data)
            {
                this.data = this.text;
            }
            //---------------------------------------------------------------------
        },
        methods: {

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

