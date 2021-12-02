<script src="./IndexJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column is-8">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                User Settings
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="expandAll()"
                                                  icon-left="angle-double-down">
                                            Expand All
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="collapseAll()"
                                                  icon-left="angle-double-up">
                                            Collapse All
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content is-paddingless">



                            <div class="block">

                                <b-collapse
                                                    class="card"
                                                    animation="slide"
                                                    aria-id="contentIdForA11y3">
                                                <div class="level has-padding-10" slot="trigger"
                                                     slot-scope="props"
                                                     aria-controls="site_settings">

                                                    <div class="label-left">
                                                        <h4 class="title is-5">Fields</h4>
                                                    </div>
                                                    <div class="label-right is-hidden-mobile">
                                                        <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                                                        </b-button>
                                                    </div>

                                                </div>

                                                <div class="card-content has-background-white-bis">
                                                    <b-table
                                                            :data="is_empty ? [] : field_list"
                                                            :mobile-cards="has_mobile_cards">


                                                        <b-table-column field="field_name" label="Field Name"
                                                                        :td-attrs="columnTdAttrs" v-slot="props">
                                                            {{ $vaah.toLabel(props.row.key) }}
                                                        </b-table-column>

                                                        <b-table-column field="is_hidden" width="120"
                                                                        label="Is Hidden" v-slot="props">
                                                            <b-field>
                                                                <b-radio-button name="user-is_hidden"
                                                                                dusk="user-is_hidden"
                                                                                @input="store(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=true>
                                                                    <span>Yes</span>
                                                                </b-radio-button>

                                                                <b-radio-button type="is-danger"
                                                                                name="user-is_hidden"
                                                                                dusk="user-is_hidden"
                                                                                @input="store(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=false>
                                                                    <span>No</span>
                                                                </b-radio-button>
                                                            </b-field>
                                                        </b-table-column>

                                                        <b-table-column field="apply_for_registration" width="120"
                                                                        label="Apply for Registration"
                                                                        :td-attrs="columnTdAttrs" v-slot="props">
                                                            <b-checkbox  @input="store(props.row)"
                                                                         :native-value=true
                                                                         v-model="props.row.value.for_registration">
                                                            </b-checkbox>
                                                        </b-table-column>


                                                        <template #empty>
                                                            <div class="has-text-centered">No records</div>
                                                        </template>

                                                    </b-table>
                                                </div>
                                            </b-collapse>

                                <b-collapse
                                                    class="card"
                                                    animation="slide"
                                                    aria-id="contentIdForA11y3">
                                                <div class="level has-padding-10" slot="trigger"
                                                     slot-scope="props"
                                                     aria-controls="site_settings">

                                                    <div class="label-left">
                                                        <h4 class="title is-5">Custom Fields</h4>
                                                    </div>
                                                    <div class="label-right is-hidden-mobile">
                                                        <b-button v-text="props.open ? 'Collapse' : 'Expand'">
                                                        </b-button>
                                                    </div>

                                                </div>

                                                <div class="card-content has-background-white-bis">
                                                    <b-table
                                                            :data="is_empty ? [] : custom_field_list"
                                                            :mobile-cards="has_mobile_cards">


                                                        <b-table-column field="field_name" label="Field Name"
                                                                        :td-attrs="columnTdAttrs" v-slot="props">
                                                            {{ $vaah.toLabel(props.row.key) }}
                                                        </b-table-column>

                                                        <b-table-column field="is_hidden" width="120"
                                                                        label="Is Hidden" v-slot="props">
                                                            <b-field>
                                                                <b-radio-button name="user-is_hidden"
                                                                                dusk="user-is_hidden"
                                                                                @input="store(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=true>
                                                                    <span>Yes</span>
                                                                </b-radio-button>

                                                                <b-radio-button type="is-danger"
                                                                                name="user-is_hidden"
                                                                                dusk="user-is_hidden"
                                                                                @input="store(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=false>
                                                                    <span>No</span>
                                                                </b-radio-button>
                                                            </b-field>
                                                        </b-table-column>

                                                        <b-table-column field="apply_for_registration" width="120"
                                                                        label="Apply for Registration"
                                                                        :td-attrs="columnTdAttrs" v-slot="props">
                                                            <b-checkbox  @input="store(props.row)"
                                                                         :native-value=true
                                                                         v-model="props.row.value.for_registration">
                                                            </b-checkbox>
                                                        </b-table-column>


                                                        <template #empty>
                                                            <div class="has-text-centered">No records</div>
                                                        </template>

                                                    </b-table>
                                                    <hr class="is-size-5" />
                                                    <b-field>

                                                        <b-field>
                                                            <p class="control">
                                                                <b-input v-model="field.name"
                                                                         placeholder="Field Name"></b-input>
                                                            </p>
                                                            <p class="control">
                                                                <b-select v-model="field.type"
                                                                          placeholder="Select a type">
                                                                    <option value="text">Text</option>
                                                                    <option value="email">Email</option>
                                                                    <option value="textarea">TextArea</option>
                                                                </b-select>
                                                            </p>
                                                            <p class="control">
                                                                <b-button @click="store" type="is-primary">
                                                                    Save
                                                                </b-button>
                                                            </p>

                                                        </b-field>

                                                    </b-field>
                                                </div>
                                            </b-collapse>

                            </div>
                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

            </div>


        </div>

    </div>
</template>

<style>
    .table{
        background-color: #fafafa !important;
    }
</style>


