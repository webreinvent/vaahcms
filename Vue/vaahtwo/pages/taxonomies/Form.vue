<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {computed, onMounted, ref} from "vue";
import { useTaxonomyStore } from '../../stores/store-taxonomies'
import { useRootStore } from "../../stores/root";
import { useRoute } from 'vue-router';
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useDialog } from "openvue/usedialog";
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
        <Panel class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                        <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            {{ store.item.name }}
                        </span>

                            <span v-else-if="root.assets
                                         && root.assets.language_strings
                                         && root.assets.language_strings.crud_actions"
                            >
                            {{root.assets.language_strings.crud_actions.form_text_create}}
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup v-if="root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions">
                    <Button size="small" v-if="store.item && store.item.id" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" />

                    <template v-if="store.hasPermission('can-create-taxonomies') ||
                    store.hasPermission('can-update-taxonomies')">
                        <Button size="small" v-if="store.item && store.item.id" class="" :label="root.assets.language_strings.crud_actions.save_button" icon="pi pi-save" @click="store.itemAction('save')" />

                        <Button size="small" v-else class="" :label="root.assets.language_strings.crud_actions.form_create_and_new" icon="pi pi-save" @click="store.itemAction('create-and-new')" />
                    </template>

                    <Button size="small" v-if="store.item && store.item.id" class="" icon="pi pi-eye" aria-label="View" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" @click="store.toView(store.item)" />

                    <!--form_menu-->
                    <template v-if="store.hasPermission('can-manage-taxonomies') ||
                    store.hasPermission('can-update-taxonomies')">
                        <Button size="small" type="button" @click="toggleFormMenu" data-testid="taxonomies-form-menu" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" class="" />

                        <Menu ref="form_menu"
                              :model="store.form_menu_list"
                              :popup="true"
                        />
                    </template>
                    <!--/form_menu-->

                    <Button size="small" class="p-button-primary" icon="pi pi-times" aria-label="Back to list" data-testid="taxonomies-to-list" @click="store.toList()">
                    </Button>
                </InputGroup>
            </template>

            <div v-if="store.item" class="pt-2">
                <VhField label="Type">
                    <InputGroup>
                        <!-- UT-100 (M6-T4a Batch 21) — the tree select's trigger is
                             its own `role="button"` element and it had no
                             accessible name (WCAG 2.2 SC 4.1.2). The name is set
                             through the engine's pass-through property, on the
                             inner section the component calls "dropdown". -->
                        <TreeSelect class="w-full"
                                    v-model="tree_select_value"
                                    :options="store.assets.types"
                                    :placeholder="store.assets.language_strings.taxonomy_type_placeholder_select_type"
                                    @node-select="store.selectType($event)"
                                    :pt="{ dropdown: { 'aria-label': store.assets.language_strings.taxonomy_type_placeholder_select_type } }"
                        />

                        <Button size="small" v-if="store.hasPermission('can-manage-taxonomy-types')" class="" :label="store.assets.language_strings.form_manage_button" data-testid="taxonomies-form-to-manage-taxonomy-type-modal" @click="openTaxonomyTypeModal" />
                    </InputGroup>
                </VhField>

                <VhField label="Parent"
                         v-if="store.item.type
                         && store.item.type.parent_id"
                >
                    <Select size="small" v-model="store.item.parent_id" :options="store.parent_options" optionLabel="name" optionValue="id" :filter="true" :placeholder="store.assets.language_strings.taxonomy_type_placeholder_select_parent" class=" w-full" />
                </VhField>

                <VhField label="Name">
                    <InputText size="small" class="w-full" name="taxonomies-name" data-testid="taxonomies-name" @update:modelValue="store.watchItem" v-model="store.item.name" />
                </VhField>

                <VhField label="Slug">
                    <InputText size="small" class="w-full" name="taxonomies-slug" data-testid="taxonomies-slug" v-model="store.item.slug" />
                </VhField>

                <VhField label="Notes">
                    <Textarea size="small" class="w-full" data-testid="taxonomies-notes" name="taxonomies-notes" v-model="store.item.notes" />
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
