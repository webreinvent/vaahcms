<script setup>
import { onMounted, ref, watchEffect } from "vue";
import { useTaxonomyStore } from '../../stores/store-taxonomies'
import { useRootStore } from "../../stores/root";
import { useRoute } from 'vue-router';
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useDialog } from "primevue/usedialog";
import TaxonomyTypeModal from "./components/TaxonomyTypeModal.vue";
import {vaah} from "../../vaahvue/pinia/vaah";

const store = useTaxonomyStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();

    /**
     * Fetch is_active select button's options and values
     */
    await root.getIsActiveStatusOptions();


    await store.getFormMenu();
});

//----item watcher
watchEffect(async () => {
    if (store.item && store.item.name) {
        store.item.slug = store.strToSlug(store.item.name);
    }
});


//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu



//--------toggle dynamic modal--------//
const dialog = useDialog();

const openTaxonomyTypeModal = () => {
    const dialogRef = dialog.open(TaxonomyTypeModal, {
        props: {
            header: 'Manage Taxonomy Type',
            style: {
                width: '50vw',
            },
            breakpoints:{
                '960px': '75vw',
                '640px': '90vw'
            },
            modal: true
        }
    });
}

//--------toggle dynamic modal--------//

</script>
<template>
    <div class="col-6" >
        <Panel>
            <template class="p-1" #header>
                <div class="flex flex-row">
                        <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            {{ store.item.name }}
                        </span>

                        <span v-else>
                            Create
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                    />

                    <template v-if="store.hasPermission('can-create-taxonomies') || store.hasPermission('can-update-taxonomies')">
                        <Button v-if="store.item && store.item.id"
                                class="p-button-sm"
                                label="Save"
                                icon="pi pi-save"
                                @click="store.itemAction('save')"
                        />

                        <Button v-else
                                class="p-button-sm"
                                label="Create & New"
                                icon="pi pi-save"
                                @click="store.itemAction('create-and-new')"
                        />
                    </template>

                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            @click="store.toView(store.item)"
                    />

                    <!--form_menu-->
                    <template v-if="store.hasPermission('can-create-taxonomies') || store.hasPermission('can-update-taxonomies')">
                        <Button type="button"
                                @click="toggleFormMenu"
                                data-testid="taxonomies-form-menu"
                                icon="pi pi-angle-down"
                                aria-haspopup="true"
                        />

                        <Menu ref="form_menu"
                              :model="store.form_menu_list"
                              :popup="true"
                        />
                    </template>
                    <!--/form_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            data-testid="taxonomies-to-list"
                            @click="store.toList()">
                    </Button>
                </div>
            </template>

            <div v-if="store.item">
                <VhField label="Type">
                    <div class="p-inputgroup">
                        <TreeSelect class="w-full"
                                    v-model="store.selected_parent_id"
                                    :options="store.assets.types"
                                    placeholder="Select a Parent"
                                    @node-select="store.selectedParent($event)"
                        />

                        <Button v-if="store.hasPermission('can-manage-taxonomy-types')"
                                class="p-button-sm"
                                label="Manage"
                                data-testid="taxonomies-form-to-manage-taxonomy-type-modal"
                                @click="openTaxonomyTypeModal"
                        />
                    </div>
                </VhField>

                <VhField label="Parent Country"
                         v-if=" store.item.type === 'cities' "
                >
                    <Dropdown v-model="store.item.parent_id"
                              :options="store.assets.countries"
                              optionLabel="name"
                              optionValue="code"
                              :filter="true"
                              placeholder="Select a Parent country"
                              class="p-inputtext-sm w-full"
                    />
                </VhField>

                <VhField label="Name">
                    <InputText class="w-full"
                               name="taxonomies-name"
                               data-testid="taxonomies-name"
                               v-model="store.item.name"
                    />
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full"
                               name="taxonomies-slug"
                               data-testid="taxonomies-slug"
                               v-model="store.item.slug"
                    />
                </VhField>

                <VhField label="Notes">
                    <Textarea class="w-full"
                              data-testid="taxonomies-notes"
                              name="taxonomies-notes"
                              v-model="store.item.notes"
                    />
                </VhField>

                <VhField label="Seo Title">
                    <InputText class="w-full"
                               name="taxonomies-seo-title"
                               data-testid="taxonomies-seo-tile"
                               v-model="store.item.seo_title"
                    />
                </VhField>

                <VhField label="Seo Keywords">
                    <Chips separator=","
                           inputClass="w-full"
                           name="taxonomies-seo-keywords"
                           data-testid="taxonomies-seo-keywords"
                           v-model="store.item.seo_keywords"
                    />

                </VhField>

                <VhField label="Seo Description">
                    <Textarea class="w-full"
                               name="taxonomies-seo-description"
                               data-testid="taxonomies-seo-description"
                               v-model="store.item.description"
                    />
                </VhField>

                <VhField label="Is Active">
                    <SelectButton v-if="root && root.is_active_status_options"
                                  :options="root.is_active_status_options"
                                  option-label="label"
                                  option-value="value"
                                  name="taxonomies-active"
                                  data-testid="taxonomies-active"
                                  v-model="store.item.is_active"
                    />
                </VhField>
            </div>
        </Panel>
    </div>
</template>
