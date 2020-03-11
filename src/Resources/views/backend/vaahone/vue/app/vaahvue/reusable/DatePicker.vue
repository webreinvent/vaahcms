<template>

    <div >
        <b-datepicker
            v-model="selected"
            :placeholder="placeholder"
            :icon="icon"
            @input="onSelect"
            editable>
        </b-datepicker>
    </div>


</template>

<script>

    export default {
        props: {
            icon: {
                type: String,
                default: "calendar-alt"
            },
            value: {
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
            if(this.value)
            {
                this.value.toString();
                this.selected = new Date(Date.parse(this.value));
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

                let val = selected_date.toLocaleString().toString();

                this.$emit('blur', val);
                this.$emit('input', val);
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }
</script>

