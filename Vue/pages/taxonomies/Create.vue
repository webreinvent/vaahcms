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
                        <p v-if="hasPermission('can-create-taxonomies')" class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="setLocalAction('save-and-new')">
                                Save & New
                            </b-button>
                        </p>

                        <p v-if="hasPermission('can-create-taxonomies')" class="control">


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
                        <tree-select v-model="new_item.vh_taxonomy_type_id"
                                     placeholder="Select a Type"
                                     @select="onSelectType"
                                     :clearable="false"
                                     :normalizer="normalizer"
                                     :multiple="false" :options="page.assets.types" >

                        </tree-select>

                        <p v-if="hasPermission('can-manage-taxonomy-types')"
                           class="control">
                            <b-button @click="page.is_type_modal_active = true"
                                      class="button is-primary">Manage</b-button>
                        </p>
                    </b-field>

                    <b-field v-if="type_parent_id"
                             label="Parent" :label-position="labelPosition">
                        <AutoCompleteParents :parent_id="type_parent_id"
                                             v-model="new_item.parent">
                        </AutoCompleteParents>
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

                    <b-field label="Seo title" :label-position="labelPosition">
                        <b-input name="taxonomies-seo-title" dusk="taxonomies-seo-title"
                                 v-model="new_item.seo_title"></b-input>
                    </b-field>

                    <b-field label="Seo Keywords" :label-position="labelPosition">
                        <b-taginput
                                v-model="new_item.seo_keywords"
                                name="taxonomies-seo-keywords" dusk="taxonomies-seo-keywords"
                                ellipsis
                                icon="tag"
                                placeholder="Add a keyword"
                                aria-close-label="Delete this keyword">
                        </b-taginput>
                    </b-field>

                    <b-field label="Seo Description" :label-position="labelPosition">
                        <b-input maxlength="250" v-model="new_item.seo_description"
                                 name="taxonomies-seo-description"
                                 dusk="taxonomies-seo-description"
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


