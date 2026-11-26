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
import { usePermissionStore } from '../../stores/store-permissions';
import { vaah } from '../../vaahvue/pinia/vaah';
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useRoute } from 'vue-router';
import { useRootStore } from '../../stores/root';


const store = usePermissionStore();
const route = useRoute();
const useVaah = vaah();
const root = useRootStore();

onMounted(async () => {
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    if (root.assets && root.assets.language_strings
        && root.assets.language_strings.crud_actions)
    {
        await store.getFormMenu();
    }

    await root.getIsActiveStatusOptions();
});

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

    <div class="col-5">
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
                    <Button size="small" class="" v-if="store.item && store.item.id" :label=" '#' + store.item.id" @click="useVaah.copy(store.item.id)" data-testid="permission-form_id" />

                    <Button size="small" class="" :label="root.assets.language_strings.crud_actions.save_button" icon="pi pi-save" data-testid="permission-form_save" @click="store.itemAction('save')" />

                    <!--form_menu-->
                    <Button size="small" class="" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" type="button" data-testid="permission-form_menu" @click="toggleFormMenu" v-if="store.hasPermission('can-update-permissions') || store.hasPermission('can-manage-permissions')" />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button size="small" class="" icon="pi pi-eye" aria-label="View" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view" data-testid="permission-item_view" @click="store.toView(store.item)" v-if="store.hasPermission('can-read-permissions')" />

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="permission-list_view" @click="store.toList()" />
                </InputGroup>
            </template>

            <div v-if="store.item" class="pt-2">

                <VhField label="Name">
                    <InputText class="w-full" v-model="store.item.name" data-testid="permission-item_name" />
                </VhField>

                <VhField label="Slug">
                    <InputText class="w-full" v-model="store.item.slug" data-testid="permission-item_slug"/>
                </VhField>

                <VhField label="Details">
                    <Textarea class="w-full" v-model="store.item.details" data-testid="permission-item_details"/>
                </VhField>

                <VhField label="Is Active">
                    <SelectButton v-if="root && root.is_active_status_options"
                                  v-model="store.item.is_active"
                                  :options="root.is_active_status_options"
                                  option-label="label"
                                  option-value="value"
                                  data-testid="permission-item_status"
                                  class="has-shadowless"
                    />
                </VhField>
            </div>
        </Panel>
    </div>
</template>
