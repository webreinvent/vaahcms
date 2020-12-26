<template>

    <div >
        <!--autocomplete users-->
        <b-field>
            <b-autocomplete
                v-model="q"
                :data="filteredDataArray"
                :placeholder="placeholder"
                :icon="icon"
                :open-on-focus="open_on_focus"
                ref="autocompleteSimple"
                @select="option => selected = option">

                <template slot-scope="props">
                    <div class="media">
                        <div class="media-content" v-if="props.option">
                            <span v-if="props.option">
                                {{ props.option }}
                            </span>
                        </div>
                    </div>
                </template>

                <template slot="empty">No results found</template>
            </b-autocomplete>
        </b-field>
        <!--/autocomplete users-->
    </div>


</template>

<script>

    import Fuse from "fuse.js";

    export default {
        props: {
            options: {
                type: Array,
                required: true
            },
            icon: {
                type: String,
                default: ""
            },
            open_on_focus: {
                type: Boolean,
                default: true
            },
            selected_value: String|Number,
            placeholder: {
                type: String,
                default: ""
            },
        },
        components:{

        },
        data()
        {
            let obj = {
                //----autocomplete users
                q: null,
                data: [],
                selected: null,
                //----/autocomplete users
            };

            return obj;
        },
        created() {
        },
        mounted(){
            this.setSelectedValue(this.selected_value);
        },
        computed: {
            filteredDataArray() {
                let list_filtered;
                if(this.options && this.q && this.q != this.selected_value)
                {
                    list_filtered = this.options.filter((option) => {
                        return option
                            .toString()
                            .toLowerCase()
                            .indexOf(this.q.toLowerCase()) >= 0
                    });

                } else
                {
                    list_filtered = this.options;
                }
                return list_filtered;
            }

        },
        watch: {
            options: function (newValue, oldValue) {
                this.options = newValue;
            },
            selected: function (newValue, oldValue) {
                if(newValue && newValue != this.selected_value)
                {
                    this.$emit('onSelect', newValue);
                }
            },

        },
        methods: {
            //---------------------------------------------------------------------
            setSelectedValue: function (selected_value) {
                this.$refs.autocompleteSimple.setSelected(selected_value);
            }
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }
</script>

