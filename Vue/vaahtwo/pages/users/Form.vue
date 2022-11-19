<script setup>
import {onMounted, ref, watch} from "vue";
import { useUserStore } from '../../stores/store-users'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useUserStore();
const route = useRoute();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    store.getFormMenu();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

</script>
<template>

    <div class="col-6" >

        <Panel >

            <template class="p-1" #header>


                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>

                </div>


            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button label="Save"
                            v-if="store.item && store.item.id"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()">
                    </Button>
                </div>



            </template>


            <div v-if="store.item && store.assets">

                <VhField label="Email">
                    <InputText
                        class="w-full"
                        v-model="store.item.email">
                    </InputText >
                </VhField>

                <VhField label="Username">
                    <InputText
                        class="w-full"
                        v-model="store.item.username">
                    </InputText >
                </VhField>

                <VhField label="Password">
                    <Password
                        v-model="store.item.password"
                        :feedback="false"
                        id="password"
                        class="w-full"
                        inputClass="w-full"/>
                </VhField>

                <VhField label="Display Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.display_name">
                    </InputText >
                </VhField>

                <VhField label="Title">
                    <Dropdown
                        v-model="store.item.title"
                        :options="store.assets.name_titles"
                        optionLabel="name"
                        optionValue="slug"
                        id="Title"
                        class="w-full"/>
                </VhField>

                <VhField label="Designation">
                    <InputText
                        class="w-full"
                        v-model="store.item.designation">
                    </InputText >
                </VhField>

                <VhField label="First Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.first_name">
                    </InputText >
                </VhField>

                <VhField label="Middle Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.middle_name">
                    </InputText >
                </VhField>

                <VhField label="Last Name">
                    <InputText
                        class="w-full"
                        v-model="store.item.last_name">
                    </InputText >
                </VhField>

                <VhField label="Gender">
                    <SelectButton
                        v-model="store.item.gender"
                        :options="store.gender_options"
                        optionLabel="label"
                        optionValue="value"
                        dataKey="value"
                        aria-labelledby="custom">
                        <template #option="slotProps">
                            <p>{{slotProps.option.label}}</p>
                        </template>
                    </SelectButton>
                </VhField>

                <VhField label="Country Code">
                    <Dropdown
                        v-model="store.item.country_calling_code"
                        :options="store.assets.countries"
                        optionLabel="calling_code"
                        optionValue="calling_code"
                        id="calling_code"
                        class="w-full"/>
                </VhField>

                <VhField label="Phone">
                    <InputText
                        class="w-full"
                        v-model="store.item.phone">
                    </InputText >
                </VhField>

                <VhField label="bio">
                    <Editor
                        :v-model="store.item.bio"
                        editorStyle="height: 320px"/>
                </VhField>

                <VhField label="Website">
                    <InputText
                        class="w-full"
                        v-model="store.item.website">
                    </InputText >
                </VhField>

                <VhField label="Timezone">
                    <AutoComplete
                        v-model="store.item.timezone_name_object"
                        :suggestions="store.filtered_timezone_codes"
                        @complete="store.searchTimezoneCode"
                        @item-select="store.onSelectTimezoneCode"
                        placeholder="Enter Your Country"
                        optionLabel="name"
                        class="w-full"/>
                </VhField>

                <VhField label="Alternate Email">
                    <InputText
                        class="w-full"
                        v-model="store.item.alternate_email">
                    </InputText >
                </VhField>

                <VhField label="Date of Birth">
                    <Calendar
                        id="dob"
                        inputId="basic"
                        v-model="store.item.birth"
                        autocomplete="off"
                        class="w-full"/>
                </VhField>

                <VhField label="Country">
                    <AutoComplete
                        v-model="store.item.country"
                        :suggestions="store.filtered_country_codes"
                        @complete="store.searchCountryCode"
                        @item-select="store.onSelectCountryCode"
                        placeholder="Enter Your Country"
                        optionLabel="name"
                        name="account-country_calling_code"
                        data-testid="account-country_calling_code"
                        class="w-full"/>
                </VhField>

                <VhField label="Foreign User Id">
                    <InputText
                        type="number"
                        class="w-full"
                        v-model="store.item.foreign_user_id">
                    </InputText >
                </VhField>

                <VhField label="Status">
                    <Dropdown
                        v-model="store.item.status"
                        :options="store.status_options"
                        optionLabel="label"
                        optionValue="value"
                        id="country-code"
                        class="w-full"/>
                </VhField>

                <VhField label="Is Active">
                    <SelectButton
                        v-model="store.item.is_active"
                        :options="store.is_active_options"
                        optionLabel="label"
                        optionValue="label">
                        <template #option="slotProps">
                            <span class="text-sm">{{slotProps.option.label}}</span>
                        </template>
                    </SelectButton>
                </VhField>

            </div>
        </Panel>

    </div>

</template>
