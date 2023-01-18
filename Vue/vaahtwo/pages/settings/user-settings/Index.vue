<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

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

    /**
     * Change to upper case
     */
    // await store.watchItem();
});
</script>

<template>
    <div>
        <Card>
            <template #header>
                <h4 class=" font-semibold text-lg">User Settings</h4>
            </template>
            <template #content>
                <Accordion :multiple="true" :activeIndex="store.activeIndex" id="accordionTabContainer">
                    <AccordionTab>
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
                                    <InputSwitch v-model="slotProps.data.value.is_hidden"  class="is-small"/>
                                </template>
                            </Column>
                            <Column field="applyToRegistration" header="Apply To Registration">
                                <template #body="slotProps">
                                    <Checkbox v-model="slotProps.data.value.is_hidden" :binary="true" class="is-small"/>
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
                        <Message severity="info">The inputs of these fields will be stored in <strong>meta</strong> column.</Message>
                        <p class="py-5 text-center">
                            No Records
                        </p>
                        <div class="grid justify-content-between">
                            <div class="col-12 md:col-4">
                                <div class="p-inputgroup">
                                    <Dropdown v-model="store.selectedFieldType"
                                              :options="store.fieldTypes"
                                              optionLabel="name" optionValue="value"
                                              placeholder="Select a type" />
                                    <Button label="Add" @click="store.addCustomField"></Button>
                                </div>
                            </div>
                            <div class="col-12 md:col-3 flex justify-content-end">
                                <Button icon="pi pi-save" label="Save" class="p-button-sm"></Button>
                            </div>
                        </div>
                    </AccordionTab>
                </Accordion>
            </template>
        </Card>
    </div>
</template>
