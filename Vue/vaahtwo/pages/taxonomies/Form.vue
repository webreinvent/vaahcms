<script setup>
import {computed, onMounted, ref} from "vue";
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


//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

const tree_select_value = computed(() => {
    return {[store.item.vh_taxonomy_type_id]:true}
},(value)=>{

})


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
        <Panel class="is-small">
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

                    <template v-if="store.hasPermission('can-create-taxonomies') ||
                    store.hasPermission('can-update-taxonomies')">
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
                    <template v-if="store.hasPermission('can-manage-taxonomies') ||
                    store.hasPermission('can-update-taxonomies')">
                        <Button type="button"
                                @click="toggleFormMenu"
                                data-testid="taxonomies-form-menu"
                                icon="pi pi-angle-down"
                                aria-haspopup="true"
                                class="p-button-sm"
                        />

                        <Menu ref="form_menu"
                              :model="store.form_menu_list"
                              :popup="true"
                        />
                    </template>
                    <!--/form_menu-->

                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="taxonomies-to-list"
                            @click="store.toList()">
                    </Button>
                </div>
            </template>

            <div v-if="store.item" class="pt-2">
                <VhField label="Type">
                    <div class="p-inputgroup">
                        <TreeSelect class="w-full"
                                    v-model="tree_select_value"
                                    :options="store.assets.types"
                                    placeholder="Select a type"
                                    @node-select="store.selectType($event)"
                        />

                        <Button v-if="store.hasPermission('can-manage-taxonomy-types')"
                                class="p-button-sm"
                                label="Manage"
                                data-testid="taxonomies-form-to-manage-taxonomy-type-modal"
                                @click="openTaxonomyTypeModal"
                        />
                    </div>
                </VhField>

                <VhField label="Parent"
                         v-if="store.item.type
                         && store.item.type.parent_id"
                >
                    <Dropdown v-model="store.item.parent_id"
                              :options="store.parent_options"
                              optionLabel="name"
                              optionValue="id"
                              :filter="true"
                              placeholder="Select a Parent"
                              class="p-inputtext-sm w-full"
                    />
                </VhField>

                <VhField label="Name">
                    <InputText class="w-full p-inputtext-sm"
                               name="taxonomies-name"
                               data-testid="taxonomies-name"
                               @update:modelValue="store.watchItem"
                               v-model="store.item.name"
                    />
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full p-inputtext-sm"
                               name="taxonomies-slug"
                               data-testid="taxonomies-slug"
                               v-model="store.item.slug"
                    />
                </VhField>

                <VhField label="Notes">
                    <Textarea class="w-full p-inputtext-sm"
                              data-testid="taxonomies-notes"
                              name="taxonomies-notes"
                              v-model="store.item.notes"
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
