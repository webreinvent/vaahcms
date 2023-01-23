<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';

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
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();


    document.title = 'User Settings';
});
</script>

<template>
    <div>
        <Card>
            <template #header>
                <div class="flex">
                    <div class="col-12 md:col-6">
                        <h4 class=" font-semibold text-lg">User Settings</h4>
                    </div>
                    <div class="col-12 md:col-6 flex justify-content-end">
                        <Button label="Expand all"
                                icon="pi pi-angle-double-down"
                                data-testid="setting-tabs_expand"
                                @click="store.expandAll"
                                class="p-button-text p-button-secondary" />
                        <Button label="Collapse all"
                                icon="pi pi-angle-double-up"
                                data-testid="setting-tabs_close"
                                @click="store.collapseAll"
                                class="p-button-text p-button-secondary" />
                    </div>
                </div>
            </template>
            <template #content>
                <Accordion :multiple="true" :activeIndex="store.active_index" id="accordionTabContainer">
                    <AccordionTab data-testid="setting-fields_tab">
                        <template #header>
                            <div class="w-full">
                                <div>
                                    <h5 class="font-semibold text-sm">Fields</h5>
                                </div>
                            </div>
                        </template>
                        <DataTable :value="store.field_list" class="p-datatable-sm" showGridlines responsiveLayout="scroll">
                            <Column field="fieldName" header="Field Name">
                                <template #body="slotProps">
                                    {{ slotProps.data.key }}
                                </template>
                            </Column>
                            <Column field="visibilityStatus" header="Is Hidden">
                                <template #body="slotProps">
                                    <InputSwitch v-model="slotProps.data.value.is_hidden"
                                                 data-testid="setting-field_is_hidden"
                                                 class="is-small"
                                                 @input="store.storeField(slotProps.data)"/>
                                </template>
                            </Column>
                            <Column field="applyToRegistration" header="Apply To Registration">
                                <template #body="slotProps">
                                    <Checkbox v-model="slotProps.data.value.to_registration"
                                              @input="store.storeField(slotProps.data)"
                                              data-testid="setting-field_to_registration"
                                              :binary="true"
                                              class="is-small"/>
                                </template>
                            </Column>
                        </DataTable>
                    </AccordionTab>
                    <AccordionTab data-testid="setting-fields_tab">
                        <template #header>
                            <div class="w-full">
                                <div>
                                    <h5 class="font-semibold text-sm">Custom Fields</h5>
                                </div>
                            </div>
                        </template>
                        <Message severity="info">The inputs of these fields will be stored in <strong>meta</strong> column.</Message>

                        <div class="col-12 m-2">
                            <div v-if="store.custom_field_list && store.custom_field_list.value
                                       && store.custom_field_list.value.length > 0">
                                <draggable item-key="id"
                                           v-model="store.custom_field_list.value"
                                           class="dragArea"
                                           :group="{ name: 'g1', pull: 'clone', put: false }"
                                           @start="drag=true"
                                           @end="drag=false">
                                    <template #item = {element}>
                                        <div class="col-12">
                                            <Panel class="draggable-menu">
                                                <template #header>
                                                    <p class="control drag">
                                                        <span>:::</span>
                                                    </p>
                                                    <p class="control field-label">
                                                        <span >{{element.type}}</span>
                                                    </p>
                                                    <div class="control">
                                                        <InputText v-model="element.name"
                                                                   data-testid="setting-customfield_name"
                                                                   @input="store.onInputFieldName(element)"
                                                                   class="w-full"/>
                                                    </div>
                                                    <Button class="control button"
                                                            data-testid="setting-customfield_toggle"
                                                            icon="pi pi-cog"
                                                            @click="store.toggleFieldOptions"></Button>
                                                    <Button class="control button"
                                                            icon="pi pi-trash"
                                                            data-testid="setting-customfield_remove"
                                                            @click="store.deleteGroupField(index)"></Button>
                                                </template>
                                                <div class="p-datatable p-component
                                                p-datatable-responsive-scroll p-datatable-sm">
                                                    <table class="p-datatable-table">
                                                    <tbody class="p-datatable-tbody">
                                                    <tr>
                                                        <td>Is hidden</td>
                                                        <td>
                                                            <InputSwitch v-model="element.is_hidden"
                                                                         data-testid="setting-customfield_is_hidden"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1">
                                                            </InputSwitch>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Apply to Registration</td>
                                                        <td>
                                                            <InputSwitch v-model="element.to_registration"
                                                                         data-testid="setting-customfield_to_registration"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1">
                                                            </InputSwitch>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="element.type === 'password'">
                                                        <td>Is Password Reveal</td>
                                                        <td>
                                                            <InputSwitch v-model="element.is_password_reveal"
                                                                         data-testid="setting-customfield_is_password_reveal"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1">
                                                            </InputSwitch>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Min-Length</td>
                                                        <td><InputNumber v-model="element.minlength"
                                                                         data-testid="setting-customfield_minlength"
                                                                         class="w-full"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Max-Length</td>
                                                        <td><InputNumber v-model="element.maxlength"
                                                                         data-testid="setting-customfield_maxlength"
                                                                         class="w-full"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Excerpt</td>
                                                        <td><Textarea v-model="element.excerpt"
                                                                      data-testid="setting-customfield_excerpt"
                                                                      class="w-full"/></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </Panel>
                                        </div>
                                    </template>
                                </draggable>

                            </div>
                            <div v-else>
                                <p class="py-5 text-center">
                                    No Records
                                </p>
                            </div>
                        </div>
                        <div class="grid justify-content-between">
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.selected_field_type"
                                              data-testid="setting-customfield_fieldtypes"
                                              :options="store.field_types"
                                              optionLabel="name" optionValue="value"
                                              placeholder="Select a type" />
                                    <Button label="Add"
                                            :disabled="!store.selected_field_type"
                                            data-testid="setting-customfield_field_add"
                                            @click="store.addCustomField"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-3 flex justify-content-end">
                                <Button icon="pi pi-save" label="Save"
                                        class="p-button-sm"
                                        data-testid="setting-customfield_field_save"
                                        @click="store.storeCustomField"
                                ></Button>
                            </div>
                        </div>
                    </AccordionTab>
                </Accordion>
            </template>
        </Card>
    </div>
</template>
<style>
.control {
    box-sizing: border-box;
    clear: both;
    font-size: .94rem;
    position: relative;
    text-align: inherit;
    background-color: #fafafa;
    border-color: #dbdbdb;
    box-shadow: none;
    color: #7a7a7a;
}
.button{
    cursor: pointer;
}
.drag{
    cursor: grab;
}
.field-label {
    min-width: 150px;
    pointer-events: none;
}
.inactive{
    display:none
}
</style>
