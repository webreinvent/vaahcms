<script src="./CreateJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    Create
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="setLocalAction('save-and-new')">
                                Save & New
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-close')">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-clone')">
                                    <b-icon icon="copy"></b-icon>
                                    Save & Clone
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="resetNewItem()">
                                    <b-icon icon="eraser"></b-icon>
                                    Reset
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button tag="router-link"
                                      type="is-light"
                                      :to="{name: 'taxonomies.list'}"
                                      icon-left="times">
                            </b-button>
                        </p>



                    </div>


                </div>

            </header>
            <!--/header-->

            <!--content-->
            <div class="card-content">
                <div class="block">

                    <b-field label="Type" :label-position="labelPosition">
                        <b-select placeholder="Select a Type"
                                  v-model="new_item.type"
                                  name="taxonomies-type"
                                  dusk="taxonomies-type">
                            <option
                                    v-for="(option, index) in page.assets.types"
                                    :value="option"
                                    :key="index">
                                {{ option }}
                            </option>
                        </b-select>
                    </b-field>

                    <b-field v-if="new_item.type === 'Cities'" label="Country" :label-position="labelPosition">
                        <AutoCompleteCountries v-model="new_item.parent"></AutoCompleteCountries>
                    </b-field>

                    <b-field label="Name" :label-position="labelPosition">
                        <b-input name="taxonomies-name" dusk="taxonomies-name"
                                 v-model="new_item.name"></b-input>
                    </b-field>

                    <b-field label="Slug" :label-position="labelPosition">
                        <b-input name="taxonomies-slug" dusk="taxonomies-slug"
                                 v-model="new_item.slug"></b-input>
                    </b-field>

                    <b-field label="Notes" :label-position="labelPosition">
                        <b-input maxlength="250" v-model="new_item.notes"
                                 name="taxonomies-notes" dusk="taxonomies-notes"
                                 type="textarea"></b-input>
                    </b-field>

                    <b-field label="Is Active" :label-position="labelPosition">
                        <b-radio-button name="taxonomies-is_active" dusk="taxonomies-is_active"
                                        v-model="new_item.is_active"
                                        :native-value=1>
                            <span>Yes</span>
                        </b-radio-button>

                        <b-radio-button type="is-danger" name="taxonomies-is_active"
                                        dusk="taxonomies-is_active"
                                        v-model="new_item.is_active"
                                        :native-value=null>
                            <span>No</span>
                        </b-radio-button>
                    </b-field>




                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


