<script src="./ScriptsJs.js"></script>
<template>

    <div class="block is-marginless scripts" >

        <b-collapse :open="false" aria-id="scripts">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="scripts">

                <div class="label-left">
                    <h4 class="title is-5">Scripts</h4>
                    <h2 class="subtitle is-6">Add scripts of Google Analytics and other tracking scripts.</h2>
                </div>
                <div class="label-right is-hidden-mobile">
                    <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                    </b-button>
                </div>

            </div>


            <div class="block has-margin-top-10 has-padding-10"  v-if="settings.scripts">

                <div class="columns has-background-white-bis  columns-settings">
                    <div class="column is-half">
                        <div class="block has-padding-10">



                            <b-field  expanded
                                      label="After head tag start (<head>)"
                                      :label-position="labelPosition">

                                <b-input expanded type="textarea"
                                         v-model="settings.scripts.script_after_head_start"
                                         placeholder="">
                                </b-input>

                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                <p class="control">
                                        <b-button icon-left="copy"></b-button>
                                </p>
                                </b-tooltip>


                            </b-field>

                            <b-field  expanded
                                      label="Before head tag close (</head>)"
                                      :label-position="labelPosition">

                                <b-input expanded type="textarea"
                                         v-model="settings.scripts.script_before_head_close"
                                         placeholder="">
                                </b-input>

                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                <p class="control">
                                        <b-button icon-left="copy"></b-button>
                                </p>
                                </b-tooltip>



                            </b-field>

                            <b-field>
                                <p class="control">
                                    <b-button @click="storeSiteSettings"
                                              type="is-primary">Save Scripts</b-button>
                                </p>
                            </b-field>




                        </div>

                    </div>
                    <div class="column is-half">
                        <div class="block has-padding-10">


                            <b-field  expanded
                                      label="After body tag start (<body>)"
                                      :label-position="labelPosition">

                                <b-input expanded type="textarea"
                                         v-model="settings.scripts.script_after_body_start"
                                         placeholder="">
                                </b-input>

                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                <p class="control">
                                        <b-button icon-left="copy"></b-button>
                                </p>
                                </b-tooltip>



                            </b-field>

                            <b-field  expanded
                                      label="Before body tag close (</body>)"
                                      :label-position="labelPosition">

                                <b-input expanded type="textarea"
                                         v-model="settings.scripts.script_before_body_close"
                                         placeholder="">
                                </b-input>

                                <b-tooltip label="Copy Code Snippet" type="is-dark">
                                <p class="control">
                                        <b-button icon-left="copy"></b-button>
                                </p>
                                </b-tooltip>



                            </b-field>


                        </div>

                    </div>
                </div>



            </div>
        </b-collapse>

        <hr class="is-marginless"/>
    </div>

</template>
