<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah';
import {useUserSettingStore} from "../../../stores/settings/store-user_setting";
import {useRootStore} from "../../../stores/root";

const store = useUserSettingStore();
const route = useRoute();
const root = useRootStore();

import { useConfirm } from "openvue/useconfirm";

const confirm = useConfirm();

/* ── M6-T4 (F23) — the R4.6 dark-mode preference control.
   The preference is stored per user (F9's contract: the `vh_settings` row
   `category='user_setting'`, `key='dark_mode'`) and travels in the
   `GET /backend/json/assets` payload under `theme.dark_mode` — so the
   control reads its current value from the SAME payload the app boots
   with (no second source of truth), and writes through F9's endpoint
   (`POST /backend/json/dark-mode`) via the root store. The topnav toggle
   (M6-T4a) and this control are two views of one preference: the store
   keeps them in sync, so flipping either is reflected in both. */
const darkModeOptions = [
    {label: vaah().toLabel('light'), value: 'light'},
    {label: vaah().toLabel('dark'), value: 'dark'},
    {label: vaah().toLabel('system'), value: 'system'},
];

const storedDarkMode = () => (root.assets && root.assets.theme && root.assets.theme.dark_mode)
    ? root.assets.theme.dark_mode
    : 'system';

const darkModePreference = ref(storedDarkMode());

// keep the control in step with the payload (the topnav toggle writes the
// same preference)
watch(storedDarkMode, (value) => {
    darkModePreference.value = value;
});

async function onDarkModeChange(value) {
    if (!value) {
        return;
    }
    const res = await root.setDarkMode(value);
    if (!res.success) {
        // the write failed — show the stored preference again, not the
        // value the user picked
        darkModePreference.value = storedDarkMode();
    }
}

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
    <div v-if="store && store.assets">
        <Panel class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div>
                        <h1 class="mr-1 vaah-type-title">{{ store.assets.language_strings.user_settings_heading }}</h1>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="buttons">
                    <Button size="small" :label="store.assets.language_strings.user_setting_expand_all" icon="pi pi-angle-double-down" class=" mr-2" @click="store.expandAll"></Button>
                    <Button size="small" :label="store.assets.language_strings.user_setting_collapse_all" icon="pi pi-angle-double-up" class="" @click="store.collapseAll"></Button>
                </div>
            </template>

            <!-- M6-T4 (F23) — the R4.6 preference control. It sits above the
                 accordion because it is a *user* preference, not one of the
                 field groups below — and it reads the value the app booted
                 with (the assets payload), so it never renders the wrong
                 state. -->
            <div class="grid mb-3" v-if="root.assets && root.assets.theme">
                <div class="col-12">
                    <!-- UT-129 (UAT sweep) — the appearance block sat under
                         the screen's <h1> as an <h3>, skipping a level;
                         the sections below it are <h2>. `vaah-type-subhead`
                         pins the size and weight, so the rendering is
                         unchanged. -->
                    <h2 class="vaah-type-subhead mb-2">{{ vaah().toLabel('appearance') }}</h2>
                </div>
                <div class="col-12 md:col-6">
                    <label for="setting-user-dark-mode" class="vaah-type-caption mb-1">{{ vaah().toLabel('color_scheme') }}</label>
                    <Select inputId="setting-user-dark-mode"
                            size="small"
                            v-model="darkModePreference"
                            :options="darkModeOptions"
                            optionLabel="label"
                            optionValue="value"
                            data-testid="setting-user_dark_mode"
                            class="vc-dense w-full"
                            @update:modelValue="onDarkModeChange"/>
                </div>
            </div>

            <Accordion :multiple="true" :value="store.active_index" id="accordionTabContainer">
                <AccordionPanel :value="0">
                    <AccordionHeader>                        <div class="w-full">
                            <div>
                                <h2 class="vaah-type-section">{{ store.assets.language_strings.fields }}</h2>
                            </div>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <DataTable size="small" rowHover :value="store.field_list" class="" stripedRows scrollable>
                        <Column field="fieldName" :header="store.assets.language_strings.custom_field_name">
                            <template #body="slotProps">
                                {{ vaah().toLabel(slotProps.data.key) }}
                            </template>
                        </Column>

                        <Column field="visibilityStatus" :header="store.assets.language_strings.is_hidden">
                            <template #body="slotProps">
                                <!-- UT-132 — the toggle carried no accessible
                                     name: the column header labelled the
                                     column, not the control. The name now
                                     names the field and the action. -->
                                <ToggleSwitch v-model="slotProps.data.value.is_hidden"
                                             data-testid="setting-field_is_hidden"
                                             class="vc-dense"
                                             :aria-label="vaah().toLabel(slotProps.data.key) + ' — ' + store.assets.language_strings.is_hidden"
                                             @input="store.storeField(slotProps.data)"
                                />
                            </template>
                        </Column>

                        <Column field="applyToRegistration" :header="store.assets.language_strings.apply_to_registration">
                            <template #body="slotProps">
                                <!-- UT-132 — same as the toggle above: the
                                     checkbox needs its own accessible name. -->
                                <Checkbox v-model="slotProps.data.value.to_registration"
                                          @input="store.storeField(slotProps.data)"
                                          data-testid="setting-field_to_registration"
                                          :binary="true"
                                          class="vc-dense"
                                          :aria-label="vaah().toLabel(slotProps.data.key) + ' — ' + store.assets.language_strings.apply_to_registration"
                                />
                            </template>
                        </Column>
                    </DataTable>
                
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel :value="1">
                    <AccordionHeader>                        <div class="w-full">
                            <div>
                                <h2 class="vaah-type-section">{{ store.assets.language_strings.custom_fields }}</h2>
                            </div>
                        </div>
                    </AccordionHeader>
                    <AccordionContent>

                    

                    <Message severity="info" class="mt-0">
                        {{ store.assets.language_strings.custom_fields_message }}
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
                                        <InputGroup class="mb-3">
                                            <Button size="small" label=":::" class="drag" data-testid="setting-customfield_drag_btn" />
                                            <InputText size="small" class="w-2" :model-value="vaah().toLabel(element.type)" disabled />

                                            <InputText size="small" class="w-6" v-model="element.name" data-testid="setting-customfield_name" @input="store.onInputFieldName(element)" :placeholder="store.assets.language_strings.field_name" />

                                            <Button size="small" icon="pi pi-cog" aria-label="Field options" data-testid="setting-customfield_toggle" @click="store.toggleFieldOptions" class="" />

                                            <Button size="small" icon="pi pi-trash" aria-label="Remove field" data-testid="setting-customfield_remove" @click="store.deleteGroupField(index)" class="" />
                                        </InputGroup>

                                        <div class="inactive">
                                            <div class="p-datatable p-component user-settings-customfield-stripes">
                                                <table class="p-datatable-table">
                                                    <tbody class="p-datatable-tbody">
                                                    <tr>
                                                        <td>{{ store.assets.language_strings.is_hidden }}</td>

                                                        <td class="text-right">
                                                            <ToggleSwitch v-model="element.is_hidden"
                                                                         data-testid="setting-customfield_is_hidden"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="vc-dense"
                                                                         :aria-label="element.name + ' — ' + store.assets.language_strings.is_hidden"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{ store.assets.language_strings.apply_to_registration }}</td>

                                                        <td class="text-right">
                                                            <ToggleSwitch v-model="element.to_registration"
                                                                         data-testid="setting-customfield_to_registration"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="vc-dense"
                                                                         :aria-label="element.name + ' — ' + store.assets.language_strings.apply_to_registration"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr v-if="element.type === 'password'">
                                                        <td>{{ store.assets.language_strings.custom_is_password_reveal }}</td>

                                                        <td>
                                                            <ToggleSwitch v-model="element.is_password_reveal"
                                                                         data-testid="setting-customfield_is_password_reveal"
                                                                         v-bind:false-value="0"
                                                                         v-bind:true-value="1"
                                                                         class="vc-dense"
                                                                         :aria-label="element.name + ' — ' + store.assets.language_strings.custom_is_password_reveal"
                                                            />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{ store.assets.language_strings.custom_min_length }}</td>

                                                        <td>
                                                            <InputNumber size="small" v-model="element.minlength" data-testid="setting-customfield_minlength" class="w-full" :aria-label="element.name + ' — ' + store.assets.language_strings.custom_min_length" />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{ store.assets.language_strings.custom_max_length }}</td>
                                                        <td>
                                                            <InputNumber size="small" v-model="element.maxlength" data-testid="setting-customfield_maxlength" class="w-full" :aria-label="element.name + ' — ' + store.assets.language_strings.custom_max_length" />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{ store.assets.language_strings.excerpt }}</td>
                                                        <td>
                                                                    <Textarea v-model="element.excerpt"
                                                                              data-testid="setting-customfield_excerpt"
                                                                              class="w-full"
                                                                              :aria-label="element.name + ' — ' + store.assets.language_strings.excerpt"
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
                                {{ store.assets.language_strings.no_records }}
                            </p>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 md:col-4">
                            <InputGroup>
                                <Select size="small" v-model="store.selected_field_type" data-testid="setting-customfield_fieldtypes" :options="store.field_types" optionLabel="name" optionValue="value" :placeholder="store.assets.language_strings.select_a_type" class="vc-dense" inputClass="" :aria-label="store.assets.language_strings.select_a_type" />

                                <Button size="small" :label="store.assets.language_strings.custom_fields_add_button" :disabled="!store.selected_field_type" data-testid="setting-customfield_field_add" @click="store.addCustomField" class="" />
                            </InputGroup>
                        </div>

                        <div class="col-12">
                            <Divider class="mb-3 mt-0"/>

                            <InputGroup class="justify-content-end">
                                <Button size="small" icon="pi pi-save" :label="store.assets.language_strings.custom_fields_save_button" class="" data-testid="setting-customfield_field_save" @click="store.storeCustomField" />
                            </InputGroup>

                        </div>
                    </div>
                
                    </AccordionContent>
                </AccordionPanel>
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

<style scoped>
/* M4-T1 (F13) — local replacement for the removed v3 `p-datatable-striped`
   class (zero rules for it in the emitted v4 CSS — dead) on this
   hand-rolled per-field view table. The table is plain DOM (no <DataTable>
   component), so the `stripedRows` prop has no host to attach to, and the
   v4 engine's striped rule — which targets the `p-row-odd` row class the
   DataTable component emits on its own rows — cannot match hand-rolled
   rows. The v3 `tr:nth-child(odd)` selector is therefore kept as a local
   style, and the background is bound to the v4 `datatable.row.striped.
   background` token — the OpenVue theme emits it as
   `--p-datatable-row-striped-background` (Nide: surface.50 light / a
   surface.800 mix dark), scheme-aware via the `.app-dark` darkModeSelector
   — the same value the engine styles `stripedRows` DataTable rows with,
   so the stripe is identical to a `stripedRows` DataTable in both light
   and dark (D3 visual parity). Same pattern as `pages/modules/Item.vue`. */
.user-settings-customfield-stripes :deep(tr:nth-child(odd)) {
    background: var(--p-datatable-row-striped-background);
}
</style>
