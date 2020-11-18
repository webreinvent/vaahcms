<template>

    <b-field v-if="item" grouped group-multiline>


        <div class="control" >
            <b-taglist attached>
                <b-tag type="is-dark">name</b-tag>
                <b-tag type="is-info"
                       class="clickable">

                    <a v-if="item.vaah_url" :href="item.vaah_url" target="_blank" >
                        <b-icon size="is-small"
                                class="has-margin-right-5 "
                                icon="external-link-alt"></b-icon>
                        {{ item.name }}
                    </a>

                    <p v-else>
                        <b-icon size="is-small"
                                class="has-margin-right-5 "
                                icon="external-link-alt"></b-icon>
                        {{ item.name }}

                    </p>

                </b-tag>

            </b-taglist>
        </div>




        <div class="control">
            <b-taglist attached>
                <b-tag type="is-dark">version</b-tag>
                <b-tag type="is-info">{{ item.version }}</b-tag>
            </b-taglist>
        </div>

        <div class="control">
            <b-taglist attached>
                <b-tag type="is-dark">developed by</b-tag>
                <b-tag type="is-info"
                       class="clickable">

                    <a :href="item.author_website" target="_blank" >

                        <b-icon size="is-small"
                                class="has-margin-right-5"
                                icon="external-link-alt"></b-icon>

                        {{ item.author_name }}

                    </a>

                </b-tag>

            </b-taglist>
        </div>

        <!--<div class="control" v-if="!hide_update_tag">
            <b-taglist attached>
                <b-tag type="is-success">update available</b-tag>
                <b-tag type="is-success"
                       class="clickable">
                    <a :href="item.author_website" target="_blank" >
                        <b-icon size="is-small"
                                class="has-margin-right-5"
                                icon="external-link-alt"></b-icon>
                        v0.0.5
                    </a>
                </b-tag>

            </b-taglist>
        </div>-->

    </b-field>


</template>

<script>

    export default {
        props: ['item', 'hide_update_tag'],
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
