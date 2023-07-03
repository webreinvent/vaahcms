<script setup>
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

    store.getFormMenu();

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

</script>
<template>
    <div class="col-6" >
        <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold text-sm">
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
                            data-testid="role-form_id"
                    />

                    <Button v-if="store.item && store.item.id"
                            class="p-button-sm"
                            label="Save"
                            icon="pi pi-save"
                            data-testid="role-edit_save"
                            @click="store.itemAction('save')"
                    />

                    <Button v-else
                            class="p-button-sm"
                            label="Create & New"
                            icon="pi pi-save"
                            data-testid="role-new_save"
                            @click="store.itemAction('create-and-new')"
                    />

                    <!--form_menu-->
                    <Button class="p-button-sm"
                            icon="pi pi-angle-down"
                            type="button"
                            aria-haspopup="true"
                            @click="toggleFormMenu"
                            data-testid="role-form_menu"
                            v-if="store.hasPermission('can-update-roles')
                                    || store.hasPermission('can-manage-roles')"
                    />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button v-if="(store.item && store.item.id) || store.hasPermission('can-read-roles')"
                            class="p-button-sm"
                            icon="pi pi-eye"
                            v-tooltip.top="'View'"
                            data-testid="role-item_view"
                            @click="store.toView(store.item)"
                    />

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="role-list_view"
                            @click="store.toList()"
                    />
                </div>
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
