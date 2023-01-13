<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import {useLocalizationStore} from '../../../stores/store-localization'
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
    await store.watchItem();
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
                            @click="store.toggleLanguageForm"
                    ></Button>
                    <Button icon="pi pi-plus"
                            label="Add Category"
                            @click="store.toggleCategoryForm"
                    ></Button>
                    <Button label="Reset" @click="store.resetQueryString"></Button>
                    <Button icon="pi pi-refresh" label="Sync" @click="store.sync()"></Button>
                </div>
            </div>
        </template>

        <template #content>
            <div class="flex align-items-center">
                <div class="mb-4" v-if="store.show_add_language">
                    <h5 class="p-1 text-xs mb-1">Add New Languages</h5>
                        <div class="level has-padding-bottom-25">
                            <div class="level-left">
                                <div  class="level-item">
                                    <div class="p-inputgroup ">
                                        <inputText
                                            name="localization-language-name"
                                            dusk="localization-language-name"
                                            v-model="store.new_language.name"
                                            placeholder="Name"
                                        />
                                        <inputText
                                            name="localization-language-local-code-iso-639"
                                            dusk="localization-language-local-code-iso-639"
                                            v-model="store.new_language.locale_code_iso_639"
                                            placeholder="Locale ISO 639 Code"
                                        />
                                        <Button @click="store.storeLanguage"
                                                icon="pi pi-plus"
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
                                            placeholder="Category Name"
                                        />
                                        <Button @click="store.storeCategory"
                                                icon="pi pi-plus"
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
                    <Dropdown v-model="store.selectedLanguage"
                              :options="store.languages"
                              optionLabel="name"
                              optionValue="id"
                              placeholder="Select a Language" />
                </div>
                <div class="col-4">
                    <div class="p-inputgroup ">
                        <Dropdown v-model="store.selectedCategory"
                                  :options="store.categories"
                                  optionLabel="name"
                                  optionValue="id"
                                  placeholder="Select a Category" />
                        <Dropdown v-model="store.selectedFilter"
                                  :options="store.filterOptions"
                                  optionLabel="name"
                                  optionValue="id"
                                  placeholder="Select a Filter" />
                    </div>
                </div>
            </div>
            <div class="grid mt-4">
                <div v-if="store.list" class="col-12 md:col-6" v-for="(item,index) in store.list.data">
                    <h5 class="p-1 text-xs mb-1">{{item.slug}}</h5>
                    <div class="p-inputgroup">
                        <inputText :model-value="item.content"
                                  :autoResize="true"
                                  class="has-min-height"/>
                        <Button icon="pi pi-copy"
                                class=" has-max-height"
                                @click="getCopy(item.content)"
                        />
                        <Button icon="pi pi-trash"
                                class="p-button-danger has-max-height"/>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>


<style scoped>

</style>
