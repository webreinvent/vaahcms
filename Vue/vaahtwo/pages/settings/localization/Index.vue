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
    await store.getAssets();
    /**
     * Change to upper case
     */
    document.title = 'Localization';
});
</script>
<template>
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h5 class="font-semibold text-lg">Localization</h5>
                <div class="p-inputgroup justify-content-end">
                    <Button icon="pi pi-plus"
                            label="Add Language"
                            data-testid="localization-add_language"
                            @click="store.toggleLanguageForm"
                    ></Button>
                    <Button icon="pi pi-plus"
                            label="Add Category"
                            data-testid="localization-add_category"
                            @click="store.toggleCategoryForm"
                    ></Button>
                    <Button label="Reset"
                            @click="store.removeQueryString"
                            data-testid="localization-reset"
                    ></Button>
                    <Button icon="pi pi-refresh"
                            label="Sync"
                            data-testid="localization-sync"
                            @click="store.sync()"></Button>
                </div>
            </div>
        </template>



        <template #content>

            <Message severity="warn" class="mt-0" :closable="false">
                When you make any changes in strings.
                You need to click on <strong>Generate Language Files</strong>
                button to reflect your changes.</Message>

            <div class="flex align-items-center">
                <div class="mb-4" v-if="store.show_add_language">
                    <h5 class="p-1 text-xs mb-1">Add New Languages</h5>
                    <div class="level has-padding-bottom-25">
                            <div class="level-left">
                                <div  class="level-item">
                                    <div class="p-inputgroup ">
                                        <inputText
                                            name="localization-language-name"
                                            v-model="store.new_language.name"
                                            data-testid="localization-new_language_name"
                                            placeholder="Name"
                                        ></inputText>
                                        <inputText
                                            name="localization-language-local-code-iso-639"
                                            data-testid="localization-new_language_code"
                                            v-model="store.new_language.locale_code_iso_639"
                                            placeholder="Locale ISO 639 Code"
                                        ></inputText>
                                        <Button @click="store.storeLanguage"
                                                icon="pi pi-plus"
                                                data-testid="localization-new_language_save"
                                                label="save"
                                        ></Button>
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
                                        <inputText
                                            v-model="store.new_category.name"
                                            data-testid="localization-new_category_name"
                                            placeholder="Category Name"
                                        ></inputText>
                                        <Button @click="store.storeCategory"
                                                icon="pi pi-plus"
                                                data-testid="localization-new_category_save"
                                                label="save"
                                        ></Button>

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
                              placeholder="Select a Language" >
                    </Dropdown>
                </div>
                <div class="col-8">
                    <div class="p-inputgroup ">
                        <Dropdown v-model="store.query_string.cat_id"
                                  :data-testid="'localization-category_filter'"
                                  :options="store.categories"
                                  optionLabel="name"
                                  optionValue="id"
                                  @change="store.getList()"
                                  placeholder="Select a Category" >
                        </Dropdown>
                        <Dropdown v-model="store.query_string.filter"
                                  :options="[
                                       {name:'Select a Filter', value:null},
                                       {name:'Empty value', value:'empty'},
                                       {name:'Filled value', value:'filled'}
                                  ]"
                                  @change="store.getList()"
                                  :data-testid="'localization-more_filter'"
                                  optionLabel="name"
                                  optionValue="value"
                                  placeholder="Select a Filter" >
                        </Dropdown>
                    </div>
                </div>
            </div>
            <div class="grid mt-4">
                <div v-if="store.list" class="col-12 md:col-6" v-for="(item,index) in store.list.data">
                    <h5 class="p-1 text-xs mb-1">{{item.slug}}</h5>
                    <div class="p-inputgroup">
                        <inputText v-model="item.content"
                                   :data-testid="'localization-'+item.slug"
                                   :autoResize="true"
                                   class="has-min-height">
                        </inputText>
                        <Button icon="pi pi-copy"
                                class=" has-max-height"
                                :disabled="!item.id"
                                data-testid="localization-copyString"
                                @click="store.getCopy(item)"
                        ></Button>
                        <Button icon="pi pi-trash"
                                data-testid="localization-deleteString"
                                @click="store.deleteString(item)"
                                class="p-button-danger has-max-height">
                        </Button>
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
                       :rowsPerPageOptions="store.rows_per_page">
            </Paginator>
            <div class="grid justify-content-start mt-5">
                <div class="col-12 md:col-6">
                    <div class="p-inputgroup">
                        <InputText :autoResize="true"
                                   v-model="store.new_variable"
                                   class="has-min-height"
                                   data-testid="localization-add_string"
                        ></InputText>
                        <Button label="Add String" icon="pi pi-plus"
                                @click="store.addVariable"
                                :disabled="!store.new_variable"
                        ></Button>
                    </div>
                </div>
                <div class="col-12 md:col-6">
                    <div class="p-inputgroup justify-content-end">
                        <Button label="Generate Language Files"
                                data-testid="localization-generate_languafe_file"
                                icon="pi pi-refresh"
                                @click="store.generateLanguage"
                        ></Button>
                        <Button label="Save"
                                data-testid="localization-save"
                                icon="pi pi-save"
                                @click="store.storeData"
                        ></Button>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>


<style scoped>

</style>
