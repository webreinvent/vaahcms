<script src="./EditJs.js"></script>
<template>
    <div class="column" v-if="page.assets && item">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    <span>{{$vaah.limitString(title, 15)}}</span>
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
                            </b-button>
                        </p>

                        <p class="control">
                            <b-button icon-left="save"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="setLocalAction('save')">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light"
                                        slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-close')">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-new')">
                                    <b-icon icon="plus"></b-icon>
                                    Save & New
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-clone')">
                                    <b-icon icon="copy"></b-icon>
                                    Save & Clone
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button tag="router-link"
                                      type="is-light"
                                      :to="{name: 'taxonomies.view', params:{id:item.id}}"
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
                        <tree-select v-model="item.vh_taxonomy_type_id"
                                     placeholder="Select a Type"
                                     @select="onSelectType"
                                     :clearable="false"
                                     :normalizer="normalizer"
                                     :multiple="false" :options="page.assets.types" >

                        </tree-select>
                        <p class="control">
                            <b-button @click="is_type_modal_active = true"
                                      class="button is-primary">
                                Add
                            </b-button>
                        </p>
                    </b-field>

                    <b-field v-if="type_parent_id"
                             label="Parent" :label-position="labelPosition">
                        <AutoCompleteParents :parent_id="type_parent_id"
                                             v-model="item.parent">
                        </AutoCompleteParents>
                    </b-field>

                    <b-field label="Name" :label-position="labelPosition">
                        <b-input name="taxonomies-name" dusk="taxonomies-name"
                                 @input="onInputName"
                                 v-model="item.name"></b-input>
                    </b-field>

                    <b-field label="Slug" :label-position="labelPosition">
                        <b-input name="taxonomies-slug" dusk="taxonomies-slug"
                                 v-model="item.slug"></b-input>
                    </b-field>

                    <b-field label="Notes" :label-position="labelPosition">
                        <b-input maxlength="250" v-model="item.notes"
                                 name="taxonomies-notes" dusk="taxonomies-notes"
                                 type="textarea"></b-input>
                    </b-field>

                    <b-field label="Is Active" :label-position="labelPosition">
                        <b-radio-button name="taxonomies-is_active" dusk="taxonomies-is_active"
                                        v-model="item.is_active"
                                        :native-value=1>
                            <span>Yes</span>
                        </b-radio-button>

                        <b-radio-button type="is-danger" name="taxonomies-is_active"
                                        dusk="taxonomies-is_active"
                                        v-model="item.is_active"
                                        :native-value=null>
                            <span>No</span>
                        </b-radio-button>
                    </b-field>




                </div>
            </div>
            <!--/content-->


            <div class="modal"  :class="is_type_modal_active?'is-active':''">
                <div class="modal-background"></div>
                <div class="modal-content" style="width: 640px !important;">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                Taxonomy Types
                            </div>
                            <div class="card-header-icon">
                                <b-field>

                                    <tree-select style="width: 52%" v-model="taxo_type.parent_id"
                                                 placeholder="Select a Parent"
                                                 @select="onSelectType"
                                                 :clearable="false"
                                                 :normalizer="normalizer"
                                                 :multiple="false" :options="page.assets.types" >

                                    </tree-select>

                                    <b-input name="taxonomies-type-name" dusk="taxonomies-type-name"
                                             v-model="taxo_type.name"></b-input>

                                    <p class="control">
                                        <b-button @click="addType" class="button is-primary">Add</b-button>
                                    </p>
                                </b-field>
                            </div>

                        </div>
                        <div class="card-content">
                            <TreeView ref="text_view"
                                      :ajax_delete_url="ajax_url+'/deleteTaxonomyType'"
                                      :ajax_list_url="ajax_url+'/getTaxonomyType'">

                            </TreeView>
                        </div>

                    </div>

                </div>
                <button class="modal-close is-large"
                        @click="is_type_modal_active = false"
                        aria-label="close"></button>
            </div>


        </div>




    </div>
</template>


