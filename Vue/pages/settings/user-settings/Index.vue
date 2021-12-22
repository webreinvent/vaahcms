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

                                <b-collapse class="card"
                                            :open="false"
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
                                                                                @input="storeField(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=true>
                                                                    <span>Yes</span>
                                                                </b-radio-button>

                                                                <b-radio-button type="is-danger"
                                                                                name="user-is_hidden"
                                                                                dusk="user-is_hidden"
                                                                                @input="storeField(props.row)"
                                                                                v-model="props.row.value.is_hidden"
                                                                                :native-value=false>
                                                                    <span>No</span>
                                                                </b-radio-button>
                                                            </b-field>
                                                        </b-table-column>

                                                        <b-table-column field="apply_to_registrations" width="100"
                                                                        label="Apply to Registrations"
                                                                        :td-attrs="columnTdAttrs" v-slot="props">
                                                            <b-checkbox  @input="storeField(props.row)"
                                                                         :native-value=true
                                                                         v-model="props.row.value.to_registration">
                                                            </b-checkbox>
                                                        </b-table-column>


                                                        <template #empty>
                                                            <div class="has-text-centered">No records</div>
                                                        </template>

                                                    </b-table>
                                                </div>
                                            </b-collapse>

                                <b-collapse class="card"
                                            :open="false"
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

<!--                                                    {{ custom_field_list }}-->

                                                    <div class="draggable" >
                                                        <draggable class="dropzone" :list="custom_field_list.value"
                                                                   :group="{name:'fields'}">
                                                            <div v-if="custom_field_list.value.length>0"
                                                                 v-for="(field, f_index) in custom_field_list.value"
                                                                 :key="f_index">
                                                                <div class="dropzone-field">
                                                                    <b-field class="is-marginless" >
                                                                        <p class="control drag">
                                                                            <span class="button is-static">:::</span>
                                                                        </p>

                                                                        <p class="control">
                                                                            <span class="button dropzone-field-label is-static">
                                                                                {{ $vaah.toLabel(field.type) }}
                                                                            </span>
                                                                        </p>
                                                                        <b-input v-model="field.name" @input="onInputFieldName(field)" expanded
                                                                                 placeholder="Field Name">
                                                                        </b-input>

                                                                        <b-tooltip label="Field Option" type="is-dark">
                                                                            <p class="control">
                                                                                <b-button icon-left="cog"
                                                                                          @click="toggleFieldOptions($event)"></b-button>
                                                                            </p>
                                                                        </b-tooltip>

                                                                        <b-tooltip label="Delete Field" type="is-dark">
                                                                            <p class="control">
                                                                                <b-button @click="deleteGroupField( f_index)"
                                                                                          icon-left="trash"></b-button>
                                                                            </p>
                                                                        </b-tooltip>

                                                                    </b-field>
                                                                    <div class="card dropzone-field-options">

                                                                        <table class="custom-table table">

                                                                            <tr >
                                                                                <td width="180" >
                                                                                    Is hidden
                                                                                </td>
                                                                                <td>
                                                                                    <b-switch v-model="field.is_hidden" :true-value=true
                                                                                              type="is-success">
                                                                                    </b-switch>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td width="180" >
                                                                                    Apply to Registration
                                                                                </td>
                                                                                <td>
                                                                                    <b-switch v-model="field.to_registration" :true-value=true
                                                                                              type="is-success">
                                                                                    </b-switch>
                                                                                </td>
                                                                            </tr>

                                                                            <tr v-if="field['is_password_reveal'] !== undefined">
                                                                                <td width="180" >
                                                                                    Is Password Reveal
                                                                                </td>
                                                                                <td>
                                                                                    <b-switch v-model="field.is_password_reveal" :true-value=true
                                                                                              type="is-success">
                                                                                    </b-switch>
                                                                                </td>
                                                                            </tr>

                                                                            <tr v-if="field['minlength'] !== undefined">
                                                                                <td>
                                                                                    Min-Length
                                                                                </td>
                                                                                <td>
                                                                                    <b-input v-model="field.minlength"
                                                                                             type="number"></b-input>
                                                                                </td>
                                                                            </tr>

                                                                            <tr v-if="field['maxlength'] !== undefined">
                                                                                <td>
                                                                                    Max-Length
                                                                                </td>
                                                                                <td>
                                                                                    <b-input v-model="field.maxlength"
                                                                                             type="number"></b-input>
                                                                                </td>
                                                                            </tr>

                                                                            <tr v-if="field['min'] !== undefined">
                                                                                <td>
                                                                                    Min
                                                                                </td>
                                                                                <td>
                                                                                    <b-input v-model="field.min"
                                                                                             type="number"></b-input>
                                                                                </td>
                                                                            </tr>

                                                                            <tr v-if="field['max'] !== undefined">
                                                                                <td>
                                                                                    Max
                                                                                </td>
                                                                                <td>
                                                                                    <b-input v-model="field.max"
                                                                                             type="number"></b-input>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td >
                                                                                    Excerpt
                                                                                </td>
                                                                                <td>
                                                                                    <b-input maxlength="200" v-model="field.excerpt"
                                                                                             type="textarea"></b-input>
                                                                                </td>
                                                                            </tr>

                                                                        </table>



                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </draggable>
                                                    </div>

                                                    <hr class="is-size-5" />

                                                    <div class="level">
                                                        <div class="level-left">
                                                            <b-field>

                                                                <b-field>
                                                                    <p class="control">
                                                                        <b-select v-model="field_type"
                                                                                  placeholder="Select a type">
                                                                            <option value="text">Text</option>
                                                                            <option value="email">Email</option>
                                                                            <option value="textarea">TextArea</option>
                                                                            <option value="number">Number</option>
                                                                            <option value="password">Password</option>
                                                                        </b-select>
                                                                    </p>
                                                                    <p class="control">
                                                                        <b-button @click="addCustomField"
                                                                                  type="is-primary">
                                                                            Add
                                                                        </b-button>
                                                                    </p>

                                                                </b-field>

                                                            </b-field>
                                                        </div>
                                                        <div class="level-right">
                                                            <b-button icon-left="save"
                                                                      type="is-primary"
                                                                      :loading="is_btn_loading"
                                                                      @click="storeCustomField()">
                                                                Save
                                                            </b-button>
                                                        </div>
                                                    </div>


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
    .custom-table{
        background-color: #ffffff !important;
    }
</style>


