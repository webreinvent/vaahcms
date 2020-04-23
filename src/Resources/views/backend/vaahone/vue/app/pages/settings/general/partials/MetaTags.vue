<script src="./MetaTagsJs.js"></script>
<template>

    <div class="block is-marginless">

        <b-collapse :open="false" aria-id="social_links">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="social_links">

                <div class="label-left">
                    <h4 class="title is-5">Meta Tags</h4>
                    <h2 class="subtitle is-6">Global meta tags.</h2>
                </div>
                <div class="label-right is-hidden-mobile">
                    <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                    </b-button>
                </div>

            </div>


            <div class="block has-margin-top-10 has-padding-10">

                <div class="columns has-background-white-bis  columns-settings">
                    <div class="column is-half">
                        <div class="block has-padding-10">


                            <div class="block" v-for="meta in settings.meta_tags">

                                <b-field :label="meta.label" :label-position="labelPosition">

                                    <p class="control" v-if="meta.attribute">
                                        <a class="button is-static">
                                            {{ meta.attribute }}                                                                </a>
                                    </p>

                                    <b-select v-else placeholder="Select attribute">
                                        <option
                                            v-for="attr in assets.vh_meta_attributes"
                                            :value="attr.slug"
                                            :key="attr.slug">
                                            {{ attr.name }}
                                        </option>
                                    </b-select>


                                    <p class="control" v-if="meta.property_value">
                                        <a class="button is-static">
                                            {{meta.property_value}}
                                        </a>
                                    </p>

                                    <b-input v-else v-model="meta.property_value"></b-input>

                                    <p class="control">
                                        <a class="button is-static">
                                            Content:
                                        </a>
                                    </p>
                                    <b-input expanded v-model="meta.content"></b-input>

                                    <p class="control">
                                        <b-tooltip label="Delete" type="is-dark">
                                            <b-button icon-left="trash"></b-button>
                                        </b-tooltip>
                                    </p>

                                </b-field>

                            </div>




                            <b-field>

                                <b-field>
                                    <p class="control">
                                        <b-button type="is-success" icon-left="plus">Add Meta Tag</b-button>
                                    </p>
                                    <p class="control">
                                        <b-button type="is-primary">Save</b-button>
                                    </p>
                                    <p class="control">
                                        <b-tooltip label="Copy Code Snippet" type="is-dark">
                                            <b-button type="is-primary" icon-left="copy"></b-button>
                                        </b-tooltip>
                                    </p>
                                </b-field>

                                <b-field class="has-margin-left-20">
                                    <b-select placeholder="Select Meta Tags Group">
                                        <option value="open-graph">
                                            Open Graph
                                        </option>
                                        <option value="facebook">
                                            Facebook
                                        </option>
                                        <option value="twitter">
                                            Twitter
                                        </option>
                                    </b-select>
                                    <p class="control">
                                        <b-button type="is-primary">Generate</b-button>
                                    </p>
                                </b-field>

                            </b-field>



                        </div>

                    </div>
                    <div class="column is-half">
                        <div class="block has-padding-10">


                        </div>

                    </div>
                </div>



            </div>
        </b-collapse>

        <hr class="is-marginless"/>
    </div>

</template>
