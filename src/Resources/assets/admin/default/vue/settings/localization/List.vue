<script src="./ListJs.js"></script>
<template>

    <div class="row" v-if="assets && active_language && active_category">

        <div class="col-sm">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex">
                        <div class="align-self-center tx-18 flex-grow-1"><strong>Localization</strong></div>
                        <div class=" mg-l-auto btn-group btn-group-xs">


                            <button class="btn btn-xs btn-light btn-uppercase"
                                         @click="toggleLanguageForm()">
                                <i class="fas fa-plus"></i> Add Language
                            </button>

                            <button class="btn btn-xs btn-light btn-uppercase"
                                    @click="toggleCategoryForm()">
                                <i class="fas fa-plus"></i> Add Category
                            </button>

                            <button class="btn btn-xs btn-light btn-uppercase"
                                    @click="sync()">
                                <i class="fas fa-sync-alt"></i> Sync
                            </button>

                        </div>
                    </div>

                </div>
                <div class="card-body pd-b-0 " >

                    <!--add language-->
                    <div class="form-row" v-if="show_add_language">
                        <div class="form-group mg-b-0 col-md-4">
                            <label><strong>Add New Language</strong></label>
                            <div class="input-group input-group-sm" style="max-width: 350px;">
                                <input type="text" class="form-control"
                                       v-model="new_language.name"
                                       placeholder="Name" />
                                <input type="text" class="form-control"
                                       v-model="new_language.locale_code_iso_639"
                                       placeholder="Locale ISO 639 Code" />

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary"
                                            @click="storeLanguage()"
                                            type="button">Save</button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/add category-->

                    <!--add category-->
                    <div class="form-row" v-if="show_add_category">
                        <div class="form-group mg-b-0 col-md-4">
                            <label><strong>Add New Category</strong></label>
                            <div class="input-group input-group-sm" style="max-width: 350px;">
                                <input type="text" class="form-control"
                                       v-model="new_category.name"
                                       placeholder="Category Name" />

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary"
                                            @click="storeCategory"
                                            type="button">Save</button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--/add category-->


                </div>
                <div class="card-body">


                    <div class="row mg-b-10">

                        <div class="col-sm-12">





                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="media align-items-stretch">
                                <!--tabs-->
                                <ul class="nav nav-tabs flex-column"  role="tablist">

                                    <li class="nav-item" v-for="language in assets.languages.list">
                                        <a class="nav-link "
                                           href="#"
                                           @click="setActiveLanguage($event, language)"
                                           :class="{'active': language.id == active_language.id}"
                                           aria-selected="true">{{language.locale_code_iso_639}}</a>
                                    </li>

                                </ul>
                                <!--/tabs-->
                                <div class="media-body">
                                    <div class="tab-content bd bd-gray-300 bd-l-0 pd-t-8  pd-r-20  pd-b-20 pd-l-20" >
                                        <div class="tab-pane fade show active" id="tab-lang-en"
                                             role="tabpanel" aria-labelledby="home-tab4">

                                            <!--body-header-->
                                            <div class="d-flex mg-b-20">

                                                <div class="flex-grow-1 pd-t-5">
                                                    <h6>
                                                        {{active_language.name}}
                                                        ({{active_language.locale_code_iso_639}})
                                                    </h6>
                                                </div>
                                                <div class="">
                                                    <div class="input-group input-group-sm" style="max-width: 350px;">
                                                        <select class="custom-select"
                                                                v-model="active_category_id"
                                                                style="max-width: 150px" >
                                                            <option value="">Select Category</option>
                                                            <option v-for="category in assets.categories.list"
                                                                    :value="category.id"
                                                            >
                                                                {{category.name}}
                                                            </option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" @click="bulkAction" type="button">Show</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--/body-header-->

                                            <!--list-->
                                            <table class="table table-form-merge">

                                                <tbody>

                                                <template v-if="list && list.length > 0">
                                                    <tr  v-for="item in list">
                                                        <td width="20">

                                                            <vh-copy :data="'@lang(\''+active_category.slug+'.'+item.slug+'\')'"
                                                                     :label="icon_copy"
                                                                     @copied="copiedData"
                                                            >
                                                            </vh-copy>


                                                        </td>
                                                        <td width="150">

                                                            <input type="text" class="form-control-merge"
                                                                   @blur="setItemSlug(item)"
                                                                   placeholder="Type Slug" v-model="item.slug" />

                                                        </td>
                                                        <td >
                                                            <input type="text" class="form-control-merge"
                                                                   placeholder="Type Value" v-model="item.content" />
                                                        </td>
                                                        <td width="20">
                                                            <button  class="btn btn-xs" @click="deleteString(item)" style="padding: 0px;">
                                                                <i class="fas fa-trash"> </i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="4">
                                                            <span class="text-danger">No language string exist.</span>
                                                        </td>
                                                    </tr>
                                                </template>

                                                </tbody>



                                                <tfoot>

                                                <tr>
                                                    <td colspan="4">
                                                        <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-light btn-sm" @click="addString()">Add String</button>
                                                        <button class="btn btn-primary btn-sm" @click="store()">Save</button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tfoot>

                                            </table>
                                            <!--/list-->

                                        </div>
                                    </div>
                                </div><!-- media-body -->
                            </div>

                        </div>

                    </div>


                </div>

            </div>


        </div>


    </div>

</template>
