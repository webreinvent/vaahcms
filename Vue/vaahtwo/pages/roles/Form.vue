<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import { useRoleStore } from '../../stores/store-roles';
import { useRootStore } from "../../stores/root";
import { vaah } from '../../vaahvue/pinia/vaah';
import { useRoute } from 'vue-router';
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'


const store = useRoleStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }

    if (root.assets && root.assets.language_strings
        && root.assets.language_strings.crud_actions)
    {
        await store.getFormMenu();
    }

    await root.getIsActiveStatusOptions();
});
//----item watcher
watch(store.item, async (newVal, oldVal) => {
    store.item.slug = store.strToSlug(newVal.name);
})
//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu
watch(
    () => root.assets,
    async () => {
        if ( root.assets.language_strings && root.assets.language_strings.crud_actions)
        {
            await store.getFormMenu();
        }

    }
)
</script>
<template>
    <div class="col-6" >
        <Panel class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold vc-text-16">
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
                    <Button size="small" v-if="store.item && store.item.id" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" data-testid="role-form_id" />

                    <Button size="small" v-if="store.item && store.item.id" class="" :label="root.assets.language_strings.crud_actions.save_button" icon="pi pi-save" data-testid="role-edit_save" @click="store.itemAction('save')" />

                    <Button size="small" v-else class="" :label="root.assets.language_strings.crud_actions.form_create_and_new" icon="pi pi-save" data-testid="role-new_save" @click="store.itemAction('create-and-new')" />

                    <!--form_menu-->
                    <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" type="button" aria-haspopup="true" @click="toggleFormMenu" data-testid="role-form_menu" v-if="store.hasPermission('can-update-roles') || store.hasPermission('can-manage-roles')" />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button size="small" v-if="(store.item && store.item.id) && store.hasPermission('can-read-roles')" class="" icon="pi pi-eye" aria-label="View" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" data-testid="role-item_view" @click="store.toView(store.item)" />

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="role-list_view" @click="store.toList()" />
                </InputGroup>
            </template>

            <div v-if="store.item" class="mt-2">
                <VhField label="Name">
                    <InputText class="w-full"
                               v-model="store.item.name"
                               @update:modelValue="store.watchItem"
                               data-testid="role-item_name" />
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full"
                               v-model="store.item.slug"
                               data-testid="role-item_slug" />
                </VhField>

                <VhField label="Details">
                    <Textarea class="w-full"
                              v-model="store.item.details"
                              data-testid="role-item_details" />
                </VhField>

                <VhField label="Is Active">
                    <SelectButton v-if="root && root.is_active_status_options"
                                  v-model="store.item.is_active"
                                  data-testid="role-item_status"
                                  :options="root.is_active_status_options"
                                  option-label="label"
                                  option-value="value"
                    />
                </VhField>
            </div>
        </Panel>
    </div>

</template>
