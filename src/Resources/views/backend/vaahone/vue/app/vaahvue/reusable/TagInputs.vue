<template>

    <div v-if="options">

        <b-field>
            <b-taginput
                v-model="tags"
                :data="filteredTags"
                autocomplete
                :allow-new="allow_new"
                :open-on-focus="open_on_focus"
                :field="field_name"
                :icon="icon"
                :placeholder="placeholder"
                attached
                size="is-small"
                @add="emitTags"
                @remove="emitTags"
                @typing="getFilteredTags">

                <template slot-scope="props">
                    <div class="media">
                        <div class="media-content">
                            <span v-if="props.option && props.option[field_name]">
                                {{ props.option[field_name] }}
                            </span>

                        </div>
                    </div>
                </template>

                <template slot="empty">
                    <span>No results found</span>
                </template>

            </b-taginput>
        </b-field>
    </div>

</template>
<script>
    import Fuse from "fuse.js";

    export default {
        props: {
            options: {
                type: Array,
                required: true,
                default: function () {
                    return []
                }
            },
            field_name: {
                type: String,
                default: "name"
            },
            search_fields: {
                type: Array,
                default: function () {
                    return ["name", "slug"]
                }
            },
            icon: {
                type: String,
                default: "search"
            },
            open_on_focus: {
                type: Boolean,
                default: false
            },
            allow_new: {
                type: Boolean,
                default: false
            },
            selected_value: {
                type: Array,
                default: function () {
                    return []
                }
            },
            placeholder: {
                type: String,
                default: "Search"
            },
        },
        data() {
            return {
                filteredTags: [],
                isSelectOnly: false,
                tags: [],
            }
        },
        mounted() {
            console.log('--->', this.selected_value);
            this.tags = this.selected_value;
        },
        watch: {

            options: function (newValue, oldValue) {
                this.options = newValue;

            },
            /*selected_value: function (newValue, oldValue) {

                this.tags = newValue;
            }*/


        },
        methods: {
            getFilteredTags(text) {

                var config = {
                    shouldSort: true,
                    threshold: 0.6,
                    location: 0,
                    distance: 100,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: this.search_fields
                };

                let list_filtered;

                if(this.options && text)
                {
                    let fuse = new Fuse(this.options, config);
                    list_filtered = fuse.search(text);
                } else
                {
                    list_filtered = this.options;
                }


                this.filteredTags = list_filtered;
            },
            emitTags: function () {
                this.$emit('onTagChange', this.tags);
                this.$emit('onSelect', this.tags);
            },
        }
    }


</script>
