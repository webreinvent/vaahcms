<script src="./SocialMediaLinksJs.js"></script>
<template>

    <div class="block is-marginless">

        <b-collapse :open="false" aria-id="social_links">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="social_links">

                <div class="label-left">
                    <h4 class="title is-5">Social Media & Links</h4>
                    <h2 class="subtitle is-6">Static links management.</h2>
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



                            <b-field  expanded
                                      v-for="link in settings.links"
                                      :key="link.name"
                                      :label="link.name"
                                      :label-position="labelPosition">

                                <b-input expanded type="text"
                                         v-model="link.name"
                                         placeholder="Link Label">
                                </b-input>

                                <b-input expanded type="text"
                                         v-model="link.url"
                                         placeholder="Link Url">
                                </b-input>



                                <p class="control">
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <b-button icon-left="copy"></b-button>
                                    </b-tooltip>
                                </p>
                                <p class="control">
                                    <b-tooltip label="Delete" type="is-dark">
                                        <b-button icon-left="trash"></b-button>
                                    </b-tooltip>
                                </p>

                            </b-field>


                            <b-field>
                                <p class="control">
                                    <b-button type="is-primary" icon-left="plus">Add Link</b-button>
                                </p>
                                <p class="control">
                                    <b-button type="is-primary">Save</b-button>
                                </p>
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
