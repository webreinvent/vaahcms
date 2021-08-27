<template>

        <b-autocomplete
                expanded
                v-model="content_value"
                :data="data"
                placeholder="Search"
                field="name"
                @select="onSelect"
                :loading="isFetching"
                @typing="getAsyncData">
            <template slot-scope="props">
                <div class="media">
                    <div class="media-content">
                                <span v-if="props.option && props.option.name">
                                    {{ props.option.name }}
                                    <small v-if="props.option.slug">
                                        <br>
                                        Slug: <b>{{ props.option.slug }}</b>
                                    </small>
                                </span>

                    </div>
                </div>
            </template>

            <template slot="empty">
                <span v-if="isFetching">Searching...</span>
                <span v-else>No results found</span>
            </template>

        </b-autocomplete>

</template>
<script>
    let namespace = 'taxonomies';
    import debounce from 'lodash/debounce'

    export default {
        computed:{
            ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        },
        props:{
            value: {
                type: String|Number|Array|Object,
                default: null
            },
            type: {
                type: String,
                default: null,
            },
            size: {
                type: String,
                default: null,
            },
            custom_class: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                default: null,
            },
            labelPosition: {
                type: String,
                default: null,
            },
            placeholder: {
                type: String,
                default: "Type or select a date..."
            },
            icon: {
                type: String,
                default: "calendar-alt"
            },
        },
        data() {
            return {
                data: [],
                selected: null,
                content_value: null,
                name: '',
                isFetching: false
            }
        },
        mounted() {
            //----------------------------------------------------
            if( this.value){
                this.getCountryDetailById();
            }
            //----------------------------------------------------
        },
        methods: {
            // You have to install and import debounce to use it,
            // it's not mandatory though.
            getAsyncData: debounce(function (name) {
                if (!name.length) {
                    this.data = [];
                    return
                }

                this.$emit('input', null);

                let self = this;
                this.data = [];
                this.isFetching = true;

                let url = this.ajax_url+'/json/countries/';
                url += name;

                this.axios.get(url).then((response) => {
                    response.data.forEach((item) => this.data.push(item));
                    self.isFetching = false;
                });

            }, 500),
            // You have to install and import debounce to use it,
            // it's not mandatory though.
            getCountryDetailById: debounce(function () {

                let self = this;

                let url = this.ajax_url+'/json/getCountryById/';
                url += this.value.id;

                this.axios.get(url).then((response) => {
                    self.content_value = response.data.name;
                });

            }, 500),
            //----------------------------------------------------
            onSelect: function (option) {
                this.$emit('input', option);
            },
            //----------------------------------------------------
        }
    }


</script>
