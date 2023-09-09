<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import {useLocalizationStore} from '../../../stores/settings/store-localization'
const store = useLocalizationStore();
const route = useRoute();
import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);
    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();
    /**
     * Change to upper case
     */
});
</script>

<template>
    <Panel class="is-small">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <b class="mr-1">Localizations</b>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button icon="pi pi-plus"
                        label="Add Language"
                        data-testid="localization-add_language"
                        @click="store.toggleLanguageForm"
                        class="p-button-sm mr-2"
                />

                <Button icon="pi pi-plus "
                        label="Add Category"
                        data-testid="localization-add_category"
                        @click="store.toggleCategoryForm"
                        class="p-button-sm mr-2"
                />

                <Button icon="pi pi-refresh"
                        data-testid="localization-sync"
                        @click="store.sync()"
                        class="p-button-sm"
                        v-tooltip.top="'Sync'"
                        :loading="store.btn_is_loading"
                />
            </div>
        </template>
        <Message severity="warn" class="mt-1" :closable="false">
        When you make any changes in strings.
        You need to click on <strong>Generate Language Files</strong>
        button to reflect your changes.
    </Message>

        <div class="flex align-items-center">
            <div class="mb-4" v-if="store.show_add_language">
                <h5 class="p-1 text-xs mb-1">Add New Languages</h5>

                <div class="level has-padding-bottom-25">
                    <div class="level-left">
                        <div  class="level-item">
                            <div class="p-inputgroup ">
                                <inputText class="p-inputtext-sm"
                                           name="localization-language-name"
                                           v-model="store.new_language.name"
                                           data-testid="localization-new_language_name"
                                           placeholder="Name"
                                />

                                <inputText class="p-inputtext-sm"
                                           name="localization-language-local-code-iso-639"
                                           data-testid="localization-new_language_code"
                                           v-model="store.new_language.locale_code_iso_639"
                                           placeholder="Locale ISO 639 Code"
                                />

                                <Button @click="store.storeLanguage"
                                        icon="pi pi-plus"
                                        data-testid="localization-new_language_save"
                                        label="save"
                                        class="p-button-sm"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4" v-if="store.show_add_category">
                <h5 class="p-1 text-xs mb-1">Add New Category</h5>

                <div class="level has-padding-bottom-25" >

                    <!--left-->
                    <div class="level-left">
                        <div  class="level-item">
                            <div class="p-inputgroup ">
                                <inputText class="p-inputtext-sm"
                                           v-model="store.new_category.name"
                                           data-testid="localization-new_category_name"
                                           placeholder="Category Name"
                                />

                                <Button @click="store.storeCategory"
                                        icon="pi pi-plus"
                                        data-testid="localization-new_category_save"
                                        label="save"
                                        class="p-button-sm"
                                />
                            </div>
                        </div>
                    </div>
                    <!--/left-->
                    <!--right-->
                    <!--/right-->
                </div>
            </div>
        </div>

        <div class="grid justify-content-between">
            <div class="col-4 align-items-center flex">
                <Dropdown v-model="store.query_string.lang_id"
                          :options="store.languages"
                          :data-testid="'localization-language_filter'"
                          optionLabel="option_label"
                          optionValue="id"
                          @change="store.getList()"
                          placeholder="Select a Language"
                          inputClass="p-inputtext-sm"
                          class="is-small"
                />
            </div>

            <div class="col-5">
                <div class="p-inputgroup ">
                    <Dropdown v-model="store.query_string.cat_id"
                              :data-testid="'localization-category_filter'"
                              :options="store.categories"
                              optionLabel="name"
                              optionValue="id"
                              @change="store.getList()"
                              placeholder="Select a Category"
                              inputClass="p-inputtext-sm"
                    />

                    <Dropdown v-model="store.query_string.filter"
                              :options="[
                                       {name:'Empty value', value:'empty'},
                                       {name:'Filled value', value:'filled'}
                                  ]"
                              @change="store.getList()"
                              :data-testid="'localization-more_filter'"
                              optionLabel="name"
                              optionValue="value"
                              placeholder="Select a Filter"
                              inputClass="p-inputtext-sm"
                    />

                    <Button label="Reset"
                            icon="pi pi-filter-slash"
                            @click="store.removeQueryString"
                            data-testid="localization-reset"
                            class="p-button-sm"
                    />
                </div>
            </div>
        </div>

        <div class="grid mt-1">
            <div v-if="store.list" class="col-12 md:col-6" v-for="(item,index) in store.list.data">
                <h5 class="p-1 text-xs mb-1">{{item.slug}}</h5>

                <div class="p-inputgroup">
                        <Textarea v-model="item.content"
                                  :data-testid="'localization-'+item.slug"
                                  :auto-resize="true"
                        />

                    <Button icon="pi pi-copy"
                            :disabled="!item.id"
                            data-testid="localization-copyString"
                            @click="store.getCopy(item)"
                    />

                    <Button icon="pi pi-trash"
                            data-testid="localization-deleteString"
                            @click="store.deleteString(item)"
                            class="p-button-danger p-button-sm"
                    />
                </div>
            </div>

            <div v-else>
                No language string exist
            </div>
        </div>

        <Paginator v-if="store.list"
                   v-model:rows="store.filters.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0"
        />

        <div class="grid justify-content-start mt-1">
            <div class="col-12">
                <div class="p-inputgroup">
                    <InputText class="p-inputtext-sm"
                               v-model="store.new_variable"
                               data-testid="localization-add_string"
                    />

                    <Button label="Add String" icon="pi pi-plus"
                            @click="store.addVariable"
                            :disabled="!store.new_variable"
                            class="p-button-sm"
                    />
                </div>
            </div>

            <div class="col-12">
                <Divider class="mb-3 mt-0"/>
                <div class="p-inputgroup justify-content-end">
                    <Button label="Generate Language Files"
                            data-testid="localization-generate_languafe_file"
                            icon="pi pi-refresh"
                            @click="store.generateLanguage"
                            class="p-button-sm"
                    />

                    <Button label="Save"
                            data-testid="localization-save"
                            icon="pi pi-save"
                            @click="store.storeData"
                            class="p-button-sm"
                    />
                </div>
            </div>
        </div>
    </Panel>
</template>
