<script src="./SocialMediaLinksJs.js"></script>
<template>

    <div class="block is-marginless" >

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
                        <div class="block has-padding-10" v-if="links">

                            <b-field  expanded
                                      v-for="link in links"
                                      :key="link.key"
                                      :label="$vaah.toLabel(link.label)"
                                      :label-position="labelPosition">

                                <b-input expanded type="text"
                                         v-model="link.label"
                                         placeholder="Link Label">
                                </b-input>

                                <b-input expanded type="text"
                                         v-model="link.value"
                                         placeholder="Link Url">
                                </b-input>


                                <b-tooltip label="Copy Code Snippet" type="is-dark">

                                <p class="control">
                                    <b-button icon-left="copy"
                                              @click="copySetting(link.key)">
                                    </b-button>
                                </p>
                                </b-tooltip>


                                <b-tooltip label="Delete" type="is-dark">

                                <p class="control">
                                        <b-button @click="removeLink(link)"
                                                  icon-left="trash"></b-button>
                                </p>
                                </b-tooltip>


                            </b-field>


                            <b-field>
                                <p class="control">
                                    <b-button type="is-primary"
                                              @click="addLink"
                                              icon-left="plus">Add Link</b-button>
                                </p>
                                <p class="control">
                                    <b-button @click="storeLinks()"
                                              type="is-primary">Save</b-button>
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
