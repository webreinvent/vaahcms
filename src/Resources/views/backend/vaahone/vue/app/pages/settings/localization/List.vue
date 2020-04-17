<script src="./ListJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Localization
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button @click="toggleLanguageForm"
                                                  type="is-light"
                                                  icon-left="plus">
                                            Add Language
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button @click="toggleCategoryForm"
                                                  type="is-light"
                                                  icon-left="plus">
                                            Add Category
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button @click="resetQueryString"
                                                  type="is-light">
                                            Reset
                                        </b-button>
                                    </p>
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="topSync()"
                                                  :loading="is_top_btn_loading"
                                                  icon-left="redo-alt">
                                            Sync
                                        </b-button>
                                    </p>

                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content">



                            <div class="block">

                                <div v-if="show_add_language">
                                    <p class="has-text-weight-bold is-size-6 has-padding-bottom-10">
                                        Add New Languages
                                    </p>


                                    <div class="level has-padding-bottom-25">

                                        <!--left-->
                                        <div class="level-left">
                                            <div  class="level-item">
                                                <b-field >
                                                    <b-input type="text"
                                                             v-model="new_language.name"
                                                             placeholder="Name">
                                                    </b-input>
                                                    <b-input type="text"
                                                             v-model="new_language.locale_code_iso_639"
                                                             placeholder="Locale ISO 639 Code">
                                                    </b-input>
                                                    <p class="control">
                                                        <button  @click="storeLanguage()" class="button is-primary">
                                                            Save
                                                        </button>
                                                    </p>
                                                </b-field>

                                            </div>
                                        </div>
                                        <!--/left-->


                                        <!--right-->
                                        <!--/right-->

                                    </div>
                                </div>

                                <div v-if="show_add_category">
                                    <p class="has-text-weight-bold is-size-6 has-padding-bottom-10">
                                        Add New Category
                                    </p>


                                    <div class="level has-padding-bottom-25" >

                                        <!--left-->
                                        <div class="level-left">
                                            <div  class="level-item">
                                                <b-field >
                                                    <b-input type="text"
                                                             v-model="new_category.name"
                                                             placeholder="Category Name">
                                                    </b-input>
                                                    <p class="control">
                                                        <button @click="storeCategory" class="button is-primary">
                                                            Save
                                                        </button>
                                                    </p>

                                                </b-field>
                                            </div>
                                        </div>
                                        <!--/left-->


                                        <!--right-->
                                        <!--/right-->

                                    </div>
                                </div>

                                <!--filters-->
                                <!--/filters-->


                                <!--list-->
                                <div class="block ">

                                    <div class="block" style="margin-bottom: 0px;" >

                                        <!--tab-->
                                        <div v-if="page && page.assets && page.assets.languages && page.assets.languages">

                                            <b-tabs v-model="activeSubTab"
                                                    :position="atRight ? 'is-right' : ''"
                                                    :size="size"
                                                    :type="type"
                                                    @input="selectTab"
                                                    vertical
                                                    :animated=false
                                                    :expanded="expanded">

                                                <b-tab-item v-for="(language,index) in page.assets.languages.list" v-bind:data="language"
                                                            v-bind:key="index" :label="language.locale_code_iso_639+' ('+language.not_empty+'/'+language.total+')'">
                                                    <div class="level">
                                                        <div class="level-left has-text-weight-bold is-size-5">
                                                                {{language.name}} ({{language.locale_code_iso_639}})

                                                        </div>
                                                        <div class="level-right">
                                                            <b-field>
                                                                <b-select @input="showCategoryData" v-model="page.assets.categories.default.id" placeholder="- Select a category -">
                                                                    <option value="">
                                                                        - Select a category -
                                                                    </option>
                                                                    <option v-for="category in page.assets.categories.list"
                                                                            :value="category.id"
                                                                    >
                                                                        {{category.name}}
                                                                    </option>
                                                                </b-select>
                                                                <p class="control">
                                                                    <button @click="showCategoryData" class="button is-primary"
                                                                            >
                                                                        Show
                                                                    </button>
                                                                </p>
                                                                <p class="control">
                                                                    <button class="button is-primary"
                                                                            @click="toggleFilters()"
                                                                            slot="trigger">
                                                                        <b-icon icon="ellipsis-v"></b-icon>
                                                                    </button>
                                                                </p>
                                                            </b-field>

                                                        </div>

                                                    </div>

                                                    <!--filters-->
                                                    <div class="level" v-if="show_filters">

                                                        <div class="level-left">



                                                            <div class="level-item">

                                                                <b-field label="">
                                                                    <b-select placeholder="- Select a filter -" v-model="query_string.filter" @input="getList()">
                                                                        <option value="">
                                                                            - Select a filter -
                                                                        </option>
                                                                        <option value='filled'>
                                                                            Filled Value
                                                                        </option>
                                                                        <option value='empty'>
                                                                            Empty Value
                                                                        </option>
                                                                    </b-select>
                                                                </b-field>


                                                            </div>

                                                        </div>


                                                    </div>
                                                    <!--/filters-->

                                                    <table v-if="list" class="table">
                                                        <template v-if="list && list.data && list.data.length > 0">
                                                            <tr  v-for="item in list.data">
                                                                <td width="20">

                                                                    <vh-copy v-if="active_category && item.slug" :data="'{!! trans(\'vaahcms-'+active_category.slug+'.'+item.slug+'\') !!}'"
                                                                             confirm_dialog="buefy">
                                                                        <b-icon icon="copy"></b-icon>
                                                                    </vh-copy>

                                                                    <vh-copy v-else
                                                                             confirm_dialog="buefy">
                                                                        <b-icon icon="copy"></b-icon>
                                                                    </vh-copy>

                                                                </td>
                                                                <td width="150">
                                                                    <input type="text" class="input is-borderless"
                                                                           @blur="setItemSlug(item)"
                                                                           placeholder="Type Slug" v-model="item.slug" />

                                                                </td>
                                                                <td >
                                                                    <input type="text" class="input is-borderless"
                                                                           placeholder="Type Value" v-model="item.content" />
                                                                </td>
                                                                <td width="20">
                                                                    <b-button outlined type="is-danger"
                                                                              @click="deleteString(item)"
                                                                              size="is-small"
                                                                              icon-left="trash">
                                                                    </b-button>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                        <template v-else >
                                                            <hr class="is-marginless" />
                                                            <tr>
                                                                <td class="has-text-danger is-size-6">
                                                                    No language string exist
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </table>

                                                    <div v-else class="block" >
                                                        <Loader/>
                                                    </div>



                                                    <div class="block" v-if="list && list.data">
                                                        <vh-pagination  :limit="1" :data="list"
                                                                        @onPageChange="paginate">
                                                        </vh-pagination>
                                                    </div>


                                                    <div class="level">
                                                        <div class="level-left">
                                                            <b-field v-if="page.assets.categories.default.id">
                                                                <p class="control">
                                                                    <button @click="addString(language.id,page.assets.categories.default.id)" class="button is-light">
                                                                        Add String
                                                                    </button>
                                                                </p>
                                                                <p class="control">
                                                                    <button @click="store(language.id)" class="button is-primary">
                                                                        Save
                                                                    </button>
                                                                </p>
                                                            </b-field>

                                                        </div>
                                                        <div class="level-right">
                                                            <b-field>
                                                                <p class="control">
                                                                    <b-button type="is-success"
                                                                              @click="sync()"
                                                                              :loading="is_btn_loading"
                                                                              icon-left="redo-alt">
                                                                        Generate Language Files
                                                                    </b-button>
                                                                </p>
                                                            </b-field>

                                                        </div>

                                                    </div>


                                                </b-tab-item>

                                            </b-tabs>

                                        </div>
                                        <!--tab end-->


                                    </div>



                                </div>
                                <!--/list-->


                            </div>
                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->

                <router-view @eReloadList="getList"></router-view>

            </div>


        </div>

    </div>
</template>


