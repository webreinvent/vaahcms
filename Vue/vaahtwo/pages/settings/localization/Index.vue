<script setup>
import {onMounted} from "vue";
import {useRoute} from 'vue-router';
import {useLocalizationStore} from '../../../stores/settings/store-localization'
import { useRootStore } from "../../../stores/root";

const root = useRootStore();
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
                    <b class="mr-1">{{root.assets.language_string.localization_settings.heading}}</b>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button icon="pi pi-plus"
                        :label="root.assets.language_string.localization_settings.add_language_button"
                        data-testid="localization-add_language"
                        @click="store.toggleLanguageForm"
                        class="p-button-sm mr-2"
                />

                <Button icon="pi pi-plus "
                        :label="root.assets.language_string.localization_settings.add_category_button"
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
            {{root.assets.language_string.localization_settings.localization_message}}
    </Message>

        <div class="flex align-items-center">
            <div class="mb-4" v-if="store.show_add_language">
                <h5 class="p-1 text-xs mb-1">{{root.assets.language_string.localization_settings.add_new_languages}}</h5>

                <div class="level has-padding-bottom-25">
                    <div class="level-left">
                        <div  class="level-item">
                            <div class="p-inputgroup ">
                                <inputText class="p-inputtext-sm"
                                           name="localization-language-name"
                                           v-model="store.new_language.name"
                                           data-testid="localization-new_language_name"
                                           :placeholder="root.assets.language_string.localization_settings.add_new_languages_placeholder_name"
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
                                        :label="root.assets.language_string.localization_settings.add_new_languages_save_button"
                                        class="p-button-sm"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4" v-if="store.show_add_category">
                <h5 class="p-1 text-xs mb-1">{{root.assets.language_string.localization_settings.add_new_category}}</h5>

                <div class="level has-padding-bottom-25" >

                    <!--left-->
                    <div class="level-left">
                        <div  class="level-item">
                            <div class="p-inputgroup ">
                                <inputText class="p-inputtext-sm"
                                           v-model="store.new_category.name"
                                           data-testid="localization-new_category_name"
                                           :placeholder="root.assets.language_string.localization_settings.add_new_category_placeholder_category_name"
                                />

                                <Button @click="store.storeCategory"
                                        icon="pi pi-plus"
                                        data-testid="localization-new_category_save"
                                        :label="root.assets.language_string.localization_settings.add_new_category_save_button"
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
                          :placeholder="root.assets.language_string.localization_settings.localization_placeholder_select_a_language"
                          inputClass="p-inputtext-sm"
                          class="is-small"
                />
            </div>

            <div class="col">
                <div class="p-inputgroup ">
                    <InputText class="p-inputtext-sm"
                               v-model="store.query_string.q"
                               @keyup.enter="store.delayedSearch()"
                               @keyup.enter.native="store.delayedSearch()"
                               @input="store.delayedSearch()"
                               :placeholder="root.assets.language_string.localization_settings.localization_placeholder_search"
                               data-testid="role-action_search_input"
                    />

                    <Button class="p-button-sm"
                            icon="pi pi-search"
                            data-testid="user-action_search"
                            @click="store.delayedSearch()"
                    />

                    <Dropdown v-model="store.query_string.cat_id"
                              :data-testid="'localization-category_filter'"
                              :options="store.categories"
                              optionLabel="name"
                              optionValue="id"
                              @change="store.getList()"
                              :placeholder="root.assets.language_string.localization_settings.localization_placeholder_select_a_category"
                              inputClass="p-inputtext-sm"
                    />

                    <Dropdown v-model="store.query_string.filter"
                              :options="[
                                       {name:root.assets.language_string.localization_settings.localization_empty_value, value:'empty'},
                                       {name:root.assets.language_string.localization_settings.localization_filled_value, value:'filled'}
                                  ]"
                              @change="store.getList()"
                              :data-testid="'localization-more_filter'"
                              optionLabel="name"
                              optionValue="value"
                              :placeholder="root.assets.language_string.localization_settings.localization_placeholder_select_a_filter"
                              inputClass="p-inputtext-sm"
                    />

                    <Button :label="root.assets.language_string.localization_settings.localization_reset_button"
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
                                  rows="1"
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
                {{root.assets.language_string.localization_settings.no_language_string_exist}}
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

                    <Button :label="root.assets.language_string.localization_settings.localization_add_string_button"
                            icon="pi pi-plus"
                            @click="store.addVariable"
                            :disabled="!store.new_variable"
                            class="p-button-sm"
                    />
                </div>
            </div>

            <div class="col-12">
                <div class="p-inputgroup justify-content-end">
                    <Button :label="root.assets.language_string.localization_settings.localization_generate_language_files"
                            data-testid="localization-generate_languafe_file"
                            icon="pi pi-refresh"
                            @click="store.generateLanguage"
                            class="p-button-sm"
                    />

                    <Button :label="root.assets.language_string.localization_settings.localization_save_button"
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
