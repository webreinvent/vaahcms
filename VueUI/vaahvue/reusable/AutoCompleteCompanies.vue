<template>

    <div>
        <b-field>
            <b-autocomplete
                :data="data"
                placeholder="Search Clients"
                field="name"
                :loading="isFetching"
                @typing="getAsyncData"
                @select="option => onSelect(option)">

                <template slot-scope="props">
                    <div class="media">
                        <div class="media-content">
                            <span v-if="props.option && props.option.name">
                                {{ props.option.name }}
                                <small v-if="props.option.email">
                                    <br>
                                    Email: <b>{{ props.option.email }}</b>
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
        </b-field>
    </div>

</template>
<script>

    import debounce from 'lodash/debounce'

    export default {
        computed:{
            root_state() {return this.$store.getters['root/state']},
        },
        data() {
            return {
                data: [],
                selected: null,
                name: '',
                isFetching: false
            }
        },
        methods: {
            // You have to install and import debounce to use it,
            // it's not mandatory though.
            getAsyncData: debounce(function (name) {
                if (!name.length) {
                    this.data = [];
                    return
                }
                let self = this;
                this.data = [];
                this.isFetching = true;

                let url = this.root_state.ajax_url+'/json/companies/';
                url += name;

                this.axios.get(url).then((response) => {
                    this.data = [];
                    response.data.forEach((item) => this.data.push(item));
                    self.isFetching = false;

                });

            }, 500),
            //----------------------------------------------------
            onSelect: function (option) {

                this.selected = option;
                this.name = option.name;
                this.$emit('onSelect', option);
            }
            //----------------------------------------------------
        }
    }


</script>
