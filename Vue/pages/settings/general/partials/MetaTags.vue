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


                            <div class="block" v-if="tags.length > 0" v-for="tag in tags">

                                <b-field :label="tag.label" :label-position="labelPosition">

                                    <b-select v-model="tag.value.attribute" placeholder="Select attribute">
                                        <option
                                            v-for="attr in assets.vh_meta_attributes"
                                            :value="attr.slug"
                                            :key="attr.slug">
                                            {{ attr.name }}
                                        </option>
                                    </b-select>


                                    <b-input v-model="tag.value.attribute_value"></b-input>

                                    <p class="control">
                                        <a class="button is-static">
                                            Content:
                                        </a>
                                    </p>
                                    <b-input expanded v-model="tag.value.content"></b-input>

                                    <p class="control">
                                        <b-tooltip label="Delete" type="is-dark">
                                            <b-button @click="removeTag(tag)" icon-left="trash"></b-button>
                                        </b-tooltip>
                                    </p>

                                </b-field>

                            </div>




                            <b-field>

                                <b-field>
                                    <p class="control">
                                        <b-button type="is-success"
                                                  @click="addTag"
                                                  icon-left="plus">Add Meta Tag</b-button>
                                    </p>
                                    <p class="control">
                                        <b-button @click="storeTags" type="is-primary">Save</b-button>
                                    </p>
                                    <p class="control">
                                        <b-tooltip label="Copy Code Snippet" type="is-dark">
                                            <b-button type="is-primary" icon-left="copy"></b-button>
                                        </b-tooltip>
                                    </p>
                                </b-field>

                                <b-field class="has-margin-left-20">
                                    <b-select v-model="tag_type" placeholder="Select Meta Tags Group">

                                        <option value="google-webmaster">
                                            Google Webmaster
                                        </option>

                                        <option value="open-graph">
                                            Open Graph (Facebook)
                                        </option>

                                    </b-select>
                                    <p class="control">
                                        <b-button @click="generateTags()" type="is-primary">Generate</b-button>
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
