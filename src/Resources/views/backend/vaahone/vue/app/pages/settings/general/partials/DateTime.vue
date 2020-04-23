<script src="./DateTimeJs.js"></script>
<template>

    <div class="block is-marginless">

        <b-collapse :open="false" aria-id="date_time_settings">

            <div class="level has-padding-10" slot="trigger"
                 slot-scope="props"
                 aria-controls="date_time_settings">

                <div class="label-left">
                    <h4 class="title is-5">Date & Time</h4>
                    <h2 class="subtitle is-6">Global date and time settings.</h2>
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
                                      label="Date Format"
                                      class="has-margin-bottom-15"
                                      :label-position="labelPosition">

                                <b-radio-button native-value="Y-m-d"
                                                v-model="settings.formats.date">
                                    <span>Y-m-d</span>
                                </b-radio-button>

                                <b-radio-button native-value="Y/m/d"
                                                v-model="settings.formats.date">
                                    <span>Y/m/d</span>
                                </b-radio-button>

                                <b-radio-button native-value="Y.m.d"
                                                v-model="settings.formats.date">
                                    <span>Y.m.d</span>
                                </b-radio-button>

                                <b-radio-button native-value="custom"
                                                v-model="settings.formats.date_type">
                                    <span>Custom</span>
                                </b-radio-button>

                                <b-input expanded type="text"
                                         v-if="settings.formats.date_type"
                                         v-model="settings.formats.date"
                                         placeholder="Type valid date format">
                                </b-input>

                                <p class="control">
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <b-button icon-left="copy"></b-button>
                                    </b-tooltip>
                                </p>

                            </b-field>

                            <b-field  expanded
                                      label="Time Format"
                                      :label-position="labelPosition">

                                <b-radio-button native-value="H:i:s"
                                                v-model="settings.formats.time">
                                    <span>H:i:s</span>
                                </b-radio-button>

                                <b-radio-button native-value="h:i A"
                                                v-model="settings.formats.time">
                                    <span>h:i A</span>
                                </b-radio-button>

                                <b-radio-button native-value="h:i:s A"
                                                v-model="settings.formats.time">
                                    <span>h:i:s A</span>
                                </b-radio-button>

                                <b-radio-button native-value="custom"
                                                v-model="settings.formats.time_type">
                                    <span>Custom</span>
                                </b-radio-button>

                                <b-input expanded type="text"
                                         v-if="settings.formats.time_type"
                                         v-model="settings.formats.time"
                                         placeholder="Type valid time format">
                                </b-input>

                                <p class="control">
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <b-button icon-left="copy"></b-button>
                                    </b-tooltip>
                                </p>

                            </b-field>

                            <b-field  expanded
                                      label="Date Time Format"
                                      :label-position="labelPosition">

                                <b-radio-button native-value="H:i:s"
                                                v-model="settings.formats.time">
                                    <span>H:i:s</span>
                                </b-radio-button>

                                <b-radio-button native-value="h:i A"
                                                v-model="settings.formats.time">
                                    <span>h:i A</span>
                                </b-radio-button>

                                <b-radio-button native-value="h:i:s A"
                                                v-model="settings.formats.time">
                                    <span>h:i:s A</span>
                                </b-radio-button>

                                <b-radio-button native-value="custom"
                                                v-model="settings.formats.time_type">
                                    <span>Custom</span>
                                </b-radio-button>

                                <b-input expanded type="text"
                                         v-if="settings.formats.time_type"
                                         v-model="settings.formats.time"
                                         placeholder="Type valid time format">
                                </b-input>

                                <p class="control">
                                    <b-tooltip label="Copy Code Snippet" type="is-dark">
                                        <b-button icon-left="copy"></b-button>
                                    </b-tooltip>
                                </p>

                            </b-field>



                            <b-button type="is-primary" >Save Password</b-button>

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
