<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah';
import {useUserSettingStore} from "../../../stores/settings/store-user_setting";

const store = useUserSettingStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();
});
</script>

<template>
    <div>
        <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div>
                        <b class="mr-1">General Settings</b>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button label="Expand all" icon="pi pi-angle-double-down" class="p-button-sm mr-2"
                            @click="store.expandAll"></Button>
                    <Button label="Collapse all" icon="pi pi-angle-double-up" class="p-button-sm"
                            @click="store.collapseAll"></Button>
                </div>
            </template>
            <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer">
                <AccordionTab >
                    <template #header>
                        <div class="w-full">
                            <div>
                                <h5 class="font-semibold text-sm">Fields</h5>
                            </div>
                        </div>
                    </template>

                    <DataTable :value="store.field_list"
                               class="p-datatable-sm p-datatable-hoverable-rows"
                               stripedRows
                               responsiveLayout="scroll"
                    >
                        <Column field="fieldName" header="Field Name">
                            <template #body="slotProps">
                                {{ vaah().toLabel(slotProps.data.key) }}
                            </template>
                        </Column>

                        <Column field="visibilityStatus" header="Is Hidden">
                            <template #body="slotProps">
                                <InputSwitch v-model="slotProps.data.value.is_hidden"
                                             data-testid="setting-field_is_hidden"
                                             class="is-small"
                                             @input="store.storeField(slotProps.data)"
                                />
                            </template>
                        </Column>

                        <Column field="applyToRegistration" header="Apply To Registration">
                            <template #body="slotProps">
                                <Checkbox v-model="slotProps.data.value.to_registration"
                                          @input="store.storeField(slotProps.data)"
                                          data-testid="setting-field_to_registration"
                                          :binary="true"
                                          class="is-small"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </AccordionTab>

                <AccordionTab>
                    <template #header>
                        <div class="w-full">
                            <div>
                                <h5 class="font-semibold text-sm">Custom Fields</h5>
                            </div>
                        </div>
                    </template>

                    <Message severity="info" class="mt-0">
                        The inputs of these fields will be stored in <strong>meta</strong> column.
                    </Message>

                    <div class="col-12 m-2">
                        <div v-if="store.custom_field_list && store.custom_field_list.value
                                       && store.custom_field_list.value.length > 0"
                        >
                            <draggable item-key="id"
                                       v-model="store.custom_field_list.value"
                                       class="dragArea list-group"
                                       group="content-types"
                                       @start="drag=true"
                                       @end="drag=false"
                            >
                                <template #item = {element,index}>
                                    <div class="content-div"
                                    >
                                        <div class="p-inputgroup mb-3">
                                            <Button label=":::"
                                                    class="drag p-button-sm"
                                                    data-testid="setting-customfield_drag_btn"
                                            />
                                            <InputText class="w-2 p-inputtext-sm"
                                                       :model-value="vaah().toLabel(element.type)"
                                                       disabled
                                            />

                                            <InputText class="w-6 p-inputtext-sm"
                                                       v-model="element.name"
                                                       data-testid="setting-customfield_name"
                                                       @input="store.onInputFieldName(element)"
                                                       placeholder="Field Name"
                                            />

                                            <Button icon="pi pi-cog p-button-sm"
                                                    data-testid="setting-customfield_toggle"
                                                    @click="store.toggleFieldOptions"
                                                    class="p-button-sm"
                                            />

                                            <Button icon="pi pi-trash p-button-sm"
                                                    data-testid="setting-customfield_remove"
                                                    @click="store.deleteGroupField(index)"
                                                    class="p-button-sm"
                                            />
                                        </div>

                                        <div class="inactive">
                                            <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm p-datatable-hoverable-rows">
                                                <table class="p-datatable-table">
                                                    <tbody class="p-datatable-tbody">
                                                    <tr>
                                                        <td>Is hidden</td>

                                                        <td class="text-right">
                                                            <InputSwitch v-model="element.is_hidden"
                                                                         data-testid="setting-customfield_is_hidden"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="is-small"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Apply to Registration</td>

                                                        <td class="text-right">
                                                            <InputSwitch v-model="element.to_registration"
                                                                         data-testid="setting-customfield_to_registration"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="is-small"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr v-if="element.type === 'password'">
                                                        <td>Is Password Reveal</td>

                                                        <td>
                                                            <InputSwitch v-model="element.is_password_reveal"
                                                                         data-testid="setting-customfield_is_password_reveal"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="is-small"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Min-Length</td>

                                                        <td>
                                                            <InputNumber v-model="element.minlength"
                                                                         data-testid="setting-customfield_minlength"
                                                                         class="w-full p-inputtext-sm"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Max-Length</td>
                                                        <td>
                                                            <InputNumber v-model="element.maxlength"
                                                                         data-testid="setting-customfield_maxlength"
                                                                         class="w-full p-inputtext-sm"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Excerpt</td>
                                                        <td>
                                                                    <Textarea v-model="element.excerpt"
                                                                              data-testid="setting-customfield_excerpt"
                                                                              class="w-full"
                                                                    />
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </draggable>
                        </div>

                        <div v-else>

                            <p class="py-2 text-center">
                                No Records
                            </p>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-4">
                            <div class="p-inputgroup">
                                <Dropdown v-model="store.selected_field_type"
                                          data-testid="setting-customfield_fieldtypes"
                                          :options="store.field_types"
                                          optionLabel="name" optionValue="value"
                                          placeholder="Select a type"
                                          class="is-small"
                                          inputClass="p-inputtext-sm"

                                />

                                <Button label="Add"
                                        :disabled="!store.selected_field_type"
                                        data-testid="setting-customfield_field_add"
                                        @click="store.addCustomField"
                                        class="p-button-sm"
                                />
                            </div>
                        </div>

                        <div class="col-12">
                            <Divider class="mb-3 mt-0"/>

                            <div class="p-inputgroup justify-content-end">
                                <Button icon="pi pi-save" label="Save"
                                        class="p-button-sm"
                                        data-testid="setting-customfield_field_save"
                                        @click="store.storeCustomField"
                                />
                            </div>

                        </div>
                    </div>
                </AccordionTab>
            </Accordion>
        </Panel>

    </div>
</template>

<style>
.inactive{
    display: none;
}
.drag{
    cursor: grab;
}
</style>
