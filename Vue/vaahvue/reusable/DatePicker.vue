<template>

    <div >
        <b-datepicker
            v-model="selected"
            :placeholder="placeholder"
            :icon="icon"
            @input="onSelect"
            :date-formatter="dateFormat"
            editable>
        </b-datepicker>
    </div>


</template>

<script>
    import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

    export default {
        props: {
            icon: {
                type: String,
                default: "calendar-alt"
            },
            selected_value: {
                type: String,
                default: null
            },
            placeholder: {
                type: String,
                default: "Type or select a date..."
            },
        },
        components:{

        },
        data()
        {
            let obj = {
                selected: null,
            };

            return obj;
        },
        created() {
        },
        mounted(){
            if(this.selected_value)
            {
                this.selected_value.toString();
                this.selected = new Date(Date.parse(this.selected_value));
            }
        },
        computed: {
        },
        watch: {
            value: function (newVal, oldVal) {
                if(newVal)
                {
                    newVal.toString();
                    this.selected = new Date(Date.parse(newVal));
                }
            }
        },
        methods: {
            //---------------------------------------------------------------------

            //---------------------------------------------------------------------
            onSelect: function (selected_date) {
                let val = Vaah.formatDate(selected_date);
                this.$emit('blur', val);
                this.$emit('input', val);
                this.$emit('onSelect', val);
            },
            //---------------------------------------------------------------------
            dateFormat: function (data) {
                let val = Vaah.formatDate(data);
                return val;
            }
            //---------------------------------------------------------------------
        }
    }
</script>

